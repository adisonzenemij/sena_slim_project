<?php
    namespace MyApp\Models\MySql;

    use MyApp\Database\Motors\MySql\ReportMysql as mysqlReport;
    use MyApp\Database\Motors\MySql\ValidationMysql as mysqlValidation;
    
    use MyApp\Functions\ApiFunction as functionApi;
    use MyApp\Functions\JsonFunction as functionJson;
    
    class ReportModel {
        public static function settled($params) {
            $results = mysqlReport::settled($params);
            return functionJson::jsonEncode($results);
        }

        public static function causal($params) {
            $results = mysqlReport::causal($params);
            return functionJson::jsonEncode($results);
        }

        public static function request($params) {
            $results = mysqlReport::request($params);
            return functionJson::jsonEncode($results);
        }

        public static function pqrs($params) {
            $results = mysqlReport::pqrs($params);
            return functionJson::jsonEncode($results);
        }

        public static function dates($params, $error = false) {
            # Devolver respuesta en formato array
            $message = array();
            # Verificar si dateSince está definido, de lo contrario, asignar null
            $dateSince = isset($params['dateSince']) ? $params['dateSince'] : null;
            # Verificar si dateUntil está definido, de lo contrario, asignar null
            $dateUntil = isset($params['dateUntil']) ? $params['dateUntil'] : null;
            # Validar si el parametro está vacio
            if ($dateSince == null || $dateSince == '') {
                $noteInfo = 'El campo fecha desde es obligatorio';
                $message[] = array('warning' => $noteInfo);
                $error = true;
            }
            # Validar si el parametro está vacio
            if (!$error && ($dateUntil == null || $dateUntil == '')) {
                $noteInfo = 'El campo fecha hasta es obligatorio';
                $message[] = array('warning' => $noteInfo);
                $error = true;
            }
            # Validar entre parametros mayor que otro
            if (!$error && ($dateSince > $dateUntil)) {
                $noteInfo = 'El valor de fecha desde no debe' . ' ';
                $noteInfo .= 'ser mayor al valor de fecha hasta';
                $message[] = array('warning' => $noteInfo);
                $error = true;
            }
            # Validar parametros con informacion
            if (!$error && ($dateSince != null && $dateUntil != null) &&
                ($dateSince != '' && $dateUntil != '') &&
                ($dateSince <= $dateUntil)
            ) {
                $message[] = array('success' => 'Fechas correctas');
                $error = false;
            }
            return functionJson::jsonEncode($message);
        }
    }
