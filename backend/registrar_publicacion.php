<?php 
include("conexion/conexion_dal.php");
if(session_status()==PHP_SESSION_NONE){
session_start();
}
$id_usuario=$_SESSION["id_cliente"];
$nombre=$_SESSION["cliente"];
if($_SERVER["REQUEST_METHOD"]=="POST"&& !empty($_POST)){
$categoria=$_POST["categoria"];
$zona=$_POST["zona"];
$descripcion=$_POST["descripcion"];
}else{//hacer registro finalizar y crear una nueva
    $datos=json_decode(file_get_contents("php://input"),true);
    $id_publicacion=$datos["id_publicacion"];
    $categoria=$datos["categoria"];
    $zona=$datos["zona"];
    $descripcion=$datos["descripcion"];
    mysqli_query(get_conexion(),"update historico_publicaciones set estado='Finalizado' where id_publicacion=$id_publicacion");
}
$respuesta=mysqli_query(get_conexion(),"select * from localidades where localidad='$zona'");
if(mysqli_num_rows($respuesta)>0){
    mysqli_query(get_conexion(),"insert into publicaciones(id_usuario,nombre_completo,categoria,zona,descripcion,disponible)values
    ('$id_usuario','$nombre','$categoria','$zona','$descripcion',true)");
    $id_publicacion=mysqli_insert_id(get_conexion());
    mysqli_query(get_conexion(),"insert into historico_publicaciones(id_publicacion,id_usuario,nombre_completo,categoria,zona,descripcion,disponible,estado)values
    ($id_publicacion,$id_usuario,'$nombre','$categoria','$zona','$descripcion',true,'No Contratado')");
    echo"<script>alert('Se registro su publicación con exito.');
    location.href='../FontEnd/html_y_css/pagina1.php'</script>";
}
else{
    echo('<script>         
alert("Atención!!! Error la localidad ingresada no es valida, intente de nuevo.");
window.history.back();
</script>');
}

?>
