<?php
// Endpoint antiguo de desarrollo, deshabilitado para no exponer cuentas o contraseñas.
header('Content-Type: application/json; charset=utf-8');
http_response_code(410);
echo json_encode(['error' => 'Endpoint obsoleto. Utilizá registro.php y login.php.']);
