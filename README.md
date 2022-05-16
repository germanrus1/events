<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## requirements
- php:8.1.4
- nginx:1.21.6
- postgres:12.2
- NodeJS (optional)

## Install project
For this project recommended docker and docker-compose. If installed then execute command 
1. docker-compose up

After installing images run command and open bash in _app_ container (docker exec -it _app_service_name_ bash)
2. php artisan key:generate
3. php artisan migrate
