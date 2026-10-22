<?php 
include ("../../backend/conexion/conexion_dal.php");
if(session_status()==PHP_SESSION_NONE){
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="css.css">
</head>
<body class="admin__cuerpo">
    
    <section class="admin__encabezado usuario__encabezado">
        <h1>Hola, Bienvenido usuario: <?php echo($_SESSION["cliente"]);?></h1>
        <p>Panel de usuario del sistema</p>
    </section>
    <main class="admin__principal">
    <section class="admin__seccion">
            <h2>Mis Publicaciones</h2>
            <table class="admin__tabla">
            <thead>
                    <tr>
                        <th>ID Usuario</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Contraseña</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody >
                        <?php 
                        $id_usuario=$_SESSION["id_cliente"];
                        $respuesta=mysqli_query(get_conexion(),"select * from usuarios where id=$id_usuario");
                        ?><h2 style="margin-left: 10px;">Usuario</h2> <?php
                        while($publicacion=mysqli_fetch_array($respuesta)){
                            ?><tr class="fila_tabla">
                            <td ><?php echo($publicacion["id"]);?></td>
                            <td><?php echo($publicacion["nombre_completo"]);?></td>
                            <td ><?php echo($publicacion["email"]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["contraseña"]);?></td>
                            <td><button class="boton_modificar_usuario" >Modificar Contraseña</button></td>
                            </tr><?php
                        }
                            ?>
                </tbody>
                </table>
    </main>
    <script src="../javascript/perfil_admin.js"></script>
</body>
</html>
