# AlToque — Metodología Web Ágil

Repositorio de trabajo separado del proyecto original.

## Estado de la migración
Se trasladaron las vistas PHP, JavaScript, CSS, los principales endpoints del backend, la versión mejorada de búsqueda AJAX y la documentación en `docs/TP_Desarrollo_Web_Agil.md`.

**Copia incompleta (requiere completar antes de ejecutar):**
- Archivos PHP pendientes: `backend/login.php`, `backend/guardar_comentario.php`, `backend/modificar_usuario.php`, `backend/publicacion_contratar.php`, `backend/usuarios.php`.
- Imágenes de la carpeta `FontEnd/imagenes/` pendientes de copia.
- `backend/agregar_historico.php` es un archivo vacío en el origen y no fue copiado.

## Base de datos
`Base de datos/base_del_proyecto.sql` incluye la estructura del esquema, **sin registros ni contraseñas de los usuarios**. Para ejecutar localmente, crear datos ficticios de prueba.

## Pruebas
Las correcciones técnicas requieren pruebas locales en Apache/PHP y MySQL. El diseño responsive y accesibilidad necesitan verificación manual.

**Privacidad:** cambiar el repositorio a privado en GitHub antes de incorporar datos que no deban quedar públicos. No subir contraseñas, tokens ni información personal.
