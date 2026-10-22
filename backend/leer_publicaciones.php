<?php
require_once "conexion/conexion_dal.php";
header("Content-Type: application/json; charset=utf-8");

$valores = json_decode(file_get_contents("php://input"), true);
$filtros_permitidos = ["zona", "categoria"];
if (!is_array($valores) || count($valores) < 2 ||
    !in_array($valores[0], $filtros_permitidos, true) || !is_string($valores[1])) {
    http_response_code(400);
    echo json_encode(["error" => "Filtro de busqueda invalido."]);
    exit;
}

$campo = $valores[0]; // Nombre de columna controlado por lista permitida.
$busqueda = trim($valores[1]) . "%";
$sql = "SELECT p.id, p.id_usuario, p.nombre_completo, p.categoria, p.zona,
               p.descripcion, u.rol
        FROM publicaciones p
        INNER JOIN usuarios u ON u.id = p.id_usuario
        WHERE p.$campo LIKE ? AND p.disponible = 1";

$stmt = mysqli_prepare(get_conexion(), $sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(["error" => "No se pudo preparar la busqueda."]);
    exit;
}
mysqli_stmt_bind_param($stmt, "s", $busqueda);
if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    echo json_encode(["error" => "No se pudo realizar la busqueda."]);
    mysqli_stmt_close($stmt);
    exit;
}

$resultado = mysqli_stmt_get_result($stmt);
$publicaciones = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    $publicaciones[] = [
        "id" => (int) $fila["id"],
        "id_usuario" => (int) $fila["id_usuario"],
        "nombre" => $fila["nombre_completo"],
        "categoria" => $fila["categoria"],
        "zona" => $fila["zona"],
        "descripcion" => $fila["descripcion"],
        "rol" => $fila["rol"]
    ];
}
echo json_encode($publicaciones, JSON_UNESCAPED_UNICODE);
mysqli_stmt_close($stmt);
?>