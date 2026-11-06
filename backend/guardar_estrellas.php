<?php
require_once __DIR__ . '/conexion/conexion_dal.php';
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}
if (empty($_SESSION['id_cliente'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Iniciá sesión para calificar.']);
    exit;
}
$datos = json_decode(file_get_contents('php://input'), true);
$idPublicacion = filter_var($datos['id_publicacion'] ?? null, FILTER_VALIDATE_INT);
$estrellas = filter_var($datos['estrellas'] ?? null, FILTER_VALIDATE_INT);
$idUsuario = (int) $_SESSION['id_cliente'];
if (!$idPublicacion || !$estrellas || $estrellas < 1 || $estrellas > 5) {
    http_response_code(400);
    echo json_encode(['error' => 'Calificación inválida.']);
    exit;
}
$stmt = mysqli_prepare(get_conexion(), 'SELECT id FROM publicaciones WHERE id = ? AND id_usuario <> ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'ii', $idPublicacion, $idUsuario);
mysqli_stmt_execute($stmt);
$existe = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$existe) {
    http_response_code(404);
    echo json_encode(['error' => 'Publicación inexistente o propia.']);
    exit;
}
$stmt = mysqli_prepare(get_conexion(), 'SELECT estrellas FROM estrellas WHERE id_publicacion = ? AND id_usuario = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'ii', $idPublicacion, $idUsuario);
mysqli_stmt_execute($stmt);
$anterior = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if ($anterior) {
    $stmt = mysqli_prepare(get_conexion(), 'UPDATE estrellas SET estrellas = ? WHERE id_publicacion = ? AND id_usuario = ?');
    mysqli_stmt_bind_param($stmt, 'iii', $estrellas, $idPublicacion, $idUsuario);
} else {
    $stmt = mysqli_prepare(get_conexion(), 'INSERT INTO estrellas (id_usuario, id_publicacion, estrellas) VALUES (?, ?, ?)');
    mysqli_stmt_bind_param($stmt, 'iii', $idUsuario, $idPublicacion, $estrellas);
}
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
if (!$ok) {
    http_response_code(500);
    echo json_encode(['error' => 'No se pudo guardar la calificación.']);
    exit;
}
echo json_encode(['ok' => true]);
