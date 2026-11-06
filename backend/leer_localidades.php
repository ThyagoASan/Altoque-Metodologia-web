<?php
require_once __DIR__ . '/conexion/conexion_dal.php';
header('Content-Type: application/json; charset=utf-8');
if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST'], true)) {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido.']);
    exit;
}
$resultado = mysqli_query(get_conexion(), 'SELECT localidad FROM localidades ORDER BY localidad ASC');
if (!$resultado) {
    http_response_code(500);
    echo json_encode(['error' => 'No se pudieron consultar las localidades.']);
    exit;
}
$localidades = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    $localidades[] = ['localidad' => $fila['localidad']];
}
echo json_encode($localidades, JSON_UNESCAPED_UNICODE);
