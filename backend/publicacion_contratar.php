<?php
require_once __DIR__ . '/conexion/conexion_dal.php';
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: text/plain; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Método no permitido.'); }
if (empty($_SESSION['id_cliente'])) { http_response_code(401); exit('Usted tiene que inicio sesión para contratar.'); }
$id_publicacion = filter_var(trim(file_get_contents('php://input')), FILTER_VALIDATE_INT);
$id_cliente = (int) $_SESSION['id_cliente'];
if (!$id_publicacion) { http_response_code(400); exit('Publicación inválida.'); }
$conexion = get_conexion();
mysqli_begin_transaction($conexion);
try {
    $stmt = mysqli_prepare($conexion, 'UPDATE publicaciones SET disponible = 0, id_cliente = ? WHERE id = ? AND disponible = 1 AND id_usuario <> ?');
    mysqli_stmt_bind_param($stmt, 'iii', $id_cliente, $id_publicacion, $id_cliente);
    mysqli_stmt_execute($stmt);
    $afectadas = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);
    if ($afectadas !== 1) throw new RuntimeException('La publicación ya no está disponible o es tuya.');
    $estado = 'Contratado en proceso';
    $stmt = mysqli_prepare($conexion, 'UPDATE historico_publicaciones SET disponible = 0, id_cliente = ?, estado = ? WHERE id_publicacion = ?');
    mysqli_stmt_bind_param($stmt, 'isi', $id_cliente, $estado, $id_publicacion);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_commit($conexion);
    echo 'Contratación registrada. Consultá el estado en Mis contrataciones.';
} catch (Throwable $ex) {
    mysqli_rollback($conexion);
    http_response_code(409);
    echo $ex instanceof RuntimeException ? $ex->getMessage() : 'No se pudo registrar la contratación.';
}
