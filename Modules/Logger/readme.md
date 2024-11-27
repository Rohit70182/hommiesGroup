##Installation

Set "Logger": true, in modules_statuses.json file

```
run php artisan migrate

```

In config/logging 

```
Add the following set of instructions to 'channels' section

  'mysql' => [
            'driver' => 'custom',
            'via' => Modules\Logger\Logging\CreateMySQLLogger::class,
        ],
```
insert 'mysql' to channels under 'stack' channel 

```
In config/app

```
Add the following namespace to 'providers' section

Modules\Logger\Logging\MonologMysqlHandlerServiceProvider::class,

```
Add above channel to stack

```
Set LOG_CHANNEL=stack

