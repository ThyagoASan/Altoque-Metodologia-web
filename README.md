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
