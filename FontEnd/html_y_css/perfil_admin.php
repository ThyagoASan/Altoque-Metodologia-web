<?php 
include ("../../backend/conexion/conexion_dal.php");
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
    
    <section class="admin__encabezado">
        <h1>Hola, Bienvenido Administrador</h1>
        <p>Panel de administración del sistema</p>
    </section>
    <main class="admin__principal">
        <section class="admin__seccion">
            <h2>Usuarios</h2>
            <table class="admin__tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Contraseña</th>
                        <th>Rol</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                        <?php 
                        $respuesta=mysqli_query(get_conexion(),"select * from usuarios");
                        while($usuario=mysqli_fetch_array($respuesta)){
                            ?><tr>
                            <td> <?php echo ($usuario["id"]);?></td><?php
                            ?><td> <?php echo ($usuario["nombre_completo"]);?></td><?php
                            ?><td> <?php echo ($usuario["email"]);?></td><?php
                            ?><td> <?php echo ($usuario["contraseña"]);?></td><?php
                            ?><td> <?php echo ($usuario["rol"]);?></td>
                        <td>
                        <button class="tabla__boton_borrar">
                            Borrar
                        </button>
                        </td>
                        </tr>
                        <?php } ?>

                </tbody>
            </table>
        </section>
        <section class="admin__seccion">
            <h2>Publicaciones</h2>
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
                <tbody>
                        <?php 
                        $respuesta=mysqli_query(get_conexion(),"select * from publicaciones");
                        while($publicacion=mysqli_fetch_array($respuesta)){
                            ?><tr class="fila_tabla">
                            <td ><?php echo($publicacion["id"]);?></td>
                            <td ><?php echo($publicacion["nombre_completo"]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["categoria"]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["zona"]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["descripcion"]);?></td>
                            <td contenteditable="true"><?php echo($publicacion["disponible"]);?></td>
                            <td>
                                <form action="../../backend/borrar_publicacion.php?id=<?php echo($publicacion["id"]);?>"method="POST">
                                    <button class="tabla__boton_borrar">Borrar</button>
                                </form>
                            </td>
                            <td><button class="tabla__boton_modificar" >Modificar</button></td>
                            </tr><?php
                        }?>
                </tbody>
            </table>
        </section>
    </main>
    <script src="../javascript/perfil_admin.js"></script>
</body>
</html>
