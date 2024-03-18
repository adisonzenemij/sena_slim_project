<?php
    namespace MyApp\Models;

    use MyApp\Functions\ApiFunction as functionApi;
    use MyApp\Functions\JsonFunction as functionJson;
    use MyApp\Database\Motors\MySql\InfoMysql as mysqlInfo;
    use MyApp\Database\Motors\MySql\ValidationMysql as mysqlValidation;
    
    class ApiModel {
        public static function column($params) {
            $array = functionApi::queryParams($params);
            $results = mysqlInfo::column($array);
            return functionJson::jsonEncode($results);
        }

        public static function select($params) {
            $array = functionApi::queryParams($params);
            $results = mysqlInfo::select($array);
            return functionJson::jsonEncode($results);
        }

        public static function table($params) {
            $array = functionApi::queryParams($params);
            $dtTable = $array['table'];
            
            if (isset($dtTable) && $dtTable !== null) {
                $results = mysqlValidation::table($array);
            }
            
            if (!isset($results) || empty($results)) {
                $results = array(array('error' => 'Tabla (' . $dtTable . ') Inexistente'));
            }
            
            return functionJson::jsonEncode($results);
        }
    }
