<?php
    namespace MyApp\Models\MySql;

    use MyApp\Functions\ApiFunction as functionApi;
    use MyApp\Functions\JsonFunction as functionJson;
    use MyApp\Database\Motors\MySql\UnionMysql as mysqlUnion;
    use MyApp\Database\Motors\MySql\ValidationMysql as mysqlValidation;
    
    class UnionModel {
        public static function label($params) {
            $array = functionApi::queryParams($params);
            $results = mysqlUnion::label($array);
            return functionJson::jsonEncode($results);
        }

        public static function alias($params) {
            $array = functionApi::queryParams($params);
            $results = mysqlUnion::alias($array);
            return functionJson::jsonEncode($results);
        }

        public static function module($params) {
            $array = functionApi::queryParams($params);
            $results = mysqlUnion::module($array);
            return functionJson::jsonEncode($results);
        }

        public static function menu($params) {
            $array = functionApi::queryParams($params);
            $results = mysqlUnion::menu($array);
            return functionJson::jsonEncode($results);
        }
    }
