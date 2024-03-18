<?php
    namespace MyApp\Routes;

    use Slim\App;
    use MyApp\Controllers\RootController as controllerRoot;
    use MyApp\Controllers\ApiController as controllerApi;
    use MyApp\Controllers\JwtController as controllerJwt;

    use MyApp\Controllers\MySql\MysqlController as controllerMysql;
    use MyApp\Controllers\MySql\DeleteController as controllerDelete;
    use MyApp\Controllers\MySql\InfoController as controllerInfo;
    use MyApp\Controllers\MySql\InnerController as controllerInner;
    use MyApp\Controllers\MySql\InsertController as controllerInsert;
    use MyApp\Controllers\MySql\UpdateController as controllerUpdate;

    use MyApp\Controllers\LogController as controllerLog;

    class GetRoute {
        public function __invoke(App $app) {
            $app->get('/', controllerRoot::class . ':index');
            GetRoute::api($app);
            GetRoute::jwt($app);
        }

        private function api($app) {
            $app->get('/api', controllerApi::class . ':index');
            $app->get('/api/param', controllerApi::class . ':param');
        }

        private function jwt($app) {
            $app->get('/jwt', controllerJwt::class . ':index');
            $app->get('/jwt/token', controllerJwt::class . ':token');
            $app->post('/jwt/verify', controllerJwt::class . ':verify');
            $app->get('/jwt/user', controllerJwt::class . ':user');
        }
    }
