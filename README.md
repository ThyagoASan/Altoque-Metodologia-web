# AlToque — Metodología Web Ágil

Copia de trabajo separada del proyecto grupal original.

## Ejecutar en XAMPP
1. Arrancar Apache y MySQL en XAMPP.
2. Extraer el repositorio en C:/xampp/htdocs/Altoque-Metodologia-web/.
3. Abrir http://localhost/phpmyadmin e importar Base de datos/base_del_proyecto.sql.
4. Verificar la conexión en backend/conexion/conexion_dal.php (MySQL local).
5. Abrir http://localhost/Altoque-Metodologia-web/FontEnd/html_y_css/pagina1.php.
6. Registrar dos usuarios ficticios, publicar un servicio y comprobar su búsqueda y contratación.

## Estado
- Incluye frontend PHP/JS/CSS, endpoints del backend y esquema SQL vacío de cuentas y datos personales.
- Búsqueda AJAX mejorada; autenticación con password_hash/password_verify para nuevas cuentas.
- Los ocho archivos binarios de imágenes originales aún no fueron copiados. Las referencias utilizadas en HTML/CSS cargan imágenes del repositorio grupal público original mediante URLs externas. Para obtener copias locales, desde PowerShell en la raíz ejecutá: powershell -ExecutionPolicy Bypass -File scripts/descargar_imagenes.ps1 (luego podés sustituir esas URLs externas por las rutas relativas locales).
- El archivo backend/usuarios.php antiguo quedó deshabilitado para no filtrar cuentas.
- Pendiente: probar la aplicación ejecutándola con PHP/MySQL, verificar accesibilidad, corregir validaciones y autorizaciones de endpoints restantes y registrar resultados.

## Trabajo práctico
Ver docs/TP_Desarrollo_Web_Agil.md. No afirmar que las pruebas o prácticas XP están finalizadas sin evidencia.

## Aviso
No incluir datos reales ni desplegar públicamente hasta completar las revisiones de seguridad y las pruebas.