<?php
require_once __DIR__ . '/conexion/conexion_dal.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Método no permitido'); }
if (empty($_SESSION['id_cliente']) || empty($_SESSION['cliente'])) {
    header('Location: ../FontEnd/html_y_css/sesion.php');
    exit;
}
$id = filter_input(INPUT_GET, 'id_publicacion', FILTER_VALIDATE_INT);
$texto = trim($_POST['comentario'] ?? '');
if (!$id || $texto === '' || mb_strlen($texto) > 400) {
    http_response_code(400);
    exit('Comentario inválido (máximo 400 caracteres).');
}
$idUsuario = (int) $_SESSION['id_cliente'];
$stmt = mysqli_prepare(get_conexion(), 'SELECT nombre_completo FROM usuarios WHERE id = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'i', $idUsuario);
mysqli_stmt_execute($stmt);
$usuario = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$usuario) { http_response_code(403); exit('Usuario inválido.'); }
$stmt = mysqli_prepare(get_conexion(), 'SELECT id FROM publicaciones WHERE id = ? AND id_usuario <> ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'ii', $id, $idUsuario);
mysqli_stmt_execute($stmt);
$publicacion = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$publicacion) { http_response_code(403); exit('No podés comentar una publicación propia o inexistente.'); }
$nombre = $usuario['nombre_completo'];
$fecha = date('Y-m-d');
$stmt = mysqli_prepare(get_conexion(), 'INSERT INTO comentarios (id_publicacion, nombre_usuario, comentario, fecha) VALUES (?, ?, ?, ?)');
mysqli_stmt_bind_param($stmt, 'isss', $id, $nombre, $texto, $fecha);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
if (!$ok) { http_response_code(500); exit('No fue posible guardar el comentario.'); }
header('Location: ../FontEnd/html_y_css/perfil.php?id=' . $id);
exit;
