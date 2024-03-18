<?php
    namespace MyApp\Database\Motors\MySql;

    use MyApp\Functions\GeneralFunction as functionGeneral;
    use MyApp\Database\Motors\MySql\ConnectMysql;
    use MyApp\Database\Motors\MySql\InfoMysql as mysqlInfo;
    
    class UnionMysql extends ConnectMysql {
        # Construccion de la query condicionada
        public static function where($data) {
            $dtTable = $data['table'];
            $lblTable = "tb_$dtTable";
            $dtWhereCond = $data['whereCond'];
            $dtWhereField = $data['whereField'];
            $dtWhereOperator = $data['whereOperator'];
            $dtWhereEqual = $data['whereEqual'];
            # Dividir las cadenas en arrays
            $condArray = explode(',', $dtWhereCond);
            $fieldArray = explode(',', $dtWhereField);
            $operatorArray = explode(',', $dtWhereOperator);
            $equalArray = functionGeneral::customExplode($dtWhereEqual);
            # Inicializar la parte WHERE de la consulta SQL
            $sqlWhere = '';
            # Verificar que todos los arrays tengan la misma longitud
            if (count($condArray) === count($fieldArray) &&
                count($fieldArray) === count($operatorArray) &&
                count($operatorArray) === count($equalArray) &&
                !empty(array_filter($condArray)) &&
                !empty(array_filter($fieldArray)) &&
                !empty(array_filter($operatorArray)) &&
                !empty(array_filter($equalArray))
            ) {
                # Inicializar el operador lógico
                $logicalOperator = '';
                # Construir la cláusula WHERE
                $conditions = [];
                for ($i = 0; $i < count($condArray); $i++) {
                    $value = $equalArray[$i];
                    # Verificar si el valor está entre paréntesis y no agregar apóstrofes
                    if (substr($value, 0, 1) === '(' && substr($value, -1) === ')') {
                        $condition = $condArray[$i] . ' ' .
                            "$lblTable.$fieldArray[$i]" . ' ' .
                            $operatorArray[$i] . ' ' .
                            $value;
                    } else {
                        # Agregar apóstrofes a los demás valores
                        $condition = $condArray[$i] . ' ' .
                            "$lblTable.$fieldArray[$i]" . ' ' .
                            $operatorArray[$i] . ' ' .
                            "'$value'";
                    }
                    $conditions[] = $condition;
                }
                # Unir las condiciones con el operador lógico apropiado
                $sqlWhere .= implode(" $logicalOperator ", $conditions);
            }
            return $sqlWhere;
        }

        # Consultar columnas de una tabla con una adicional
        public static function label($data) {
            $dtTable = $data['table'];
            $dtColumn = rtrim($data['column'], ',');
            $fields = explode(',', $dtColumn);
            # Construccion de la sentencia sql
            $sql = "SHOW FULL COLUMNS FROM $dtTable";
            $result = self::execute($sql);
            $columnLabel = array();
            # Recorrer informacion de la sentencia
            foreach ($result as $column) {
                $columnName = $column->Field;
                $label = 'lbl_' . $dtTable . '_';
                # Conservar solo campos por los que comienzan
                if (strpos($columnName, 'id_') !== 0 &&
                    strpos($columnName, 'os_') !== 0
                ) {
                    continue;
                }
                # Convertir el resultado de stdClass a un array asociativo
                $columnArray = (array) $column;
                if (in_array($columnName, $fields) || $dtColumn === '*') {
                    # Agregar una columna "Label" al resultado
                    $columnArray['Label'] = $label . $columnName;
                    $columnLabel[] = $columnArray;
                }
            }
            $unionLabel = UnionMysql::innbel($data);
            # Agregar los resultados de innbel() a columnLabel
            $columnLabel = array_merge($columnLabel, $unionLabel);
            return $columnLabel;
        }

        # Consultar columnas de una tabla con una adicional
        public static function innbel($data) {
            $dtTable = $data['table'];
            $partsTable = explode('_', $dtTable);
            $tablePrefix = $partsTable[0];
            $tableName = $partsTable[1];
            /* Parte 1 */
            $sqlPrefix = "SELECT * FROM `sy_prefix`" . ' ';
            $sqlPrefix .= "WHERE `os_prefix` = '$tablePrefix'";
            $resPrefix = self::execute($sqlPrefix);
            $syPrefixIdRegister = 0;
            if ($resPrefix) { foreach ($resPrefix as $row) { $syPrefixIdRegister = $row->id_register; } }
            /* Parte 2 */
            $sqlModule = "SELECT * FROM `sy_module`" . ' ';
            $sqlModule .= "WHERE `os_table` = '$tableName'" . ' ';
            $sqlModule .= "AND `sy_prefix` = '$syPrefixIdRegister'";
            $resModule = self::execute($sqlModule);
            $syModuleIdRegister = 0;
            if ($resModule) { foreach ($resModule as $row) { $syModuleIdRegister = $row->id_register; } }
            /* Parte 3 */
            $sqlUnion = "SELECT * FROM `sy_union`" . ' ' ;
            $sqlUnion .= "WHERE `sy_module` = '$syModuleIdRegister'" . ' ' ;
            $sqlUnion .= "ORDER BY `os_order` ASC";
            $resUnion = self::execute($sqlUnion);
            $columnLabel = array();
            if ($resUnion) {
                foreach ($resUnion as $row) {
                    $syUnionSyRelation = $row->sy_relation;
                    $syUnionSyAttribute = $row->sy_attribute;
                    $sqlRelation = "SELECT * FROM `sy_relation`" . ' ';
                    $sqlRelation .= "WHERE `id_register` = '$syUnionSyRelation'";
                    $resRelation = self::execute($sqlRelation);
                    $syRelationOsName = '';
                    if ($resRelation) { foreach ($resRelation as $row) { $syRelationOsName = $row->os_name; } }
                    $sqlAttribute = "SELECT * FROM `sy_attribute`" . ' ';
                    $sqlAttribute .= "WHERE `id_register` = '$syUnionSyAttribute'";
                    $resAttribute = self::execute($sqlAttribute);
                    $syAttributeOsName = '';
                    if ($resAttribute) { foreach ($resAttribute as $row) { $syAttributeOsName = $row->os_name; } }
                    $sql = "SHOW FULL COLUMNS FROM $syRelationOsName" . ' ';
                    $sql .= "WHERE Field = '$syAttributeOsName'" . ' ';
                    $result = self::execute($sql);
                    # Recorrer informacion de la sentencia
                    if ($result) {
                        foreach ($result as $column) {
                            $columnArray = (array) $column;
                            $label = 'lbl_' . $syRelationOsName . '_';
                            # Agregar una columna "Label" al resultado
                            $columnArray['Label'] = $label . $columnArray['Field'];
                            $columnLabel[] = $columnArray;
                        }
                    }

                }
            }
            return $columnLabel;
        }
        
        # Consultar columnas de una tabla con alias
        public static function alias($data) {
            $dtTable = $data['table'];
            $unionTable = "tb_$dtTable";
            $tableLabel = 'lbl_' . $dtTable . '_';

            $labels = UnionMysql::label($data);
            $unionJoin = UnionMysql::join($data);
            $unionRelation = UnionMysql::relation($data);
            $whereData = UnionMysql::where($data);
            # Construir la lista de columnas con alias
            $columnsAlias = array();
            foreach ($labels as $labeld) {
                $columnName = $labeld['Field'];
                $alias = $labeld['Label'];
                if (preg_match("/^$tableLabel/", $alias) &&
                    (strpos($columnName, 'id_') === 0 ||
                        strpos($columnName, 'os_') === 0
                    )
                ) {
                    $columnString = "$unionTable.$columnName AS $alias";
                    $columnsAlias[] = $columnString;
                }
            }
            # Unir las columnas con alias en una cadena separada por comas
            $columnsString = implode(', ', $columnsAlias);
            if ($unionRelation == '') { $separated = ''; }
            if ($unionRelation != '') { $separated = ','; }
            $sql = "SELECT $columnsString $separated $unionRelation" . ' ';
            $sql .= "FROM $dtTable $unionTable" . ' ';
            $sql .= "$unionJoin $whereData";
            return self::execute($sql);
        }

        # Construir inner join con tablas
        public static function join($data) {
            $dtTable = $data['table'];
            // Construccion de la sentencia sql
            $sql = "SHOW FULL COLUMNS FROM $dtTable";
            $result = self::execute($sql);
            $columnField = array();
            // Recorrer informacion de la sentencia
            foreach ($result as $column) {
                $resultField = $column->Field;
                if (strpos($resultField, 'id_') !== 0 &&
                    strpos($resultField, 'os_') !== 0
                ) {
                    $columnField[] = $resultField;
                }
            }
            // Construir INNER JOIN
            $unionJoins = '';
            foreach ($columnField as $field) {
                $unionJoins .= "INNER JOIN $field tb_$field" . ' ';
                $unionJoins .= "ON tb_$dtTable.$field" . ' ';
                $unionJoins .= "= tb_$field.id_register" . ' ';
            }
            return $unionJoins;
        }

        # Construir relaciones de columnas
        public static function relation($data) {
            $dtTable = $data['table'];
            $partsTable = explode('_', $dtTable);
            $tablePrefix = $partsTable[0];
            $tableName = $partsTable[1];

            /* Parte 1 */
            $sqlPrefix = "SELECT * FROM `sy_prefix`" . ' ';
            $sqlPrefix .= "WHERE `os_prefix` = '$tablePrefix'";
            $resPrefix = self::execute($sqlPrefix);

            $syPrefixIdRegister = 0;
            if ($resPrefix) { foreach ($resPrefix as $row) { $syPrefixIdRegister = $row->id_register; } }

            /* Parte 2 */
            $sqlModule = "SELECT * FROM `sy_module`" . ' ';
            $sqlModule .= "WHERE `os_table` = '$tableName'" . ' ';
            $sqlModule .= "AND `sy_prefix` = '$syPrefixIdRegister'";
            $resModule = self::execute($sqlModule);
            
            $syModuleIdRegister = 0;
            if ($resModule) { foreach ($resModule as $row) { $syModuleIdRegister = $row->id_register; } }

            /* Parte 3 */
            $sqlUnion = "SELECT * FROM `sy_union`" . ' ';
            $sqlUnion .= "WHERE `sy_module` = '$syModuleIdRegister'" . ' ';
            $sqlUnion .= "ORDER BY `os_order` ASC";
            $resUnion = self::execute($sqlUnion);
            
            $resultFinal = '';
            if ($resUnion) {
                foreach ($resUnion as $row) {
                    $syUnionSyRelation = $row->sy_relation;
                    $syUnionSyAttribute = $row->sy_attribute;
                    $sqlRelation = "SELECT * FROM `sy_relation`" . ' ';
                    $sqlRelation .= "WHERE `id_register` = '$syUnionSyRelation'";
                    $resRelation = self::execute($sqlRelation);
                    $syRelationOsName = '';
                    if ($resRelation) { foreach ($resRelation as $row) { $syRelationOsName = $row->os_name; } }
                    $sqlAttribute = "SELECT * FROM `sy_attribute`" . ' ';
                    $sqlAttribute .= "WHERE `id_register` = '$syUnionSyAttribute'";
                    $resAttribute = self::execute($sqlAttribute);
                    $syAttributeOsName = '';
                    if ($resAttribute) { foreach ($resAttribute as $row) { $syAttributeOsName = $row->os_name; } }
                    $lblTable = "lbl_$syRelationOsName";
                    $asLable = $lblTable . "_" . $syAttributeOsName;
                    $resultFinal .= "tb_$syRelationOsName.$syAttributeOsName AS $asLable,";

                }
            }
            // Eliminar la coma final
            $resultFinal = rtrim($resultFinal, ',');
            return $resultFinal;
        }
        
        # Consultar columnas de una tabla con alias
        public static function module($data) {
            $dtWhereEqual = $data['whereEqual'];
            $sql = "SELECT
                    mo_sy_prefix.id_register AS 'mo_sy_prefix_id_register',
                    mo_sy_prefix.os_module AS 'mo_sy_prefix_os_module',
                    mo_sy_prefix.os_template AS 'mo_sy_prefix_os_template'
                FROM tg_permit tb_tg_permit
                
                INNER JOIN sy_module tb_sy_module
                ON tb_tg_permit.sy_module = tb_sy_module.id_register
                
                    INNER JOIN sy_icon mo_sy_icon
                    ON tb_sy_module.sy_icon = mo_sy_icon.id_register
                
                    INNER JOIN sy_prefix mo_sy_prefix
                    ON tb_sy_module.sy_prefix = mo_sy_prefix.id_register
                
                INNER JOIN tg_action tb_tg_action
                ON tb_tg_permit.tg_action = tb_tg_action.id_register
                
                INNER JOIN tg_authorization tb_tg_authorization
                ON tb_tg_permit.tg_authorization = tb_tg_authorization.id_register
                
                INNER JOIN tg_role tb_tg_role
                ON tb_tg_permit.tg_role = tb_tg_role.id_register
                
                WHERE tb_tg_permit.tg_action = 1
                    AND tb_tg_permit.tg_authorization = 1
                    AND tb_tg_permit.tg_role = $dtWhereEqual
                GROUP BY mo_sy_prefix.id_register
                ORDER BY mo_sy_prefix.id_register
            ";
            return self::execute($sql);
        }
        
        # Consultar columnas de una tabla con alias
        public static function menu($data) {
            $dtWhereEqual = $data['whereEqual'];
            $sql = "SELECT
                    tb_sy_module.os_name AS 'tb_sy_module_os_name',
                    tb_sy_module.os_table AS 'tb_sy_module_os_table',
                    mo_sy_icon.os_name AS 'mo_sy_icon_os_name',
                    mo_sy_prefix.os_module AS 'mo_sy_prefix_os_module',
                    mo_sy_prefix.os_template AS 'mo_sy_prefix_os_template'
                FROM tg_permit tb_tg_permit
                
                INNER JOIN sy_module tb_sy_module
                ON tb_tg_permit.sy_module = tb_sy_module.id_register
                
                    INNER JOIN sy_icon mo_sy_icon
                    ON tb_sy_module.sy_icon = mo_sy_icon.id_register
                
                    INNER JOIN sy_prefix mo_sy_prefix
                    ON tb_sy_module.sy_prefix = mo_sy_prefix.id_register
                
                INNER JOIN tg_action tb_tg_action
                ON tb_tg_permit.tg_action = tb_tg_action.id_register
                
                INNER JOIN tg_authorization tb_tg_authorization
                ON tb_tg_permit.tg_authorization = tb_tg_authorization.id_register
                
                INNER JOIN tg_role tb_tg_role
                ON tb_tg_permit.tg_role = tb_tg_role.id_register
                
                WHERE tb_tg_permit.tg_action = 1
                    AND tb_tg_permit.tg_authorization = 1
                    AND tb_tg_permit.tg_role = $dtWhereEqual
            ";
            return self::execute($sql);
        }
    }
