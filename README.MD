# PhpAcadem Framework Skeleton Web Application

Use this skeleton application to quickly setup and start working on a PhpAcadem Framework which follows PSR standards to the maximum.
This application uses the latest PhpAcadem Framework with the native PHP template Plates.


This skeleton application was built for Composer.
This makes setting up a PhpAcadem Framework application quick and easy.

## Install the Application
```composer create-project phpacadem/web-app-sceleton [my-app-name]```

Replace [my-app-name] with the desired directory name for your new application.


### Components database initialization
```
php bin/app.php db:init
php bin/app.php blog:init
php bin/app.php user:init
```

Also you can add `--help` option to see all available options for current command

## Built-in PHP server

To try it on built in PHP server just use command:
```
composer server
```
Web app will be available at ``http://0.0.0.0:8081``
