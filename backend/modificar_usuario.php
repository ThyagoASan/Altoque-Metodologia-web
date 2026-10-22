<?php
require_once __DIR__ . '/conexion/conexion_dal.php';
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['id_cliente'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Debés iniciar sesión.']);
    exit;
}
$datos = json_decode(file_get_contents('php://input'), true);
$actual = $datos['actual'] ?? '';
$nueva = $datos['nueva'] ?? '';
if (!is_string($actual) || !is_string($nueva) || strlen($nueva) < 8) {
    http_response_code(400);
    echo json_encode(['error' => 'La nueva contraseña debe tener al menos 8 caracteres.']);
    exit;
}
$id = (int) $_SESSION['id_cliente'];
$stmt = mysqli_prepare(get_conexion(), 'SELECT contraseña FROM usuarios WHERE id = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$fila = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$fila || !password_verify($actual, $fila['contraseña'])) {
    http_response_code(403);
    echo json_encode(['error' => 'La contraseña actual no coincide.']);
    exit;
}
$hash = password_hash($nueva, PASSWORD_DEFAULT);
$stmt = mysqli_prepare(get_conexion(), 'UPDATE usuarios SET contraseña = ? WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'si', $hash, $id);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
if (!$ok) { http_response_code(500); echo json_encode(['error'=>'No se pudo actualizar la contraseña.']); exit; }
echo json_encode(['mensaje' => 'Contraseña actualizada correctamente.']);
