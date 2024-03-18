<?php
    namespace MyApp\Database\Motors\MySql;

    use MyApp\Database\Motors\MySql\ConnectMysql;
    
    class InfoMysql extends ConnectMysql {
        # Consultar columnas de una tabla normal
        public static function column($data) {
            $table = $data['table'];
            $dtColumn = $data['column'];
            # Construcción de la sentencia SQL
            $sql = "SHOW FULL COLUMNS FROM $table";
            $result = self::execute($sql);
            # Si se solicitan todas las columnas, retornar toda la información
            if ($dtColumn === '*') { return $result; } else {
                # Si se especifican columnas, retornar solo las especificadas
                $fields = explode(',', $dtColumn);
                $filteredColumns = array();
                foreach ($result as $column) {
                    $columnName = $column->Field;
                    if (in_array($columnName, $fields)) {
                        $filteredColumns[] = $column;
                    }
                }
                return $filteredColumns;
            }
        }

        # Consultar columnas de una tabla, todas o especificadas
        public static function select($data) {
            $table = $data['table'];
            $dtColumn = rtrim($data['column'], ',');
            $whereData = InfoMysql::where($data);
            # Inicializar la consulta SQL
            $sql = "SELECT $dtColumn FROM $table $whereData";
            return self::execute($sql);
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
                # Convertir el resultado de stdClass a un array asociativo
                $columnArray = (array) $column;
                if (in_array($columnName, $fields) || $dtColumn === '*') {
                    # Agregar una columna "Label" al resultado
                    $columnArray['Label'] = $label . $columnName;
                    $columnLabel[] = $columnArray;
                }
            }
            return $columnLabel;
        }
        
        # Consultar columnas de una tabla con alias
        public static function alias($data) {
            $dtTable = $data['table'];
            $labels = InfoMysql::label($data);
            $whereData = InfoMysql::where($data);
            # Construir la lista de columnas con alias
            $columnsAlias = array();
            foreach ($labels as $label) {
                $columnName = $label['Field'];
                $alias = $label['Label'];
                $columnString = "$columnName AS $alias";
                $columnsAlias[] = $columnString;
            }
            # Unir las columnas con alias en una cadena separada por comas
            $columnsString = implode(', ', $columnsAlias);
            $sql = "SELECT $columnsString FROM $dtTable $whereData";
            return self::execute($sql);
        }

        # Consultar columnas de una tabla, todas o especificadas
        public static function register($data) {
            $table = $data['table'];
            $dtColumn = rtrim($data['column'], ',');
            $whereData = InfoMysql::where($data);
            # Inicializar la consulta SQL
            $sql = "SELECT $dtColumn FROM $table $whereData";
            return self::execute($sql);
        }

        # Construccion de la query condicionada
        public static function where($data) {
            $dtWhereCond = $data['whereCond'];
            $dtWhereField = $data['whereField'];
            $dtWhereOperator = $data['whereOperator'];
            $dtWhereEqual = $data['whereEqual'];
            # Dividir las cadenas en arrays
            $condArray = explode(',', $dtWhereCond);
            $fieldArray = explode(',', $dtWhereField);
            $operatorArray = explode(',', $dtWhereOperator);
            $equalArray = explode(',', $dtWhereEqual);
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
                    if ($equalArray[$i] !== "''") {
                        $condition = $condArray[$i] . ' ' .
                            $fieldArray[$i] . ' ' .
                            $operatorArray[$i] . ' ' . "'" . $equalArray[$i] . "'";
                        $conditions[] = $condition;
                    }
                }
                # Unir las condiciones con el operador lógico apropiado
                $sqlWhere .= implode(" $logicalOperator ", $conditions);
            }
            return $sqlWhere;
        }
    }
