<?php
require_once __DIR__ . '/conexion/conexion_dal.php';
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: text/plain; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Método no permitido.'); }
if (empty($_SESSION['id_cliente'])) { http_response_code(401); exit('Iniciá sesión.'); }
$idUsuario = (int) $_SESSION['id_cliente'];
$stmt = mysqli_prepare(get_conexion(), 'SELECT rol FROM usuarios WHERE id = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'i', $idUsuario);
mysqli_stmt_execute($stmt);
$usuario = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$usuario) { http_response_code(403); exit('Sin permisos.'); }
$esAdmin = $usuario['rol'] === 'administrador';
$contenido = trim(file_get_contents('php://input'));
$id = filter_var($_POST['id'] ?? $_GET['id'] ?? $contenido, FILTER_VALIDATE_INT);
if (!$id || $id <= 0) { http_response_code(400); exit('ID inválido.'); }
$stmt = mysqli_prepare(get_conexion(), 'SELECT id_usuario FROM publicaciones WHERE id = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$publicacion = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$publicacion) { http_response_code(404); exit('Publicación inexistente.'); }
if (!$esAdmin && (int)$publicacion['id_usuario'] !== $idUsuario) { http_response_code(403); exit('No podés eliminar esta publicación.'); }
$stmt = mysqli_prepare(get_conexion(), 'DELETE FROM publicaciones WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
if (!$ok) { http_response_code(409); exit('No se pudo eliminar. Revisá las referencias relacionadas.'); }
if (isset($_GET['id']) || isset($_POST['id'])) {
    header('Location: ../FontEnd/html_y_css/perfil_admin.php');
    exit;
}
echo 'Publicación eliminada correctamente.';
