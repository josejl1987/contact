# Contact Book Sample

Simple Contact Book application using Laravel 5.4, VueJS and MySQL.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites


```      
     HTTP server (Apache 2 or nginx)   
        
    PHP >= 5.6.4
    OpenSSL PHP Extension
    PDO PHP Extension
    Mbstring PHP Extension
    Tokenizer PHP Extension
    XML PHP Extension
    Composer
    
    MySQL 5.6 (Might work on other databases compatible with Laravel 5.4)
```

For further information on how to configure the HTTP server, check 
https://laravel.com/docs/5.4/installation#web-server-configuration


### Installing


####Step 1:
Clone this repository to the desired folder.

```
git clone https://github.com/josejl1987/contact.git
```

####Step 2:
Run Composer on the cloned repository
```
cd contact
composer install

```

####Step 3:
Create a .env file suitable for your environment.
Basically you need to enter your database login info, and the database name you are going to use.

##### .env sample file


```
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_LOG_LEVEL=error
APP_URL=http://contacts.local

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_name
DB_USERNAME=username
DB_PASSWORD=password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync


```
####Step 4:
Generate a new application key.
```
php artisan key:generate

```

####Step 5:
Run the migrations in order to set up the needed database schema.
```
php artisan migrate
```





