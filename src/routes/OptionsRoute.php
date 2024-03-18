<?php
    namespace MyApp\Routes;

    use Slim\App;
    use MyApp\Controllers\RootController as controllerRoot;
    use MyApp\Controllers\ApiController as controllerApi;
    use MyApp\Controllers\MySql\MysqlController as controllerMysql;
    use MyApp\Controllers\MySql\DeleteController as controllerDelete;
    use MyApp\Controllers\MySql\InfoController as controllerInfo;
    use MyApp\Controllers\MySql\InnerController as controllerInner;
    use MyApp\Controllers\MySql\InsertController as controllerInsert;
    use MyApp\Controllers\MySql\UpdateController as controllerUpdate;
    use MyApp\Controllers\LogController as controllerLog;

    class OptionsRoute {
        public function __invoke(App $app) {
            $app->option('/', controllerRoot::class . ':index');
        }
    }
