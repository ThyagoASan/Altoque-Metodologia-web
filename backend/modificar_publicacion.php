<?php
require_once __DIR__ . '/conexion/conexion_dal.php';
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: text/plain; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Método no permitido.'); }
if (empty($_SESSION['id_cliente'])) { http_response_code(401); exit('Iniciá sesión.'); }
$datos = json_decode(file_get_contents('php://input'), true);
if (!is_array($datos)) { http_response_code(400); exit('Datos inválidos.'); }
$id = filter_var($datos['id'] ?? null, FILTER_VALIDATE_INT);
$categoria = trim((string)($datos['categoria'] ?? ''));
$zona = trim((string)($datos['zona'] ?? ''));
$descripcion = trim((string)($datos['descripcion'] ?? ''));
$disponible = filter_var($datos['disponible'] ?? null, FILTER_VALIDATE_INT);
if (!$id || !in_array($categoria, ['Electricista', 'Plomero', 'Limpieza', 'Jardinería'], true)
    || $zona === '' || mb_strlen($zona) > 50 || $descripcion === '' || mb_strlen($descripcion) > 200
    || !in_array($disponible, [0, 1], true)) {
    http_response_code(400); exit('Revisá la categoría, zona, descripción y disponibilidad.');
}
$conexion = get_conexion();
$idUsuario = (int) $_SESSION['id_cliente'];
$stmt = mysqli_prepare($conexion, 'SELECT rol FROM usuarios WHERE id = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'i', $idUsuario);
mysqli_stmt_execute($stmt);
$usuario = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$usuario) { http_response_code(403); exit('Sin permisos.'); }
$stmt = mysqli_prepare($conexion, 'SELECT id_usuario, categoria, zona, descripcion, disponible FROM publicaciones WHERE id = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$publicacion = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$publicacion) { http_response_code(404); exit('Publicación inexistente.'); }
if ($usuario['rol'] !== 'administrador' && (int)$publicacion['id_usuario'] !== $idUsuario) {
    http_response_code(403); exit('No podés modificar esta publicación.');
}
$stmt = mysqli_prepare($conexion, 'SELECT id FROM localidades WHERE localidad = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 's', $zona);
mysqli_stmt_execute($stmt);
$localidad = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$localidad) { http_response_code(400); exit('Atención la localidad ingresada no es valida.'); }
if ($disponible === 1 && (int)$publicacion['disponible'] === 0) {
    $stmt = mysqli_prepare($conexion, "SELECT estado FROM historico_publicaciones WHERE id_publicacion = ? AND estado = 'Contratado en proceso' LIMIT 1");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $enProceso = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    if ($enProceso) { http_response_code(409); exit('Error, usted no puede volver activar una publicación sin finalizarla primero.'); }
}
if ($publicacion['categoria'] === $categoria && $publicacion['zona'] === $zona
    && $publicacion['descripcion'] === $descripcion && (int)$publicacion['disponible'] === $disponible) {
    exit('Error no modificaste ningun dato.');
}
$stmt = mysqli_prepare($conexion, 'UPDATE publicaciones SET categoria = ?, zona = ?, descripcion = ?, disponible = ? WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'sssii', $categoria, $zona, $descripcion, $disponible, $id);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
if (!$ok) { http_response_code(500); exit('No se pudo modificar la publicación.'); }
echo 'Se modifico la publicación con exito.';
