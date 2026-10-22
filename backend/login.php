<?php
require_once __DIR__ . '/conexion/conexion_dal.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['contraseña'] ?? '';
$stmt = mysqli_prepare(get_conexion(), 'SELECT id, nombre_completo, contraseña FROM usuarios WHERE email = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 's', $email);
mysqli_stmt_execute($stmt);
$usuario = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if (!$usuario || !password_verify($password, $usuario['contraseña'])) {
    header('Location: ../FontEnd/html_y_css/sesion.php?error=1');
    exit;
}
session_start();
session_regenerate_id(true);
$_SESSION['id_cliente'] = (int) $usuario['id'];
$_SESSION['cliente'] = $usuario['nombre_completo'];
header('Location: ../FontEnd/html_y_css/pagina1.php');
exit;
