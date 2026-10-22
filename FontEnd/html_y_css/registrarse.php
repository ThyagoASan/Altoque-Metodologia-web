<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Registrarse</title>
        <link rel="stylesheet" href="css.css" />
    </head>
    <body class="body-registrarse">
        <form action="../../backend/registro.php" method="POST" class="formulario1">
            <h2>Formulario Registrarse</h2>
            <label class="label1" for="nombre_completo_registro">Nombre Completo</label>
            <input
                class="input1"
                name="nombre"
                type="text"
                id="nombre_completo_registro"
                required
                minlength="6"
                placeholder="Pedro Ramirez"
            />
            <label class="label1" for="email_registro">Email</label>
            <input
                class="input1"
                name="email"
                id="email_registro"
                type="email"
                required
                placeholder="PedroRamirez@gmail.com"
            />

            <label class="label2"
                >Contraseña
                <input
                    name="contraseña"
                    class="input1"
                    id="contraseña_registro"
                    type="password"
                    required
                    minlength="6"
                    placeholder="Pepito2605"
            /></label>
            <a href="#privacyModal" class="privacy-link">
                Aviso de Privacidad
            </a>
            <div id="privacyModal" class="privacy-modal">
                <div class="privacy-box">
                    <a href="#" class="close">&times;</a>
                    <h2>Aviso de Privacidad</h2>
                    <p>
                        En cumplimiento de la Ley Nº 25.326 de Protección de los Datos
                        Personales de la República Argentina, los datos ingresados por los
                        usuarios serán utilizados únicamente para el funcionamiento de la
                        plataforma Al Toque.
                    </p>
                    <p>
                        Los datos podrán emplearse para la creación de cuentas, autenticación,
                        publicación de servicios y comunicación entre usuarios.
                    </p>
                    <p>
                        La información no será comercializada ni compartida con terceros,
                        salvo obligación legal.
                    </p>
                    <p>
                        El usuario podrá solicitar la modificación o eliminación de sus datos
                        cuando lo desee.
                    </p>
                    <p>
                        Al utilizar la plataforma acepta este Aviso de Privacidad.
                    </p>
                </div>
            </div>
            <button class="botones1" type="submit">Registrarse</button>
            <button class="botones1" type="button">
                <a class="login-link" href="sesion.php">Iniciar Sesión</a>
            </button>
            <button class="botones1" type="button">
                <a class="inicio-link" href="pagina1.php">Volver Inicio</a>
            </button>
            <?php 
            if(isset($_GET["error_usuario_existente"]) and  $_GET['error_usuario_existente']==1){
                echo "el correo ya existe.";
            }
            ?>
        </form>
    </body>
</html>
