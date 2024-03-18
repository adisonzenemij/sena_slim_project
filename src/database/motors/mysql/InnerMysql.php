<?php
    namespace MyApp\Database\Motors\MySql;

    use MyApp\Functions\GeneralFunction as functionGeneral;
    use MyApp\Database\Motors\MySql\ConnectMysql;
    
    class InnerMysql extends ConnectMysql {
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
            $innerLabel = InnerMysql::innbel($data);
            # Agregar los resultados de innbel() a columnLabel
            $columnLabel = array_merge($columnLabel, $innerLabel);
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
            $innerTable = "tb_$dtTable";
            $tableLabel = 'lbl_' . $dtTable . '_';

            $labels = InnerMysql::label($data);
            $innerJoin = InnerMysql::join($data);
            $innerRelation = InnerMysql::relation($data);
            $whereData = InnerMysql::where($data);
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
                    $columnString = "$innerTable.$columnName AS $alias";
                    $columnsAlias[] = $columnString;
                }
            }
            # Unir las columnas con alias en una cadena separada por comas
            $columnsString = implode(', ', $columnsAlias);
            if ($innerRelation == '') { $separated = ''; }
            if ($innerRelation != '') { $separated = ','; }
            $sql = "SELECT $columnsString $separated $innerRelation" . ' ';
            $sql .= "FROM $dtTable $innerTable" . ' ';
            $sql .= "$innerJoin $whereData";
            return self::execute($sql);
        }

        # Construir inner join con tablas
        public static function join($data) {
            $dtTable = $data['table'];
            # Construccion de la sentencia sql
            $sql = "SHOW FULL COLUMNS FROM $dtTable";
            $result = self::execute($sql);
            $columnField = array();
            # Recorrer informacion de la sentencia
            foreach ($result as $column) {
                $resultField = $column->Field;
                if (strpos($resultField, 'id_') !== 0 &&
                    strpos($resultField, 'os_') !== 0
                ) {
                    $columnField[] = $resultField;
                }
            }
            # Construir INNER JOIN
            $innerJoins = '';
            foreach ($columnField as $field) {
                $innerJoins .= "INNER JOIN $field tb_$field" . ' ';
                $innerJoins .= "ON tb_$dtTable.$field" . ' ';
                $innerJoins .= "= tb_$field.id_register" . ' ';
            }
            return $innerJoins;
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
            # Eliminar la coma final
            $resultFinal = rtrim($resultFinal, ',');
            return $resultFinal;
        }
    }
