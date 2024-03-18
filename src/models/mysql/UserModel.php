<?php
    namespace MyApp\Models\MySql;

    use MyApp\Functions\ApiFunction as functionApi;
    use MyApp\Functions\JsonFunction as functionJson;

    use MyApp\Database\Motors\MySql\UserMysql as mysqlUser;
    use MyApp\Database\Motors\MySql\ValidationMysql as mysqlValidation;
    
    class UserModel {
        public static function login($params) {
            $array = functionApi::queryParams($params);
            $result = mysqlUser::login($array);
            return functionJson::jsonEncode($result);
        }
        
        public static function register($params) {
            $array = functionApi::queryParams($params);
            $result = mysqlUser::register($array);
            return functionJson::jsonEncode($result);
        }
    }
