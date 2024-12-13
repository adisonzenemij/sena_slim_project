<h1 align="center">🔥 Proyecto Backend 🧑‍💻</h1>

## Introducción


## Requisitos
* Composer
* PHP (Version 7)
* MySQL (Version 8)

## Instalación
```yml
Clonar Repostorio: git clone <project>
```
```yml
Añadir Dependencias: composer require <dependency>
Instalar Dependencias: composer install
Actualizar Proyecto: composer dump-autoload
```

## Configuración
```yml
Environment: composer require vlucas/phpdotenv
JWT: composer require firebase/php-jwt
Slim: composer require slim/slim
Slim: composer require slim/psr7
Slim: composer require slim/twig-view
Cors: composer require tuupola/cors-middleware
```

## Variables Entorno
```yml
### Configuración Básica ###
APP_PROJECT: Nombre del proyecto
APP_FRAMEWORK: Framework utilizado [none | other]
APP_VERSION: Versión de la aplicación
APP_DEBUG: Depuración activada [true | false]
```

## Pruebas Unitarias
```yml
Driver: xdebug
Comandos:
    `./vendor/bin/phpunit --generate-configuration`
    `./vendor/bin/phpunit --list-suites`
    `./vendor/bin/phpunit --testsuite=unit`
    `./vendor/bin/phpunit --testsuite=integration`

    `./vendor/bin/phpunit`
    `./vendor/bin/phpunit tests`
    `./vendor/bin/phpunit --coverage-html .coverages`
    `./vendor/bin/phpunit --migrate-configuration`
```

## Páginas Oficiales
<div align="center">
    <a href="https://www.adisonjimenez.net" target="_blank">
        <span>Web Principal 🌐</span>
    </a>
    |
    <a href="https://www.engsoft.app" target="_blank">
        <span>Web Desarrollo 💻</span>
    </a>
</div>