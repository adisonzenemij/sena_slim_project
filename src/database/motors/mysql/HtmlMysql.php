<?php
    namespace MyApp\Database\Motors\MySql;

    use MyApp\Database\Motors\MySql\ConnectMysql;
    
    class HtmlMysql extends ConnectMysql {
        public static function select($data) {
            $messageResponse = array();

            $dtTable = $data['table'];
            $dtHtmlSelect = $data['htmlSelect'];
            $dtHtmlMulti = $data['htmlMulti'];
            $dtHMultiValue = $data['multiValue'];

            $whereClause = '';
            if ($dtHtmlMulti != '' && $dtHMultiValue != '') {
                $whereClause .= "WHERE $dtHtmlMulti = '$dtHMultiValue'";
            }

            $partsTable = explode('_', $dtTable);
            $tablePrefix = $partsTable[0];
            $tableName = $partsTable[1];

            /* Parte 1 */
            $sqlPrefix = "
                SELECT * FROM `sy_prefix`
                WHERE `os_prefix` = '$tablePrefix'
            ";
            $resPrefix = self::execute($sqlPrefix);

            $syPrefixIdRegister = 0;
            if ($resPrefix) { foreach ($resPrefix as $row) { $syPrefixIdRegister = $row->id_register; } }

            /* Parte 2 */
            $sqlModule = "
                SELECT * FROM `sy_module`
                WHERE `os_table` = '$tableName'
                AND `sy_prefix` = '$syPrefixIdRegister'
            ";
            $resModule = self::execute($sqlModule);
            
            $syModuleIdRegister = 0;
            if ($resModule) { foreach ($resModule as $row) { $syModuleIdRegister = $row->id_register; } }

            /* Parte 3 */
            $sqlRelation = "
                SELECT * FROM `sy_relation`
                WHERE `os_name` = '$dtHtmlSelect'
                AND `sy_module` = '$syModuleIdRegister'
            ";
            $resRelation = self::execute($sqlRelation);
            
            $syRelationIdRegister = 0;
            if ($resRelation) { foreach ($resRelation as $row) { $syRelationIdRegister = $row->id_register; } }

            /* Parte 4 */
            $sqlSelect = "
                SELECT * FROM `sy_select`
                WHERE `sy_module` = '$syModuleIdRegister'
                AND `sy_relation` = '$syRelationIdRegister'
                ORDER BY `os_order`
            ";
            $resSelect = self::execute($sqlSelect);
            
            $sySelectSyAttritube = "0,";
            if ($resSelect) { foreach ($resSelect as $row) { $sySelectSyAttritube .= $row->sy_attribute . ','; } }
            $sySelectSyAttritube = rtrim($sySelectSyAttritube, ',');

            /* Parte 5 */
            $sqlAttribute = "
                SELECT * FROM `sy_attribute`
                WHERE `id_register` IN (" . rtrim($sySelectSyAttritube, ",") . ")
            ";
            $resAttribute = self::execute($sqlAttribute);

            $syAttributeOsName = "";
            if ($resAttribute) { foreach ($resAttribute as $row) { $syAttributeOsName .= $row->os_name . ','; } }
            $syAttributeOsName = rtrim($syAttributeOsName, ',');

            /* Parte 6 */
            $resFinal = "";
            if ($syAttributeOsName == '' || $syAttributeOsName == null) { $resFinal = $messageResponse[] = array(); }
            if ($syAttributeOsName != '' || $syAttributeOsName != null) {
                $sqlFinal = "SELECT $syAttributeOsName FROM $dtHtmlSelect $whereClause ORDER BY `id_register`";
                $resFinal = self::execute($sqlFinal);
            }
            return $resFinal;
        }
    }
