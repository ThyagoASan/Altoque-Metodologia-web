<?php
require_once "conexion/conexion_dal.php";
$array_datos=json_decode(file_get_contents("php://input"),true);
$id=$array_datos["id"];
$categoria=$array_datos["categoria"];
$zona=$array_datos["zona"];
$descripcion=$array_datos["descripcion"];
$disponible=$array_datos["disponible"];

$respuesta=mysqli_query(get_conexion(),"select p.* from publicaciones p
          INNER JOIN localidades l ON '$zona' = l.localidad
          WHERE p.id = $id");
if(mysqli_num_rows($respuesta)==0){
    header("Content-Type: text/plain");
    echo("Atención la localidad ingresada no es valida.");
    exit;
}elseif($categoria !='Electricista' && $categoria !='Plomero' &&
 $categoria !='Limpieza' && $categoria !='Jardinería' ){
    header("Content-Type: text/plain");
    echo("Atención la categoria ingresada no es valida.");
    exit;
}elseif($disponible!=0 && $disponible!=1){
    header("Content-Type: text/plain");
    echo("Atención la disponibilidad ingresada no es valida. Solo se permite 1(Activa) o 0(Desactivado).");
    exit;
}
$respuesta_historico_publicaciones=mysqli_query(get_conexion(),"select estado from historico_publicaciones where id_publicacion=$id");
while ($estado=mysqli_fetch_array($respuesta_historico_publicaciones)){
if($estado["estado"]=="Contratado en proceso")
{
    echo("Error, usted no puede volver activar una publicación sin finalizarla primero.");
    exit;
}}

while ($publicacion=mysqli_fetch_array($respuesta)){

if($publicacion["id"]==$id && $publicacion["categoria"]==$categoria && $publicacion["zona"]==$zona && 
$publicacion["descripcion"]==$descripcion && $publicacion["disponible"]==$disponible){
    echo("Error no modificaste ningun dato.");
}else{
mysqli_query(get_conexion(),
"update publicaciones set 
categoria='$categoria',
zona='$zona',
descripcion='$descripcion',
disponible=$disponible  where id='$id'");
header("Content-Type: text/plain");
if($publicacion["id"]==$id && $publicacion["categoria"]==$categoria && $publicacion["zona"]==$zona && 
$publicacion["descripcion"]==$descripcion && $publicacion["disponible"]!=$disponible &&$disponible==1){
echo("Se activo la publicación con exito.");
}
else{
echo("Se modifico la publicación con exito.");
}}
}
?>