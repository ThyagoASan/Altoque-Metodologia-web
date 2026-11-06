# Trabajo Práctico Grupal — Desarrollo Web Ágil: AlToque

> Estado al 05/11/2026. Este documento separa **implementación comprobada**, **propuesta de trabajo** y **evidencia pendiente**. No presentar propuestas como prácticas ya realizadas.

## 1. Metodología ágil seleccionada: Kanban

**Elección:** Kanban, porque permite visualizar tareas, limitar el trabajo simultáneo y adaptar prioridades mientras se corrigen y prueban funcionalidades de una aplicación ya existente. No requiere inventar sprints retrospectivos.

**Tablero propuesto:** Pendiente → En desarrollo → En revisión → Finalizado.

**Criterios de movimiento:**
- Pendiente: tarea definida con responsable y criterio de aceptación.
- En desarrollo: se trabaja en una sola tarea prioritaria por integrante.
- En revisión: código revisado, pruebas pendientes o en curso.
- Finalizado: cambios incorporados y evidencia registrada.

**Organización del tiempo:** revisión breve del tablero al comenzar cada sesión; priorizar fallas bloqueantes y requisitos de la consigna; revisión conjunta antes de entregar. Registrar fecha de cada movimiento y enlace al commit o evidencia.

**Roles:** los integrantes deben acordar y completar esta tabla; no se asignan roles sin su confirmación.

| Integrante | Responsabilidad acordada | Evidencia |
| --- | --- | --- |
| Integrante 1 | Por confirmar | Por registrar |
| Integrante 2 | Por confirmar | Por registrar |
| Integrante 3 | Por confirmar | Por registrar |

**Trabajo colaborativo y seguimiento:** repositorio GitHub, commits descriptivos, revisión de cambios y tablero Kanban compartido. **Pendiente:** agregar enlace/captura del tablero real y explicar cuándo se utilizó. Que este documento proponga Kanban no demuestra que se haya aplicado en equipo.

## 2. Prácticas de Programación Extrema (XP)

| Práctica | Integración con Kanban | Evidencia / estado |
| --- | --- | --- |
| Refactorización | Corregir y simplificar código al abordar una tarjeta | Hay cambios de código; documentar archivos y commits concretos |
| Integración frecuente | Integrar cambios pequeños antes de pasar a revisión | Consultar historial de commits; no afirmar integración continua automatizada sin workflow |
| Pruebas | Verificar criterios de aceptación antes de finalizar una tarjeta | Pruebas manuales de búsqueda, registro, contratación, finalización e historial descritas abajo |
| Programación en pareja | Dos integrantes revisan una tarea en desarrollo | **No acreditada:** registrar participantes y fecha solo si ocurrió |
| Pruebas automatizadas | Ejecutar comprobaciones repetibles en revisión | **No acreditadas:** agregar scripts/resultados si existen |
| Comunicación frecuente | Revisión del tablero y bloqueos | **No acreditada:** registrar reuniones reales |

**Relación XP–Kanban:** Kanban gestiona el flujo de trabajo; XP orienta cómo construir y verificar cada cambio. No son metodologías excluyentes.

## 3. Implementación técnica

### 3.1 AJAX — implementado y probado localmente

La búsqueda en `FontEnd/javascript/script.js` usa `fetch()` para consultar `backend/leer_publicaciones.php`, enviando un filtro por `zona` o `categoria` y actualizando la interfaz sin recargar la página. La carga de localidades también se realiza de forma asincrónica.

**Evidencia manual reportada:** buscar “Morón” oculta la publicación de Castelar sin recarga; al buscar según los filtros se actualizan los resultados.

### 3.2 Diseño responsive — código implementado, validación incompleta

`FontEnd/html_y_css/css.css` contiene puntos de corte `@media` para distintas anchuras, entre ellas 480, 530, 670, 768, 900 y 1023 px. **No basta con tener media queries:** hay que verificar cada pantalla y que no haya desbordes horizontales ni controles inaccesibles.

| Ancho a comprobar | Inicio y búsqueda | Perfil profesional | Login/registro | Mis trabajos/contrataciones | Administración |
| --- | --- | --- | --- | --- | --- |
| 375 px (móvil) | Pendiente | Pendiente | Pendiente | Pendiente | Pendiente |
| 768 px (tablet) | Pendiente | Pendiente | Pendiente | Pendiente | Pendiente |
| 1280 px (escritorio) | Vista principal comprobada | Vista comprobada | Vista comprobada | Vistas comprobadas | Pendiente |

### 3.3 Accesibilidad — mejoras parciales, auditoría pendiente

Hay mejoras en etiquetas de registro, foco visible y mensajes de búsqueda. Revisar **todas** las páginas para:
- Imágenes informativas con `alt` significativo; decorativas con `alt=""`.
- Campos con `label` asociado, botones con nombre accesible.
- Orden de tabulación lógico y operación mediante Tab, Enter y Espacio; foco visible.
- Contraste de texto y controles suficiente; errores claros, no dependientes solo del color.
- Zoom al 200 %, tamaños pequeños y mensajes anunciados cuando cambian resultados.

No declarar accesibilidad completa hasta verificar estos puntos.

## 4. Evidencia de pruebas funcionales manuales (05/11/2026)

Resultados comunicados por quien ejecutó el proyecto en XAMPP local:
- Registro de usuario e inicio de sesión: exitosos después de repetir el registro.
- Búsqueda AJAX por localidad: al escribir Morón desapareció el resultado de Castelar.
- Contratar sin sesión: se solicita iniciar sesión.
- Contratación autenticada: se confirma y aparece en «Mis contrataciones».
- Prestador: trabajo 73 aparece «Contratado en proceso» y cliente en «Mis clientes».
- Finalizar trabajo 73: pasa a «Ya Finalizados» tanto para prestador como cliente.
- Se genera una nueva publicación activa de Electricista con otro ID.
- Comentario: se publica con autor y fecha y persiste al recargar.
- Calificación por estrellas: se visualizan estrellas, **falta prueba del guardado y del promedio**.

Estas pruebas **no equivalen a pruebas automatizadas ni a auditoría de seguridad**. La base de datos y los usuarios de prueba son locales; no se incluyen automáticamente al clonar el repositorio.

## 5. Matriz de cumplimiento de la consigna

| Consigna | Estado | Acción para cerrar |
| --- | --- | --- |
| Elegir y justificar metodología | Documentado | Validar elección con el grupo |
| Organización, roles, seguimiento | Propuesto | Completar responsables y evidencias reales del tablero |
| Prácticas XP y relación con Kanban | Explicado | Aportar evidencia de prácticas efectivamente realizadas |
| AJAX en una función | **Implementado y probado** | Adjuntar captura o video breve de la búsqueda |
| Responsive escritorio/tablet/móvil | **Implementación parcial** | Completar matriz de dispositivos y corregir fallos |
| Accesibilidad (alt, teclado, contraste, mensajes) | **Parcial** | Auditar páginas y corregir incumplimientos |
| Reflexión grupal | **Pendiente de aportes del equipo** | Completar respuestas basadas en experiencia real |

## 6. Reflexión grupal — guía para completar con experiencias reales

**¿Cómo aplicamos la metodología ágil?** Describir qué tablero se usó, cómo se asignaron tareas, cómo se revisó el avance y ejemplos fechados. No afirmar su uso si no ocurrió.

**¿Qué beneficios y dificultades encontramos?** Registrar ejemplos reales: coordinación de horarios, integración de PHP/MySQL/JavaScript, resolución de errores y comunicación del equipo.

**¿Qué aprendizajes nos llevamos?** Reflexionar sobre entregas pequeñas, verificación de requisitos, accesibilidad, pruebas y documentación, vinculando cada aprendizaje con una experiencia del grupo.

> Antes de entregar, sustituir esta guía por una reflexión consensuada y verificable de los integrantes.

## 7. Checklist de entrega

- [ ] El equipo confirma Kanban y adjunta tablero real.
- [ ] Responsables y dinámica colaborativa documentados.
- [ ] Evidencias de prácticas XP realizadas, sin inventar pair programming ni CI.
- [x] Búsqueda AJAX comprobada en entorno local.
- [ ] Capturas responsive a 375, 768 y 1280 px de páginas principales.
- [ ] Revisión de accesibilidad de imágenes, teclado, contraste y mensajes.
- [ ] Reflexión grupal completada y aprobada por el equipo.
- [ ] Revisión cruzada de documentación y aplicación antes de presentar.
