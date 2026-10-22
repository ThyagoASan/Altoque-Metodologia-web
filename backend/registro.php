<?php 
include ('conexion/conexion_dal.php');

$nombre=$_POST["nombre"];
$email=$_POST["email"];
$contraseña=$_POST["contraseña"];

$respuesta=mysqli_query(get_conexion(),"select * from usuarios where email='$email'");
$cantidad_de_filas=mysqli_num_rows($respuesta);
if($cantidad_de_filas>0){
    echo "<script> 
    location.href='../FontEnd/html_y_css/registrarse.php';
    alert('error el usuario ya existe.');

    </script>";
    exit;
}
$respuesta_insercion=mysqli_query(get_conexion(),"insert into usuarios (nombre_completo,email,contraseña,rol)values
('$nombre','$email','$contraseña','usuario')");
if($respuesta_insercion){
    echo "<script> 
    alert('todo perfecto.');
    location.href='../FontEnd/html_y_css/sesion.php';
    </script>";
}else{
    echo "<script> 
    alert('error en la consulta sql.');
    location.href='registrarse.php';
    </script>";
}

?>