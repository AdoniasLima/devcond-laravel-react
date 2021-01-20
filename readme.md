<h2 align="center"><font color= "#ff8000">LARAVEL</font> + <font color= "#0080ff">REACT</font> + <font color= "#8000ff">REACT NATIVE</font></h2>

This is a complete system, developed to manage a group of houses, register occurrences and even request services.

## Requirements
#### React:
- Node version 12.18.4 or lasted
- Npm version 6.14.6 or lasted
#### Laravel:
- PHP version 7.3 or lasted
- Composer
- Database (Mysql)

## Installation
#### React (folder: ./web):
    command: npm install
#### Laravel (folder: ./backend):
    command: git clone https://github.com/AdoniasLima/api-cars-laravel8.git
    
    command: composer install
	
	*Rename .env.example to .env and provide your database details there.
	
	command: php artisan key:generate
	    
	command: php artisan migrate
	
	command: php artisan db:seed    

	command: php artisan serve

## Routes

### Laravel


|            URL    |Auth|Description|
|----------------|-------------------------------|-----------------------------|
|/api/401|NO|Unauthorized|
|/api/auth/login|NO|Login|
|/api/auth/register|NO|Adds a new user|
|/api/auth/validate|YES|Check token|
|/api/auth/logout|YES|Logout|
|/api/*all|YES|(*Check the other routes in the api route file)|