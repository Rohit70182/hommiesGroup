<h1 align="center">
    <a href="https://ozvid.com" title="ozvid" target="_blank">
        <img width = "20%" height = "20%" src="https://ozvid.com/themes/base/images/web_logo.png" alt="Ozvid Logo"/>
    </a>
    <br>
    <hr>
</h1>

This is the project that helps users to search nearby  services and make order.Users can use pick up or drop facility and can pay online or offline as per their choices.




##Installation

To install script module

```
git clone http://192.168.10.42/web/trotro-app-web-1772
```

Storage folder must have 
```
app, framework, logs
```
Update .env file
```
databse credentials 
```
To install composer and  database run this command


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

When you add module you have to update your composer.json file .

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

If you need to add module you can use followig command

```
php artisan module:make ModuleName
```
If you need to add migration for module you can use followig command

```
php artisan module:make-migration create_tbl_name_table ModuleName
```
If you need to run module migration then follow command

```
php artisan module:migrate ModuleName
```
If you need to create model in module then follow command

```
php artisan module:make-model ModelName ModuleName
```


## License

**www.ozvid.com** 

