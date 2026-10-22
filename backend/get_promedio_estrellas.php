<?php 
include("conexion/conexion_dal.php");
$id_publicacion=(int)file_get_contents("php://input");
$respuesta=mysqli_query(get_conexion(),"select AVG(estrellas) as promedio FROM estrellas WHERE id_publicacion=$id_publicacion");
header("Content-Type: text/plain");
if(mysqli_num_rows($respuesta)>0){
    while($fila=mysqli_fetch_array($respuesta)){
        echo(($fila["promedio"]));
    }
}else{
    echo('0');
}
?>