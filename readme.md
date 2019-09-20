## TEST: APP CRUD TICKETS

#### Resumen
Se realiza un crud con laravel v-6.0 para el backend y se consumen con Vue.js v-^2.0
    
#### Librerias y Frameworks Usadas
- Backend
    - Laravel
    - Mysql
    - laravel UI (version ^6.0)

- Frontend 
    - Vue.js
    - Vuetify
    - Vuex
    - Vue Router
    - Axios
    
#### Instalacion

1. Instala los paquetes de composer
    `composer install`
    
2. Copia archivo .env.example a .env y remplaza las variables a utilizar
    `cp .env.example .env`
    
3. Genera la llave del proyecto
    `php artisan key:generate`
 
4. Luego de confirar lo anterior, puede iniciar las migraciones *(recuerde asignar variables de la base de datos en el archivo .env)*
    `php artisan migrate`
    
5. Instala los paquetes de node
    `npm install`
    
6. Por ultimo ya puede lanzar el servidor
    `php artisan serve`
    
    
#### Informacion de API

##### Parte Logica
1. Podrá registrarse automaticamente como usuario
2. No podrá agregar nuevos ticket sin haber iniciado session
3. Los ticket solo sera cerrados a quien se le haya asignado
4. Los ticket solo podran ser eliminados luego de cerrarse y solo a quien le fue asignado
5. El ticket podra ser editado solo por quien lo creo
6. El orden de la lista de ticket sera descendente a la creacion


##### Parte Estructural

*Rutas de la API*

| Ruta | Tipo | Argumentos |
| --------- | --------- | --------- |
| /api/tickets | GET / HEAD |
| /api/tickets | POST | issue, priority, user, task, assignationDate |
| /api/tickets/{tickets} | PUT / PATCH | issue, priority, user, task, assignationDate |
| /api/tickets/{tickets} | DELETE | ticket |
| /api/tickets/{tickets}/close | POST | ticket, concluding_remarks |
| /api/users | GET / HEAD |  |
| /login | POST | email, password |
| /logout | POST |  |
| /password/reset | POST | email, password, password_validate |
| /register | POST | name, email, password, password_validate |

