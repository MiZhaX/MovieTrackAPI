
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
- Listado de todos los géneros.
- Crear géneros de forma individual o masiva (bulk).
- Actualizar y eliminar géneros.

### 👥 Personas
- Listar y ver información detallada de personas (paginadas y filtrables).
- Consultar si una persona es actor o director, y sus producciones relacionadas.
- Crear, actualizar y eliminar personas.
- Inserción masiva (bulk) soportada.

### 🎭 Actores
- Listado de actores con sus respectivos roles y producciones asociadas.
- Crear, actualizar y eliminar actores.
- Inserción masiva (bulk) soportada.

### 🎬 Directores
- Listado de directores con las producciones que han dirigido.
- Crear, actualizar y eliminar directores.
- Inserción masiva (bulk) soportada.

### 🗒️ Reseñas
- Listado de las reseñas que los usuarios ponen a las producciones que han visto.
- Puntuar la producción y escribir una reseña.

### 👤 Usuarios
- Registrarse
- Iniciar sesión y obtener token de autenticación
- Al iniciar sesión, con tu token personal, podrás acceder a todas la funciones de la web.
- Ruta '/api/user' para obtener la información del usuario a través de su token.

### 👁️‍🗨️ MarcarProducciones
- El usuario podrá marcar las producciones como 'Visualizada' o como 'Quiero ver'.
- Además, el usuario también podrá marcar una producción como favorita.
- Para poder marcar una produccion, se debe haber iniciado sesión previamente.

### 📑 ListasPersonalizadas
- El usuario puede crear una lista personalizada con un nombre y una descripción.
- Se pueden añadir producciones a las listas personalizadas.
- Forma de que el usuario guarde y organice sus peliculas favoritas de la mejor manera.

## 🛡️ Autenticación

La API utiliza **Laravel Sanctum** para autenticar acciones sensibles como:
- Crear, editar o eliminar recursos (excepto los listados públicos).
- Se requieren permisos específicos como `create` y `delete` en los tokens de acceso.
- Ruta '/setup' para obtener tokens de prueba.

## 📦 Estructura de rutas

```
--------- OBTENER/AÑADIR/MODIFICAR/ELIMINAR UNA PRODUCCIÓN ---------
GET    /api/v1/producciones
GET    /api/v1/producciones/{id}
POST   /api/v1/producciones (auth)
PUT    /api/v1/producciones/{id} (auth)
PATCH  /api/v1/producciones/{id} (auth)
DELETE /api/v1/producciones/{id} (auth)

--------- OBTENER/AÑADIR/MODIFICAR/ELIMINAR UN GENERO ---------
GET    /api/v1/generos
GET    /api/v1/generos/{id}
POST   /api/v1/generos         (auth)
POST   /api/v1/generos/bulk    (auth)
PUT    /api/v1/generos/{id}    (auth)
PATCH  /api/v1/generos/{id}    (auth)
DELETE /api/v1/generos/{id}    (auth)

--------- OBTENER/AÑADIR/MODIFICAR/ELIMINAR UNA PERSONA ---------
GET    /api/v1/personas
GET    /api/v1/personas/{id}
POST   /api/v1/personas        (auth)
POST   /api/v1/personas/bulk   (auth)
PUT    /api/v1/personas/{id}   (auth)
PATCH  /api/v1/personas/{id}   (auth)
DELETE /api/v1/personas/{id}   (auth)

--------- OBTENER/AÑADIR/MODIFICAR/ELIMINAR UN ACTOR ---------
GET    /api/v1/actores
POST   /api/v1/actores         (auth)
POST   /api/v1/actores/bulk    (auth)
PUT    /api/v1/actores/{persona_id}/{produccion_id} (auth)
DELETE /api/v1/actores/{persona_id}/{produccion_id} (auth)

--------- OBTENER/AÑADIR/MODIFICAR/ELIMINAR UN DIRECTOR ---------
GET    /api/v1/directores
POST   /api/v1/directores      (auth)
POST   /api/v1/directores/bulk (auth)
PUT    /api/v1/directores/{persona_id}/{produccion_id} (auth)
DELETE /api/v1/directores/{persona_id}/{produccion_id} (auth)

--------- OBTENER/AÑADIR/MODIFICAR/ELIMINAR UNA RESEÑA ---------
GET    /api/v1/resenas
GET    /api/v1/resenas/{id}
POST   /api/v1/resenas         (auth)
PUT    /api/v1/resenas/{id}    (auth)
PATCH  /api/v1/resenas/{id}    (auth)
DELETE /api/v1/resenas/{id}    (auth)

--------- OBTENER/AÑADIR/MODIFICAR/ELIMINAR LA MARCA DE UNA PRODUCCION ---------
GET    /api/v1/marcarProducciones         (auth)
GET    /api/v1/marcarProducciones/{id}    (auth)
POST   /api/v1/marcarProducciones         (auth)
PUT    /api/v1/marcarProducciones/{id}    (auth)
DELETE /api/v1/marcarProducciones/{id}    (auth)

--------- OBTENER/AÑADIR/MODIFICAR/ELIMINAR UNA LISTA PERSONALIZADA ---------
GET    /api/v1/listasPersonalizadas         (auth)
GET    /api/v1/listasPersonalizadas/{id}    (auth)
POST   /api/v1/listasPersonalizadas         (auth)
PUT    /api/v1/listasPersonalizadas/{id}    (auth)
DELETE /api/v1/listasPersonalizadas/{id}    (auth)

--------- OBTENER/AÑADIR/ELIMINAR PRODUCCIÓN A UNA LISTA PERSONALIZADA ---------
GET    /api/v1/produccionesListas         (auth)
POST   /api/v1/produccionesListas         (auth)
DELETE /api/v1/produccionesListas/{id}    (auth)

--------- AUTENTICACIÓN DE USUARIOS ---------
POST   /api/register
POST   /api/login
POST   /api/logout             (auth)
GET    /api/user               (auth)
```

## ⚙️ Instalación

1. Clona el repositorio:
   ```bash
   git clone https://github.com/MiZhaX/movietrack-api.git
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
