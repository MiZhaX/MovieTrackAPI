
# 🎬 MovieTrack API

API RESTful para la gestión de producciones audiovisuales (películas y series), géneros, actores, directores y personas. Desarrollada en Laravel 10.

## 🚀 Funcionalidades actuales

### 📁 Producciones
- Listar todas las producciones (paginadas y filtrables).
- Ver detalles de una producción.
- Crear, actualizar y eliminar producciones.
- Cada producción tiene:
  - Título, tipo (película/serie), género, sinopsis, duración, fecha de estreno, poster, puntuaciones de crítica y usuarios.
  - Relaciones con actores, director y género.

### 🏷️ Géneros
- Listado público de todos los géneros.
- Crear géneros de forma individual o masiva (bulk).
- Actualizar y eliminar géneros.
- Relación uno a muchos con Producciones.

### 👥 Personas
- Listar y ver información detallada de personas.
- Consultar si una persona es actor o director, y sus producciones relacionadas.
- Crear, actualizar y eliminar personas.

### 🎭 Actores
- Listado de actores con sus respectivos roles y producciones asociadas.
- Crear, actualizar y eliminar actores.
- Inserción masiva (bulk) soportada.
- La relación entre actor y producción es compuesta (`persona_id`, `produccion_id`).

### 🎬 Directores
- Listado de directores con las producciones que han dirigido.
- Crear, actualizar y eliminar directores.
- Relación compuesta similar a actores.

## 🛡️ Autenticación

La API utiliza **Laravel Sanctum** para autenticar acciones sensibles como:
- Crear, editar o eliminar recursos (excepto los listados públicos).
- Se requieren permisos específicos como `create` y `delete` en los tokens de acceso.
- Ruta '/setup' para obtener tokens de prueba.

## 📦 Estructura de rutas

```
GET    /api/v1/producciones
GET    /api/v1/producciones/{id}
POST   /api/v1/producciones (auth)
PUT    /api/v1/producciones/{id} (auth)
DELETE /api/v1/producciones/{id} (auth)

GET    /api/v1/generos
GET    /api/v1/generos/{id}
POST   /api/v1/generos         (auth)
POST   /api/v1/generos/bulk    (auth)
PUT    /api/v1/generos/{id}    (auth)
DELETE /api/v1/generos/{id}    (auth)

GET    /api/v1/personas
GET    /api/v1/personas/{id}
POST   /api/v1/personas        (auth)
PUT    /api/v1/personas/{id}   (auth)
DELETE /api/v1/personas/{id}   (auth)

GET    /api/v1/actores
GET    /api/v1/actores/{persona_id}/{produccion_id}
POST   /api/v1/actores         (auth)
POST   /api/v1/actores/bulk    (auth)
PUT    /api/v1/actores/{persona_id}/{produccion_id} (auth)
DELETE /api/v1/actores/{persona_id}/{produccion_id} (auth)

GET    /api/v1/directores
POST   /api/v1/directores      (auth)
PUT    /api/v1/directores/{persona_id}/{produccion_id} (auth)
DELETE /api/v1/directores/{persona_id}/{produccion_id} (auth)
```

## ⚙️ Instalación

1. Clona el repositorio:
   ```bash
   git clone https://github.com/tuusuario/movietrack-api.git
   cd movietrack-api
   ```

2. Instala dependencias:
   ```bash
   composer install
   ```

3. Copia el archivo `.env` y configura tu base de datos:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Ejecuta migraciones:
   ```bash
   php artisan migrate
   ```

5. Inicia el servidor:
   ```bash
   php artisan serve
   ```

## 🧪 Pruebas con Postman

Puedes probar la API localmente en:  
`http://127.0.0.1:8000/api/v1/`

---

## 🧑‍💻 Autor

Desarrollado por Mishael Bonel Ortiz
Proyecto para el TFG de **Desarrollo de Aplicaciones Web**
