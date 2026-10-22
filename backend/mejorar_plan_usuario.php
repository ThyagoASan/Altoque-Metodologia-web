<?php 
include("conexion/conexion_dal.php");
if(session_status()==PHP_SESSION_NONE){
session_start();
}
$id_usuario=file_get_contents("php://input");
mysqli_query(get_conexion(),"update usuarios set rol='usuario_premium' where id=$id_usuario");
?>