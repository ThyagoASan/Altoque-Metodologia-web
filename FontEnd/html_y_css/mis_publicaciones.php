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
                        $id_usuario=$_SESSION["id_cliente"];
                        $respuesta=mysqli_query(get_conexion(),"select * from publicaciones where id_usuario=$id_usuario and disponible=1 and id not in(select id_publicacion from historico_publicaciones hp where hp.id_cliente=publicaciones.id_usuario and hp.estado='Finalizado')");
                        ?><h2 style="margin-left: 10px;">Activos</h2> <?php
                        if(mysqli_num_rows($respuesta)>0){

                        while($publicacion=mysqli_fetch_array($respuesta)){
                            ?><tr class="fila_tabla">
                            <td ><?php echo($publicacion[0]);?></td>
                            <td ><?php echo($publicacion[2]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["categoria"]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["zona"]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["descripcion"]);?></td>
                            <td >
                                <input type="checkbox" checked="true" style="scale:1.8;">
                        </td>
                            <td>
                                <form action="../../backend/borrar_publicacion.php?id=<?php echo($publicacion["id"]);?>"method="POST">
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
                        $id_usuario=$_SESSION["id_cliente"];
                        $respuesta=mysqli_query(get_conexion(),"select * from publicaciones where id_usuario=$id_usuario and disponible=0");
                        ?><h2 style="margin-left: 10px;">No activos</h2> <?php
                        if(mysqli_num_rows($respuesta)>0){
                        while($publicacion=mysqli_fetch_array($respuesta)){
                            ?><tr class="fila_tabla2">
                            <td ><?php echo($publicacion[0]);?></td>
                            <td ><?php echo($publicacion[2]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["categoria"]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["zona"]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["descripcion"]);?></td>
                            <td > <button onclick="activar_publicacion(this)" class="tabla__boton_gris">Activar</button></td>
                            <td>
                                <form action="../../backend/borrar_publicacion.php?id=<?php echo($publicacion["id"]);?>"method="POST">
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
                        $id_usuario=$_SESSION["id_cliente"];
                        $respuesta1=mysqli_query(get_conexion(),"select * from historico_publicaciones where id_usuario=$id_usuario");
                        while($publicacion=mysqli_fetch_array($respuesta1)){
                            if($publicacion["id_usuario"]!=null && $publicacion["estado"]!="Finalizado"){
                            ?><tr class="fila_tabla">
                            <td ><?php echo($publicacion["id_publicacion"]);?></td>
                            <td ><?php echo($publicacion["id_cliente"]);?></td>
                            <td ><?php echo($publicacion["nombre_completo"]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["categoria"]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["zona"]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["descripcion"]);?></td>
                            <td ><?php echo($publicacion["estado"]);?></td>      
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
                        $id_usuario=$_SESSION["id_cliente"];
                        $respuesta1=mysqli_query(get_conexion(),"select * from historico_publicaciones where id_usuario=$id_usuario");
                        while($publicacion=mysqli_fetch_array($respuesta1)){
                            if($publicacion["id_cliente"]!=null and $publicacion["estado"]=="Finalizado"){
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
                        $id_usuario=$_SESSION["id_cliente"];
                        $respuesta=mysqli_query(get_conexion(),"select * from publicaciones inner join usuarios on usuarios.id=publicaciones.id_cliente and id_usuario=$id_usuario" );
                        while($publicacion=mysqli_fetch_array($respuesta)){
                            if($publicacion["id_cliente"]!=null){
                            ?><tr class="fila_tabla">
                            <td ><?php echo($publicacion[0]);?></td>
                            <td ><?php echo($publicacion[9]);?></td>
                            <td class="email_dato"><?php echo($publicacion[10]);?></td>
                           
                            <td><button  class="tabla__boton_copiar" data-email="<?php echo($publicacion[10]);?>">Copia Email</button></td>
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
