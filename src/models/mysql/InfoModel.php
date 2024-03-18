<?php
    namespace MyApp\Models\MySql;

    use MyApp\Database\Motors\MySql\InfoMysql as mysqlInfo;
    use MyApp\Database\Motors\MySql\ValidationMysql as mysqlValidation;
    
    use MyApp\Functions\ApiFunction as functionApi;
    use MyApp\Functions\JsonFunction as functionJson;
    
    class InfoModel {
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
        
        public static function label($params) {
            $array = functionApi::queryParams($params);
            $results = mysqlInfo::label($array);
            return functionJson::jsonEncode($results);
        }

        public static function alias($params) {
            $array = functionApi::queryParams($params);
            $results = mysqlInfo::alias($array);
            return functionJson::jsonEncode($results);
        }

        public static function register($params) {
            $array = functionApi::queryParams($params);
            $results = mysqlInfo::register($array);
            return functionJson::jsonEncode($results);
        }
    }
