<?php 
include ("conexion/conexion_dal.php");
$respuesta=mysqli_query(get_conexion(),"select * from localidades");
$array=[];
while($localidad=mysqli_fetch_array($respuesta)){
$array[]=["localidad" => $localidad["localidad"]];
}
header("Content-Type: application/json");
echo(json_encode($array));
?>