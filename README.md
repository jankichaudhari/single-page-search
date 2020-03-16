# Single page search api

Following things are required to run this project:
1. Need php >= 7.0 and mysql >= 5 installed. 
2. In mysql create database named 'page_search'. you can use following command for it :
    CREATE DATABASE page_search;

clone repository and run following command
    run composer install

start lumen artisan server by using your available port
    php -S localhost:80 -t public
    
Copy .env.example to .env and make following changes 
1. APP_URL = lumen artisan server url
2. change DB_HOST, DB_PORT, DB_USERNAME and DB_PASSWORD as per your config

Run following commands to create required db table and fill up data
    php artisan migrate
    
To fill up table with data :
1. If given names.csv, then run mysql query
    LOAD DATA LOCAL INFILE '<path>/names.csv' INTO TABLE `names` FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' (firstname, lastname, @created_at, @updated_at)SET created_at = STR_TO_DATE(@created_at, '%Y-%m-%d');
2. If want to use fake data by lumen faker then run from command line
    php artisan db:seed
    
### Frontend
Launch following url in browser to have search box, which searches using backend api
    http://localhost:80//search
    
### Backend
Launch following url to use php backend api to filter through names. {terms} should be string for searching in lastname. {dupes} should be boolean, where 'true' for having result with unique data and 'false' means having data as available in database.
    localhost:80//names/{terms}/{dupes}
    



## Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Contributing

Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
