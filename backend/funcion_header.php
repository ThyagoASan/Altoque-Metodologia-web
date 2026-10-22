<?php
require_once __DIR__ . '/conexion/conexion_dal.php';
if (session_status() === PHP_SESSION_NONE) session_start();
$directorioVistas = __DIR__ . '/../FontEnd/html_y_css/';
$vista = 'header_sin_sesion.php';
if (!empty($_SESSION['id_cliente'])) {
    $id = (int) $_SESSION['id_cliente'];
    $stmt = mysqli_prepare(get_conexion(), 'SELECT rol, nombre_completo FROM usuarios WHERE id = ? LIMIT 1');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $usuario = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    if ($usuario) {
        $_SESSION['cliente'] = $usuario['nombre_completo'];
        $vistas = [
            'usuario' => 'header_usuario.php',
            'usuario_premium' => 'header_usuario_premium.php',
            'administrador' => 'header_admin.php'
        ];
        $vista = $vistas[$usuario['rol']] ?? $vista;
    }
}
include $directorioVistas . $vista;
?>