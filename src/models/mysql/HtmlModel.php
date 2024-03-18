<?php
    namespace MyApp\Models\MySql;

    use MyApp\Functions\ApiFunction as functionApi;
    use MyApp\Functions\JsonFunction as functionJson;
    use MyApp\Database\Motors\MySql\HtmlMysql as mysqlHtml;
    use MyApp\Database\Motors\MySql\ValidationMysql as mysqlValidation;
    
    class HtmlModel {
        public static function select($params) {
            $array = functionApi::queryParams($params);
            $results = mysqlHtml::select($array);
            return functionJson::jsonEncode($results);
        }
    }
