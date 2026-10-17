# Prototipo Web para la Organización de Tareas Académicas (UDGVirtual)

Sistema web full-stack desarrollado bajo la metodología ágil **Scrum** para la gestión de asignaturas, control de actividades escolares y monitoreo de avance académico.

## Tecnologías Utilizadas
* **Frontend:** Vue.js 3 + Vite + Vue Router + Axios
* **Backend:** Laravel RESTful API + Caché de Consultas
* **Base de Datos:** MongoDB (NoSQL)

## Documentación de Endpoints API (Sprint 5)

| Método | Endpoint | Descripción | Parámetros / Body JSON |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/health` | Verifica el estado operativo del servidor | Ninguno |
| `GET` | `/api/actividades` | Lista actividades con soporte de filtros | `?estado=Pendiente&buscar=texto` |
| `GET` | `/api/actividades/stats` | Obtiene métricas y porcentaje de avance | Ninguno (Respuesta en Caché) |
| `POST` | `/api/actividades` | Registra una nueva tarea validada | `{"titulo": "string", "prioridad": "Media", "estado": "Pendiente"}` |
| `PUT` | `/api/actividades/{id}` | Actualiza el estado o datos de la tarea | `{"estado": "Completada"}` |
| `DELETE` | `/api/actividades/{id}` | Elimina una actividad de forma permanente | Ninguno |

## Manual Rápido de Instalación Local
1. **Backend:** Entrar a `cd backend`, ejecutar `composer install`, configurar `.env` con la conexión `mongodb` y levantar el servidor con `php artisan serve`.
2. **Frontend:** Entrar a `cd frontend`, ejecutar `npm install` e iniciar la interfaz con `npm run dev`.