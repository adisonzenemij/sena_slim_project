<?php
    namespace MyApp\Models\MySql;

    use MyApp\Functions\ApiFunction as functionApi;
    use MyApp\Functions\JsonFunction as functionJson;
    use MyApp\Database\Motors\MySql\InsertMysql as mysqlInsert;
    use MyApp\Database\Motors\MySql\ValidationMysql as mysqlValidation;

    use MyApp\Entities\ApplicationEntity as entityAp;
    use MyApp\Entities\EmailEntity as entityEm;
    use MyApp\Entities\SystemEntity as entitySy;
    use MyApp\Entities\TechnologyEntity as entityTg;
    use MyApp\Entities\UserEntity as entityUs;
    
    class InsertModel {
        public static function data($params, $flag = false) {
            $array = functionApi::queryParams($params);

            $entityAp = entityAp::export($array);
            if ($entityAp) { $results = $entityAp; $flag = true; }
            $entityEm = entityEm::export($array);
            if (!$flag && $entityEm) { $results = $entityEm; $flag = true; }
            $entitySy = entitySy::export($array);
            if (!$flag && $entitySy) { $results = $entitySy; $flag = true; }
            $entityTg = entityTg::export($array);
            if (!$flag && $entityTg) { $results = $entityTg; $flag = true; }
            $entityUs = entityUs::export($array);
            if (!$flag && $entityUs) { $results = $entityUs; $flag = true; }
            
            if (!$flag) { $results = mysqlInsert::data($array); }
            return functionJson::jsonEncode($results);
        }
        
        public static function symodule($params) {
            $array = functionApi::queryParams($params);
            $results = mysqlInsert::symodule($array);
            return functionJson::jsonEncode($results);
        }
        
        public static function tgrole($params) {
            $array = functionApi::queryParams($params);
            $results = mysqlInsert::tgrole($array);
            return functionJson::jsonEncode($results);
        }
    }
