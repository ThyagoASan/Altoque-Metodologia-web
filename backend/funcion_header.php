<?php
include ("conexion/conexion_dal.php");
error_reporting(0);
session_start();
$sesion=$_SESSION["cliente"];
if($sesion==null || $sesion==""){
    include("header_sin_sesion.php");
}else{
    $respuesta=mysqli_query(get_conexion(),"select * from usuarios where nombre_completo='$sesion'");
    while($usuario =mysqli_fetch_array($respuesta)){
    if($usuario["rol"]=="usuario"){
        include("header_usuario.php");
    }else if($usuario["rol"]=="usuario_premium"){
        include("header_usuario_premium.php");
    }elseif($usuario["rol"]=="administrador"){
        include("header_admin.php");
    }else{
        include("header_sin_sesion.php");
    }
    }
}
?>