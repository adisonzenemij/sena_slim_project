<?php
    namespace MyApp\Entities;

    use MyApp\Entities\Email\EmHosting;
    use MyApp\Entities\Email\EmSecurity;
    use MyApp\Entities\Email\EmSetting;
    
    class EmailEntity {
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
            $emHosting = new EmHosting($dtDataType, $dtBody);
            $emSecurity = new EmSecurity($dtDataType, $dtBody);
            $emSetting = new EmSetting($dtDataType, $dtBody);
            # Validar si existen las tablas con sus respectivos campos
            if ($dtTable == 'em_hosting') { $response = $emHosting->validate(); }
            if ($dtTable == 'em_security') { $response = $emSecurity->validate(); }
            if ($dtTable == 'em_setting') { $response = $emSetting->validate(); }
            # Retornar respuesta
            return $response;
        }
    }
