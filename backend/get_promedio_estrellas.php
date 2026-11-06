<?php
require_once __DIR__ . '/conexion/conexion_dal.php';
header('Content-Type: text/plain; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido.');
}
$id = filter_var(trim(file_get_contents('php://input')), FILTER_VALIDATE_INT);
if (!$id || $id <= 0) {
    http_response_code(400);
    exit('Publicación inválida.');
}
$stmt = mysqli_prepare(get_conexion(), 'SELECT COALESCE(ROUND(AVG(estrellas), 1), 0) AS promedio FROM estrellas WHERE id_publicacion = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$fila = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
echo (string) ($fila['promedio'] ?? 0);
