<?php
require_once __DIR__ . '/conexion/conexion_dal.php';
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: text/plain; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido.');
}
if (empty($_SESSION['id_cliente'])) {
    http_response_code(401);
    exit('Iniciá sesión para publicar.');
}
$idUsuario = (int) $_SESSION['id_cliente'];
$conexion = get_conexion();
$esFormulario = !empty($_POST);
$datos = $esFormulario ? $_POST : json_decode(file_get_contents('php://input'), true);
if (!is_array($datos)) {
    http_response_code(400);
    exit('Datos inválidos.');
}
$categoria = trim((string)($datos['categoria'] ?? ''));
$zona = trim((string)($datos['zona'] ?? ''));
$descripcion = trim((string)($datos['descripcion'] ?? ''));
$idAnterior = filter_var($datos['id_publicacion'] ?? null, FILTER_VALIDATE_INT);
if (!in_array($categoria, ['Electricista', 'Plomero', 'Limpieza', 'Jardinería'], true)
    || $zona === '' || mb_strlen($zona) > 50
    || $descripcion === '' || mb_strlen($descripcion) > 200) {
    http_response_code(400);
    exit('Revisá categoría, zona y descripción (máximo 200 caracteres).');
}
$stmt = mysqli_prepare($conexion, 'SELECT nombre_completo FROM usuarios WHERE id = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'i', $idUsuario);
mysqli_stmt_execute($stmt);
$usuario = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$usuario) {
    http_response_code(403);
    exit('Usuario inválido.');
}
$nombre = $usuario['nombre_completo'];
$stmt = mysqli_prepare($conexion, 'SELECT id FROM localidades WHERE localidad = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 's', $zona);
mysqli_stmt_execute($stmt);
$localidad = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$localidad) {
    http_response_code(400);
    exit('Atención: la localidad ingresada no es válida.');
}
if (!$esFormulario && !$idAnterior) {
    http_response_code(400);
    exit('Falta la publicación que querés finalizar.');
}
mysqli_begin_transaction($conexion);
try {
    if (!$esFormulario) {
        $stmt = mysqli_prepare($conexion, 'SELECT id FROM publicaciones WHERE id = ? AND id_usuario = ? AND disponible = 0 AND id_cliente > 0 LIMIT 1 FOR UPDATE');
        mysqli_stmt_bind_param($stmt, 'ii', $idAnterior, $idUsuario);
        mysqli_stmt_execute($stmt);
        $anterior = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        mysqli_stmt_close($stmt);
        if (!$anterior) {
            throw new DomainException('No podés finalizar una publicación ajena o sin contratar.');
        }
        $estado = 'Finalizado';
        $stmt = mysqli_prepare($conexion, "UPDATE historico_publicaciones SET estado = ? WHERE id_publicacion = ? AND estado = 'Contratado en proceso'");
        mysqli_stmt_bind_param($stmt, 'si', $estado, $idAnterior);
        mysqli_stmt_execute($stmt);
        $actualizadas = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        if ($actualizadas < 1) {
            throw new DomainException('No existe una contratación en proceso para finalizar.');
        }
    }
    $stmt = mysqli_prepare($conexion, 'INSERT INTO publicaciones (id_usuario, nombre_completo, categoria, zona, descripcion, disponible) VALUES (?, ?, ?, ?, ?, 1)');
    mysqli_stmt_bind_param($stmt, 'issss', $idUsuario, $nombre, $categoria, $zona, $descripcion);
    if (!mysqli_stmt_execute($stmt)) throw new RuntimeException('No se pudo crear la publicación.');
    $idNueva = mysqli_insert_id($conexion);
    mysqli_stmt_close($stmt);
    $estadoNuevo = 'No Contratado';
    $stmt = mysqli_prepare($conexion, 'INSERT INTO historico_publicaciones (id_publicacion, id_usuario, nombre_completo, categoria, zona, descripcion, disponible, estado) VALUES (?, ?, ?, ?, ?, ?, 1, ?)');
    mysqli_stmt_bind_param($stmt, 'iisssss', $idNueva, $idUsuario, $nombre, $categoria, $zona, $descripcion, $estadoNuevo);
    if (!mysqli_stmt_execute($stmt)) throw new RuntimeException('No se pudo guardar el historial.');
    mysqli_stmt_close($stmt);
    mysqli_commit($conexion);
    if ($esFormulario) {
        header('Location: ../FontEnd/html_y_css/pagina1.php?publicado=1');
        exit;
    }
    echo 'Trabajo finalizado y nueva publicación creada.';
} catch (Throwable $error) {
    mysqli_rollback($conexion);
    http_response_code($error instanceof DomainException ? 403 : 500);
    echo $error instanceof DomainException ? $error->getMessage() : 'No se pudo completar la operación.';
}
