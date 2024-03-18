<?php
    namespace MyApp\Routes;

    use Slim\App;
    use MyApp\Controllers\RootController as controllerRoot;
    use MyApp\Controllers\ApiController as controllerApi;
    use MyApp\Controllers\LogController as controllerLog;
    use MyApp\Controllers\MySql\MysqlController as controllerMysql;
    use MyApp\Controllers\MySql\DeleteController as controllerDelete;
    use MyApp\Controllers\MySql\HtmlController as controllerHtml;
    use MyApp\Controllers\MySql\InfoController as controllerInfo;
    use MyApp\Controllers\MySql\InnerController as controllerInner;
    use MyApp\Controllers\MySql\InsertController as controllerInsert;
    use MyApp\Controllers\MySql\ReportController as controllerReport;
    use MyApp\Controllers\MySql\UnionController as controllerUnion;
    use MyApp\Controllers\MySql\UpdateController as controllerUpdate;
    use MyApp\Controllers\MySql\UserController as controllerUser;

    class MySqlRoute {
        public function __invoke(App $app) {
            $app->get('/mysql', controllerMysql::class . ':index');
            $app->get('/mysql/list', controllerMysql::class . ':list');

            MySqlRoute::user($app);
            MySqlRoute::html($app);
            MySqlRoute::info($app);
            MySqlRoute::inner($app);
            MySqlRoute::union($app);
            MySqlRoute::insert($app);
            MySqlRoute::update($app);
            MySqlRoute::delete($app);
            MySqlRoute::report($app);
        }

        private function user($app) {
            # Formularios externos de la aplicacion segun modelo de usuarios
            $app->post('/mysql/user/login', controllerUser::class . ':login');
            $app->post('/mysql/user/register', controllerUser::class . ':register');
            $app->post('/mysql/user/recover', controllerUser::class . ':recover');
            $app->post('/mysql/user/password', controllerUser::class . ':password');
        }

        private function html($app) {
            # Consultar registros para llenar campo html select
            $app->get('/mysql/html/select', controllerHtml::class . ':select');
            # Consultar registros para llenar campo html select
            $app->get('/mysql/html/multiple', controllerHtml::class . ':multiple');
        }

        private function info($app) {
            $app->get('/mysql/info', controllerInfo::class . ':index');
            # Consultar registros sin etiquetar columnas
            $app->get('/mysql/info/column', controllerInfo::class . ':column');
            $app->get('/mysql/info/select', controllerInfo::class . ':select');
            # Consultar registros etiquetando columnas
            $app->get('/mysql/info/label', controllerInfo::class . ':label');
            $app->get('/mysql/info/alias', controllerInfo::class . ':alias');
            # Consultar un registro en especifico
            $app->get('/mysql/info/register', controllerInfo::class . ':register');
        }

        private function inner($app) {
            $app->get('/mysql/inner', controllerInner::class . ':index');
            # Consultar registros sin etiquetar columnas
            $app->get('/mysql/inner/column', controllerInner::class . ':column');
            $app->get('/mysql/inner/select', controllerInner::class . ':select');
            # Consultar registros etiquetando columnas
            $app->get('/mysql/inner/label', controllerInner::class . ':label');
            $app->get('/mysql/inner/alias', controllerInner::class . ':alias');
        }

        private function union($app) {
            $app->get('/mysql/union', controllerUnion::class . ':index');
            # Consultar registros etiquetando columnas
            $app->get('/mysql/union/label', controllerUnion::class . ':label');
            $app->get('/mysql/union/alias', controllerUnion::class . ':alias');
            # Consultar registros para el menu del aplicativo
            $app->get('/mysql/union/module', controllerUnion::class . ':module');
            $app->get('/mysql/union/menu', controllerUnion::class . ':menu');
        }

        private function insert($app) {
            # Insertar registros segun info del formulario
            $app->post('/mysql/insert/data', controllerInsert::class . ':data');
            $app->post('/mysql/insert/sy/module', controllerInsert::class . ':symodule');
            $app->post('/mysql/insert/tg/role', controllerInsert::class . ':tgrole');
            $app->post('/mysql/insert/tg/user', controllerInsert::class . ':tguser');
        }

        private function update($app) {
            # Actualizar registros segun info del formulario
            $app->put('/mysql/update/data', controllerUpdate::class . ':data');
        }

        private function delete($app) {
            # Eliminar registros segun info del formulario
            $app->delete('/mysql/delete/data', controllerDelete::class . ':data');
        }

        private function report($app) {
            # Consultar registros segun info de reportes
            $app->get('/mysql/report/settled', controllerReport::class . ':settled');
            $app->get('/mysql/report/causal', controllerReport::class . ':causal');
            $app->get('/mysql/report/request', controllerReport::class . ':request');
            $app->get('/mysql/report/pqrs', controllerReport::class . ':pqrs');
        }
    }
