<?php
$conexion=mysqli_connect("localhost","root","","base_del_proyecto");
function get_conexion(){
global $conexion;
    return $conexion;
}
?>
