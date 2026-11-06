<?php 
require_once __DIR__ . "/../../backend/conexion/conexion_dal.php";
if(session_status()==PHP_SESSION_NONE){
    session_start();
}
if (empty($_SESSION['id_cliente'])) {
    header('Location: sesion.php');
    exit;
}
$id_usuario = (int) $_SESSION['id_cliente'];
function escaparContratacion($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis contrataciones | AlToque</title>
    <link rel="stylesheet" href="css.css">
</head>
<body class="admin__cuerpo">
    
    <section class="admin__encabezado usuario__encabezado">
        <h1>Hola, Bienvenido usuario: <?php echo escaparContratacion($_SESSION["cliente"] ?? "");?></h1>
        <p>Panel de usuario del sistema</p>
    </section>
    <main class="admin__principal">
    <section class="admin__seccion">
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
                        $respuesta1=mysqli_execute_query(get_conexion(), "SELECT * FROM historico_publicaciones WHERE id_cliente = ? AND estado = 'Contratado en proceso'", [$id_usuario]);
                        while($publicacion=mysqli_fetch_array($respuesta1)){
                            if($publicacion["id_cliente"]!=null){
                            ?><tr class="fila_tabla">
                            <td ><?php echo escaparContratacion($publicacion["id_publicacion"]);?></td>
                            <td ><?php echo escaparContratacion($publicacion["id_cliente"]);?></td>
                            <td ><?php echo escaparContratacion($publicacion["nombre_completo"]);?></td>
                            <td><?php echo escaparContratacion($publicacion["categoria"]);?></td>
                            <td><?php echo escaparContratacion($publicacion["zona"]);?></td>
                            <td><?php echo escaparContratacion($publicacion["descripcion"]);?></td>
                            <td ><?php echo escaparContratacion($publicacion["estado"]);?></td>
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
                        $respuesta1=mysqli_execute_query(get_conexion(), "SELECT * FROM historico_publicaciones WHERE id_cliente = ? AND estado = 'Finalizado'", [$id_usuario]);
                        while($publicacion=mysqli_fetch_array($respuesta1)){
                            if($publicacion["id_cliente"]!=null){
                            ?><tr class="fila_tabla">
                            <td ><?php echo escaparContratacion($publicacion["id_publicacion"]);?></td>
                            <td ><?php echo escaparContratacion($publicacion["id_cliente"]);?></td>
                            <td ><?php echo escaparContratacion($publicacion["nombre_completo"]);?></td>
                            <td><?php echo escaparContratacion($publicacion["categoria"]);?></td>
                            <td><?php echo escaparContratacion($publicacion["zona"]);?></td>
                            <td><?php echo escaparContratacion($publicacion["descripcion"]);?></td>
                            <td ><?php echo escaparContratacion($publicacion["estado"]);?></td>
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
