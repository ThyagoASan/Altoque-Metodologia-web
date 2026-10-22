# Trabajo Práctico: Desarrollo Web Ágil

## Metodología seleccionada: Kanban
Se propone un tablero con cuatro columnas: Pendiente, En desarrollo, En revisión y Finalizado. Cada integrante del equipo toma tareas, registra los cambios en GitHub y documenta los resultados de las pruebas. La asignación final de responsables será consensuada.

## Prácticas XP
Aplicar programación en pareja para revisar cambios, refactorización de código JavaScript, integración frecuente mediante commits pequeños, y pruebas manuales y automatizadas. Registrar fechas, responsables y evidencia; no declarar como realizadas prácticas que todavía no se aplicaron.

## Implementación técnica existente
- AJAX: `FontEnd/javascript/script.js` utiliza Fetch para solicitar publicaciones a `backend/leer_publicaciones.php`.
- Responsive: `FontEnd/html_y_css/css.css` contiene varios puntos de corte mediante `@media`.
- Accesibilidad: se mejoraron etiquetas de registro, foco visible y anuncios de cambios en la búsqueda.

## Pruebas pendientes en entorno local
1. Buscar una profesión y comprobar que los resultados se actualizan sin recarga.
2. Buscar una localidad y comprobar que los filtros funcionen.
3. Abrir dos perfiles distintos y verificar que sus IDs sean correctos.
4. Buscar una consulta vacía o sin resultados y comprobar mensajes.
5. Navegar con Tab y Enter, observando la visibilidad del foco.
6. Probar tamaños de 375, 768 y 1280 píxeles.
7. Verificar la respuesta JSON en herramientas para desarrolladores.

## Reflexión grupal
Completar después del trabajo colaborativo: cómo se gestionó Kanban, qué prácticas XP aplicaron realmente, beneficios y dificultades observadas y aprendizajes para proyectos futuros.

## Advertencias
Este repositorio contiene una copia de trabajo; las pruebas funcionales no están validadas todavía. El esquema SQL se importa sin datos de usuarios. Se requiere revisar la seguridad antes de cualquier despliegue público.
