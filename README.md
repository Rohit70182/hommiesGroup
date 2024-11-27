# service-provider-laravel

The main objective of this project is to design and develop an “On-demand Service Marketplace Application” for Android and iOS platforms that will serve the purpose of connecting service providers with their Customers where they can select and book the service providers they want to hire for any desired service.




#Installation

To install script module

```
git clone https://github.com/Rohit70182/service-provider-laravel.git
```

Storage folder must have 
```
app, framework, logs
```
Rename .env.example file to .env and change db credentials 
```
databse credentials
```
To install database and project setup run this command

```
bash setup.sh

```
To install specific Seed run this command

```
php artisan db:seed --class=AdminSeeder

```
To install Migration with Seed run this command

```
php artisan migrate:fresh --seed
```
To generate a key (No need if setup.sh command run)

```
php artisan key:generate 
``` 
If you have composer.json

```
composer install --prefer-dist 
```

If you need to update vendor again you can use followig command

```
composer update --prefer-dist --prefer-stable
```

## Usage
Once setup is done you need to follow the final setup with the installer .

make sure you give READ/WRITE permission to your folder.

When you add module you have to update your composer.json file

```
"autoload": {
        "psr-4": {
            "App\\": "app/",
            "Modules\\": "Modules/",
        }
    },
```
Then run following command

```
composer dumpautoload
```

