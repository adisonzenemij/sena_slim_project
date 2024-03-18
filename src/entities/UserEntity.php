<?php
    namespace MyApp\Entities;

    use MyApp\Entities\User\UsPassword;
    use MyApp\Entities\User\UsProccess;
    
    class UserEntity {
        public static function export($params) {
            $response = array();
            $dtBody = [];
            $dtDataType = $params['dataType'];
            $dtTable = $params['table'];
            $dtPostData = $params['postData'];
            $dtPutData = $params['putData'];
            $dtDeleteData = $params['deleteData'];
            if (!empty($dtPostData)) { $dtBody = $params['postData']; }
            if (!empty($dtPutData)) { $dtBody = $params['putData']; }
            if (!empty($dtDeleteData)) { $dtBody = $params['deleteData']; }
            # Instanciar clases
            $usPassword = new UsPassword($dtDataType, $dtBody);
            $usProccess = new UsProccess($dtDataType, $dtBody);
            # Validar si existen las tablas con sus respectivos campos
            if ($dtTable == 'us_password') { $response = $usPassword->validate(); }
            if ($dtTable == 'us_proccess') { $response = $usProccess->validate(); }
            # Retornar respuesta
            return $response;
        }
    }
