<?php
    namespace MyApp\Models\MySql;

    use MyApp\Functions\ApiFunction as functionApi;
    use MyApp\Functions\JsonFunction as functionJson;
    use MyApp\Database\Motors\MySql\InnerMysql as mysqlInner;
    use MyApp\Database\Motors\MySql\ValidationMysql as mysqlValidation;
    
    class InnerModel {
        public static function label($params) {
            $array = functionApi::queryParams($params);
            $results = mysqlInner::label($array);
            return functionJson::jsonEncode($results);
        }

        public static function alias($params) {
            $array = functionApi::queryParams($params);
            $results = mysqlInner::alias($array);
            return functionJson::jsonEncode($results);
        }
    }
