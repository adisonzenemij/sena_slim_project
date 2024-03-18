<?php
    namespace MyApp\Database\Motors\MySql;

    use MyApp\Database\Motors\MySql\ConnectMysql;
    use MyApp\Database\Motors\MySql\InfoMysql as mysqlInfo;
    use MyApp\Database\Motors\MySql\ValidationMysql as mysqlValidation;
    
    class UpdateMysql extends ConnectMysql {
        # Actualizar información de una tabla
        public static function data($data) {
            $dtTable = $data['table'];
            $dtColumn = $data['column'];
            $dtWhereCond = $data['whereCond'];
            $dtWhereField = $data['whereField'];
            $dtWhereOperator = $data['whereOperator'];
            $dtWhereEqual = $data['whereEqual'];
            $dtPutData = $data['putData'];
            # Crear un array para almacenar los valores
            $updateColumns = array();
            $paramValues = array();
            # Iterar a través de los datos de la variable
            foreach ($dtPutData as $columnName => $columnValue) {
                # Asegurar de que el nombre de la columna coincida
                if (in_array($columnName, explode(',', $dtColumn))) {
                    $updateColumns[] = "$columnName = '$columnValue'";
                    $paramName = ":$columnName";
                    $paramValues[$paramName] = $columnValue;
                }
            }
            # Construir la parte SET de la consulta SQL
            $setClause = implode(', ', $updateColumns);
            # Construir la parte WHERE de la consulta SQL
            $whereConditions = [];
            if (!empty($dtWhereField) && !empty($dtWhereOperator) && !empty($dtWhereEqual)) {
                $fields = explode(',', $dtWhereField);
                $operators = explode(',', $dtWhereOperator);
                $equals = explode(',', $dtWhereEqual);
                foreach ($fields as $index => $field) {
                    $whereConditions[] = "$field $operators[$index] '$equals[$index]'";
                }
            }
            $whereClause = implode(' ' . $dtWhereCond . ' ', $whereConditions);
            UpdateMysql::insert($data, $whereClause);
            # Construir la consulta SQL completa
            $sql = "UPDATE $dtTable SET $setClause WHERE $whereClause";
            $stmt = self::bindings($sql, $paramValues);
            $messageResponse = array();
            if ($stmt) {
                $messageInfo = 'Registro actualizado correctamente.';
                $messageResponse[] = array('success' => $messageInfo);
            }
            if (!$stmt) {
                $errorMessage = self::getErrorMessage();
                $messageInfo = 'Registro no procesado debidamente:';
                $messageResponse[] = array('error' => $messageInfo . ' ' . $errorMessage);
            }
            return $messageResponse;
        }

        public static function insert($data, $whereClause) {
            $dtTable = $data['table'];
            $dtPutData = $data['putData'];
            # Obtener fecha, hora y id de la tabla
            $tzDate = TZDATE; $tzHour = TZHOUR;
            $idRegister = $dtPutData['id_register'];
            $syModule = mysqlValidation::modulePrefix($data);
            # Iterar a través de los datos de la variable
            foreach ($dtPutData as $columnName => $columnValue) {
                # Asegurar de que el nombre de la columna coincida
                if (!empty($columnName) && $columnName !== 'id_register') {
                    # Construir la consulta SQL completa
                    $sqlUp = "SELECT $columnName
                        FROM $dtTable
                        WHERE $whereClause
                        AND $columnName = '$columnValue'
                    ";
                    # Ejecutar la consulta o almacenarla para su ejecución posterior
                    $resultUp = self::execute($sqlUp);
                    # Verificar si la consulta no devolvió resultados
                    if (empty($resultUp)) {
                        $sqlBk = "SELECT $columnName
                            FROM $dtTable
                            WHERE $whereClause
                        ";
                        # Ejecutar la consulta o almacenarla para su ejecución posterior
                        $resultBk = self::execute($sqlBk);
                        # Verificar si la consulta devolvió resultados
                        if (!empty($resultBk)) {
                            # Extraer el valor de la columna del primer resultado
                            $osShiftValue = reset($resultBk)->$columnName;
                            $insertSql = "INSERT INTO sy_change (
                                os_date,
                                os_hour,
                                os_register,
                                os_shift,
                                sy_eliminate,
                                sy_module
                            ) VALUES (
                                :os_date,
                                :os_hour,
                                :os_register,
                                :os_shift,
                                :sy_eliminate,
                                :sy_module
                            )";
                            $insertParams = [
                                ':os_date' => $tzDate,
                                ':os_hour' => $tzHour,
                                ':os_register' => $idRegister,
                                ':os_shift' => $osShiftValue,
                                ':sy_eliminate' => 1,
                                ':sy_module' => $syModule,
                            ];
                            self::bindings($insertSql, $insertParams);
                        }
                    }
                }
            }
        }
    }
    
