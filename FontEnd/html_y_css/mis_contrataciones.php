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
    </section> <section class="admin__seccion">
            <h2>Mis Contrataciones</h2>
            <h2>En proceso</h2>
            <table class="admin__tabla">
            <thead>
                    <tr>
                        <th>ID Publicacion</th>
                        <th>ID Cliente</th>
                        <th>Nombre Completo</th>
                        <th>Categoria</th>
                        <th>Zona</th>
                        <th>Descripcion</th>
                        <th>estado</th>

                    </tr>
                </thead>
                <tbody >
                        <?php 
                        $id_usuario=$_SESSION["id_cliente"];
                        $respuesta1=mysqli_query(get_conexion(),"select * from historico_publicaciones where id_cliente=$id_usuario and estado='Contratado en proceso'");
                        while($publicacion=mysqli_fetch_array($respuesta1)){
                            if($publicacion["id_cliente"]!=null){
                            ?><tr class="fila_tabla">
                            <td ><?php echo($publicacion["id_publicacion"]);?></td>
                            <td ><?php echo($publicacion["id_cliente"]);?></td>
                            <td ><?php echo($publicacion["nombre_completo"]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["categoria"]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["zona"]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["descripcion"]);?></td>
                            <td ><?php echo($publicacion["estado"]);?></td>
                            </tr><?php
                        }
                    }?>
                </tbody>
                
            </table><br>
            <h2>Ya Finalizados</h2>

            <table class="admin__tabla">
            <thead>
                    <tr>
                        <th>ID Publicacion</th>
                        <th>ID Cliente</th>
                        <th>Nombre Completo</th>
                        <th>Categoria</th>
                        <th>Zona</th>
                        <th>Descripcion</th>
                        <th>estado</th>

                    </tr>
                </thead>
                <tbody >
                        <?php 
                        $id_usuario=$_SESSION["id_cliente"];
                        $respuesta1=mysqli_query(get_conexion(),"select * from historico_publicaciones where id_cliente=$id_usuario and estado='finalizado'");
                        while($publicacion=mysqli_fetch_array($respuesta1)){
                            if($publicacion["id_cliente"]!=null){
                            ?><tr class="fila_tabla">
                            <td ><?php echo($publicacion["id_publicacion"]);?></td>
                            <td ><?php echo($publicacion["id_cliente"]);?></td>
                            <td ><?php echo($publicacion["nombre_completo"]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["categoria"]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["zona"]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["descripcion"]);?></td>
                            <td ><?php echo($publicacion["estado"]);?></td>
                            </tr><?php
                        }
                    }?>
                </tbody>
                
            </table>
        </section> 
    </main>
    <script src="../javascript/perfil_admin.js"></script>
</body>
</html>
