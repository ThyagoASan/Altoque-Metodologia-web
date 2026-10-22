<?php
include("conexion/conexion_dal.php");
$dato=file_get_contents("php://input");
if(empty($dato)){
$id_publicacion=$_GET["id"];
mysqli_query(get_conexion(),"delete from publicaciones where id=$id_publicacion");
echo"<script> 
alert('Se elimino la publicación con exito.');
window.location.href=document.referrer;
</script>";}
else{//javascript
    $id_publicacion=$dato;
    mysqli_query(get_conexion(),"delete from publicaciones where id=$id_publicacion");
}
?>