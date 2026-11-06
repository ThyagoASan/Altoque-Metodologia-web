# AlToque | Plataforma web de servicios

Proyecto académico grupal orientado al desarrollo de una plataforma web para publicar, buscar y contratar servicios.

## Tecnologías

- **Frontend:** HTML, CSS, JavaScript y PHP
- **Backend:** PHP
- **Base de datos:** MySQL
- **Interactividad:** AJAX
- **Entorno local:** XAMPP (Apache y MySQL)

## Funcionalidades

- Registro e inicio de sesión de usuarios.
- Publicación de servicios.
- Búsqueda de servicios con AJAX.
- Flujo de contratación de servicios.

## Mi participación

Participé como **desarrollador full-stack** en este proyecto grupal, colaborando en distintas etapas del desarrollo. Comencé trabajando principalmente en el backend y también contribuí al frontend, la integración con la base de datos y la implementación y comprobación de funcionalidades.

## Ejecución local

1. Instalar XAMPP e iniciar **Apache** y **MySQL**.
2. Colocar el repositorio en `C:/xampp/htdocs/Altoque-Metodologia-web/`.
3. Entrar a `http://localhost/phpmyadmin` e importar `Base de datos/base_del_proyecto.sql`.
4. Revisar la configuración local de MySQL en `backend/conexion/conexion_dal.php`.
5. Abrir `http://localhost/Altoque-Metodologia-web/FontEnd/html_y_css/pagina1.php`.
6. Probar el registro y el inicio de sesión con usuarios ficticios, la publicación de servicios y el flujo de búsqueda y contratación.

## Estructura y estado del proyecto

- `FontEnd/`: vistas, estilos, scripts e imágenes.
- `backend/`: lógica del servidor y conexión con MySQL.
- `Base de datos/`: script SQL para crear la base de datos.
- `docs/TP_Desarrollo_Web_Agil.md`: documentación académica.

El proyecto incluye las imágenes originales en `FontEnd/imagenes/`. Se incorporaron mejoras en la búsqueda AJAX y el uso de `password_hash` y `password_verify` para nuevas cuentas. El antiguo archivo `backend/usuarios.php` quedó deshabilitado para evitar la exposición de cuentas.

**Estado:** proyecto académico en revisión. Aún corresponde completar pruebas documentadas, accesibilidad, validaciones y controles de autorización en los endpoints restantes. No está preparado para despliegue público ni para almacenar datos personales reales.

## Autoría

Proyecto desarrollado en equipo en el marco de una actividad universitaria. Esta copia del repositorio documenta mi participación y las mejoras realizadas; no implica autoría individual de todo el código.

## Próximas mejoras

- Documentar pruebas funcionales.
- Completar validaciones y controles de seguridad.
- Incorporar capturas de pantalla verificadas de las principales vistas.
- Mejorar la documentación técnica y de instalación.

## Guía de pruebas funcionales (pendientes de ejecución)

Usar únicamente usuarios ficticios. No probar sobre una base con datos reales. Para una instalación nueva, importar el SQL en una base vacía: el archivo incluye diez localidades de prueba.

1. **Registro:** crear dos usuarios ficticios distintos; verificar que el correo duplicado sea rechazado.
2. **Sesión:** entrar con credenciales válidas y comprobar el rechazo de una contraseña incorrecta.
3. **Publicación:** con el usuario A, crear un servicio en una localidad disponible; comprobar su aparición en Mis publicaciones.
4. **Búsqueda:** buscar por categoría y por localidad en la página principal; verificar los resultados AJAX.
5. **Perfil:** abrir el servicio y comprobar datos, disponibilidad y ausencia del botón Contratar para el propietario.
6. **Contratación:** con el usuario B, contratar el servicio de A; comprobar que deja de estar disponible, aparece en Mis contrataciones y figura como Contratado en proceso en el historial.
7. **Finalización:** con A, finalizar el trabajo; comprobar que el historial conserva Finalizado y se crea una nueva publicación disponible.
8. **Reseñas y comentarios:** con B, enviar una calificación de 1 a 5 y un comentario; comprobar que se muestran correctamente y que A no puede comentar su propia publicación.
9. **Permisos:** sin iniciar sesión, intentar entrar a Mis publicaciones, Mis contrataciones y al panel administrativo; verificar que el acceso se bloquee. Con B, intentar modificar o borrar una publicación de A.
10. **Errores:** comprobar que IDs inválidos, datos vacíos y acciones duplicadas no modifiquen registros.

**Criterio de aprobación:** registrar para cada prueba la fecha, el resultado observado (aprobada/fallida), el usuario ficticio empleado y una captura si corresponde. Ninguna prueba se considera aprobada solo por haber subido código a GitHub.

### Diagnóstico rápido

- Si aparece un error de conexión, verificar Apache, MySQL y `backend/conexion/conexion_dal.php`.
- Si faltan localidades, revisar que se haya importado el SQL actualizado en una base vacía.
- Si AJAX falla, abrir las herramientas del navegador (F12), pestañas **Consola** y **Red**, y revisar el código HTTP de la petición.
- Si la página muestra un error PHP, revisar el registro de errores de Apache en XAMPP.
- Si ya existe una base con datos, hacer una copia antes de cualquier importación; no volver a importar a ciegas.

**Estado de estas pruebas:** sin ejecutar en XAMPP. El código requiere validación de integración antes de la defensa.
