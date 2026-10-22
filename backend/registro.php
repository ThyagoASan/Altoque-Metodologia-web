<?php
require_once __DIR__ . '/conexion/conexion_dal.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Método no permitido'); }
$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$clave = $_POST['contraseña'] ?? '';
if (mb_strlen($nombre) < 3 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($clave) < 8) {
    http_response_code(400);
    exit('Revisá tu nombre, email y contraseña (mínimo 8 caracteres).');
}
$hash = password_hash($clave, PASSWORD_DEFAULT);
$rol = 'usuario';
$stmt = mysqli_prepare(get_conexion(), 'INSERT INTO usuarios (nombre_completo, email, contraseña, rol) VALUES (?, ?, ?, ?)');
mysqli_stmt_bind_param($stmt, 'ssss', $nombre, $email, $hash, $rol);
$ok = mysqli_stmt_execute($stmt);
$error = mysqli_errno(get_conexion());
mysqli_stmt_close($stmt);
if (!$ok) {
    if ($error === 1062) { header('Location: ../FontEnd/html_y_css/registrarse.php?error_usuario_existente=1'); exit; }
    http_response_code(500);
    exit('No se pudo completar el registro.');
}
header('Location: ../FontEnd/html_y_css/sesion.php?registro=1');
exit;
?>