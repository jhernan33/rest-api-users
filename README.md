## Laravel 8 REST API with Passport Authentication, Postgresql

#### Step 1: Clonar el Proyecto

``git clone https://github.com/jhernan33/rest-api-users.git``  

#### Step 2: Configuracion de la Base de datos

Crear una base de datos en Postgresql con el nombre de: db_users

#### Step 3: Ejecutar las migraciones y Semillas

``php artisan migrate --seed``

#### Step 4: Ejecutar la Api Rest

``php artisan http://127.0.0.1:8500``

make sure in details api we will use following headers as listed bellow:

```
'headers' => [
    'Accept'        => 'application/json',
    'Authorization' => 'Bearer '.$accessToken,
]
```

Here is Routes URL with Verb:

Now simply you can run above listed url like:

- **Registrar Usuario API:** Verb:POST, URL: http://127.0.0.1:8500/api/register
- **Acceso Usuario API:** Verb:POST, URL: http://127.0.0.1:8500/api/login

- **Listar Usuario API:** Verb:GET, URL: http://127.0.0.1:8500/api/users
- **Ver Detalle Usuario API:** Verb:GET, URL: http://127.0.0.1:8500/api/users/{id}
- **Actualizar Permisos API:** Verb:PUT, URL: http://127.0.0.1:8500/api/users/{id}
- **Eliminar Usuario API:** Verb:DELETE, URL: http://127.0.0.1:8500/api/users/{id}







