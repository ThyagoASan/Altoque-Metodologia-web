<?php 
include("conexion/conexion_dal.php");
$datos=json_decode(file_get_contents("php://input"),true);

mysqli_query(get_conexion(),"insert into estrellas (id_usuario,id_publicacion,estrellas)values
(".$datos["id_usuario"].",".$datos["id_publicacion"].",".$datos["estrellas"].")");
?>