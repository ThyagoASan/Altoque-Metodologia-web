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
$nombre = $_SESSION['cliente'];
$fecha = date('Y-m-d');
$stmt = mysqli_prepare(get_conexion(), 'INSERT INTO comentarios (id_publicacion, nombre_usuario, comentario, fecha) VALUES (?, ?, ?, ?)');
mysqli_stmt_bind_param($stmt, 'isss', $id, $nombre, $texto, $fecha);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
if (!$ok) { http_response_code(500); exit('No fue posible guardar el comentario.'); }
header('Location: ../FontEnd/html_y_css/perfil.php?id=' . $id);
exit;
