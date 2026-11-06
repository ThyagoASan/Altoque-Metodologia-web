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
function escaparPublicacion($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis publicaciones | AlToque</title>
    <link rel="stylesheet" href="css.css">
</head>
<body class="admin__cuerpo">
    
    <section class="admin__encabezado usuario__encabezado">
        <h1>Hola, Bienvenido usuario: <?php echo escaparPublicacion($_SESSION["cliente"] ?? "");?></h1>
        <p>Panel de usuario del sistema</p>
    </section>
    <main class="admin__principal">
        <section class="admin__seccion">
            <h2>Mis Publicaciones</h2>
            <table class="admin__tabla">
            <thead>
                    <tr>
                        <th>ID Publicacion</th>
                        <th>Nombre Completo</th>
                        <th>Categoria</th>
                        <th>Zona</th>
                        <th>Descripción</th>
                        <th>Disponible</th>
                        <th>Acción</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody >
                        <?php 
                        $respuesta=mysqli_execute_query(get_conexion(), 'SELECT * FROM publicaciones WHERE id_usuario = ? AND disponible = 1', [$id_usuario]);
                        ?><h2 style="margin-left: 10px;">Activos</h2> <?php
                        if(mysqli_num_rows($respuesta)>0){

                        while($publicacion=mysqli_fetch_array($respuesta)){
                            ?><tr class="fila_tabla">
                            <td ><?php echo escaparPublicacion($publicacion["id"]);?></td>
                            <td ><?php echo escaparPublicacion($publicacion["nombre_completo"]);?></td>
                            <td ><?php echo escaparPublicacion($publicacion["categoria"]);?></td>
                            <td ><?php echo escaparPublicacion($publicacion["zona"]);?></td>
                            <td ><?php echo escaparPublicacion($publicacion["descripcion"]);?></td>
                            <td >
                                <input type="checkbox" checked="true" style="scale:1.8;">
                        </td>
                            <td>
                                <form action="../../backend/borrar_publicacion.php?id=<?php echo escaparPublicacion($publicacion["id"]);?>"method="POST">
                                    <button class="tabla__boton_borrar">Borrar</button>
                                </form>
                            </td>
                            <td><button class="tabla__boton_modificar" >Modificar</button></td>
                            </tr><?php
                        }}                     else{
                            ?> <h2 style="margin: auto;">Vacio</h2> <?php
                        }
                            ?>
                </tbody>
                </table>
                <table class="admin__tabla">
                <thead>
                    <tr>
                        <th>ID Publicacion</th>
                        <th>Nombre Completo</th>
                        <th>Categoria</th>
                        <th>Zona</th>
                        <th>Descripción</th>
                        <th>Disponible</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody >
                        <?php 
                        $respuesta=mysqli_execute_query(get_conexion(), 'SELECT * FROM publicaciones WHERE id_usuario = ? AND disponible = 0 AND id_cliente = 0', [$id_usuario]);
                        ?><h2 style="margin-left: 10px;">No activos</h2> <?php
                        if(mysqli_num_rows($respuesta)>0){
                        while($publicacion=mysqli_fetch_array($respuesta)){
                            ?><tr class="fila_tabla2">
                            <td ><?php echo escaparPublicacion($publicacion["id"]);?></td>
                            <td ><?php echo escaparPublicacion($publicacion["nombre_completo"]);?></td>
                            <td ><?php echo escaparPublicacion($publicacion["categoria"]);?></td>
                            <td ><?php echo escaparPublicacion($publicacion["zona"]);?></td>
                            <td ><?php echo escaparPublicacion($publicacion["descripcion"]);?></td>
                            <td > <button onclick="activar_publicacion(this)" class="tabla__boton_gris">Activar</button></td>
                            <td>
                                <form action="../../backend/borrar_publicacion.php?id=<?php echo escaparPublicacion($publicacion["id"]);?>"method="POST">
                                    <button class="tabla__boton_borrar">Borrar</button>
                                </form>
                            </td>
                            </tr><?php
                        }}
                     else{
                        ?> <h2 style="margin: auto;">Vacio</h2> <?php
                    }
                        ?>
                        
                </tbody>
                
            </table>
            
            <button class="tabla__boton_agregar">
                <a href="publicar.php">Agregar Publicación</a>
            </button>
        </section>
    <section class="admin__seccion" id="section_mis_trabajos">
            <h2>Mis Trabajos </h2>
            <h2>Actuales</h2>
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
                        <th>Acción</th>


                    </tr>
                </thead>
                <tbody >
                        <?php 
                        $respuesta1=mysqli_execute_query(get_conexion(), 'SELECT * FROM historico_publicaciones WHERE id_usuario = ?', [$id_usuario]);
                        while($publicacion=mysqli_fetch_array($respuesta1)){
                            if ($publicacion["estado"] === "Contratado en proceso") {
                            ?><tr class="fila_tabla">
                            <td ><?php echo escaparPublicacion($publicacion["id_publicacion"]);?></td>
                            <td ><?php echo escaparPublicacion($publicacion["id_cliente"]);?></td>
                            <td ><?php echo escaparPublicacion($publicacion["nombre_completo"]);?></td>
                            <td ><?php echo escaparPublicacion($publicacion["categoria"]);?></td>
                            <td ><?php echo escaparPublicacion($publicacion["zona"]);?></td>
                            <td ><?php echo escaparPublicacion($publicacion["descripcion"]);?></td>
                            <td ><?php echo escaparPublicacion($publicacion["estado"]);?></td>      
                            <td><button <?php if($publicacion["estado"]=="No Contratado"){echo("disabled");}?> 
                                    onclick="finalizar_trabajo(this)"class="tabla__boton_gris">Finalizar Trabajo</button>
                                </td>
                            </tr><?php
                        }
                    }?>
                </tbody>
                
            </table>
            <br><br>
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
                        $respuesta1=mysqli_execute_query(get_conexion(), 'SELECT * FROM historico_publicaciones WHERE id_usuario = ?', [$id_usuario]);
                        while($publicacion=mysqli_fetch_array($respuesta1)){
                            if ((int)$publicacion["id_cliente"] > 0 && $publicacion["estado"] === "Finalizado") {
                                ?><tr class="fila_tabla">
                                <td ><?php echo escaparPublicacion($publicacion["id_publicacion"]);?></td>
                                <td ><?php echo escaparPublicacion($publicacion["id_cliente"]);?></td>
                                <td ><?php echo escaparPublicacion($publicacion["nombre_completo"]);?></td>
                                <td ><?php echo escaparPublicacion($publicacion["categoria"]);?></td>
                                <td ><?php echo escaparPublicacion($publicacion["zona"]);?></td>
                                <td ><?php echo escaparPublicacion($publicacion["descripcion"]);?></td>
                                <td ><?php echo escaparPublicacion($publicacion["estado"]);?></td>

                            </tr><?php
                        }
                    }?>
                </tbody>
                
            </table>
        </section>
        <section class="admin__seccion">
            <h2>Mis Clientes</h2>
            <table class="admin__tabla">
            <thead>
                    <tr>
                        <th>ID Publicacion</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody >
                        <?php 
                        $respuesta=mysqli_execute_query(get_conexion(), 'SELECT publicaciones.id AS publicacion_id, usuarios.nombre_completo AS cliente_nombre, usuarios.email AS cliente_email FROM publicaciones INNER JOIN usuarios ON usuarios.id = publicaciones.id_cliente WHERE publicaciones.id_usuario = ?', [$id_usuario]);
                        while($publicacion=mysqli_fetch_array($respuesta)){
                            if (!empty($publicacion["publicacion_id"])) {
                            ?><tr class="fila_tabla">
                            <td ><?php echo escaparPublicacion($publicacion["publicacion_id"]);?></td>
                            <td ><?php echo escaparPublicacion($publicacion["cliente_nombre"]);?></td>
                            <td class="email_dato"><?php echo escaparPublicacion($publicacion["cliente_email"]);?></td>
                           
                            <td><button  class="tabla__boton_copiar" data-email="<?php echo escaparPublicacion($publicacion["cliente_email"]);?>">Copia Email</button></td>
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
