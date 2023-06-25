## Project Overview

This project is a symptom checker API, allowing mulptile functionalities such as users authentication, and symptom evaluation allowing to deliver a diagnostic.

## Stack

-PHP 8.1
-Laravel Laravel 10x
-MySQL

## Setup

After cloning the repo, open the terminal and change directory to the project and run the following command line to generate a new .env file.

```
cp .env.example .env
```

Generate application key by running:

```
php artisan key:generate
```

Install projects dependencies using:

```
composer-install
```

In your .env file set your database credentials

```
DB_DATABASE=<YOUR_DATABASE_NAME>
DB_USERNAME=><DB_USER>
DB_PASSWORD=<PASSWORD>
```

Before proceeding scroll down to the Authentication with JWT to setup keys and services for auth.
Run database migrations with:

```
php artisane migrate
```
Run database seeders:

```
php artisan db:seed
```

## Other packages and dependencies.

-tymon/jwt-auth 2.0
-ApiMedic api


## Authentication with JWT 

Install tymon/jwt-auth:

```
composer require tymon/jwt-auth
```

After installing the package, publish its configuration file and migration files using Artisan:

```
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```

Generate a secret key with the followin command line:

```
php artisan jwt:secret
```

Configure or modify your api guards to use jwt in your auth.php

```
'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
        
    ],
```

```
'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ]
    ],
```

Migrate tables to DB:

```
php artisan migrate
```

For any inconvinients or doubts consult with documentation at https://jwt-auth.readthedocs.io/en/develop/


This api consumes a third party api named ApiMedic. https://apimedic.com/

Register in the api website and get the corresponding keys for the environment (Sandbox Api account).

You should get the following keys and include them in your .env file






