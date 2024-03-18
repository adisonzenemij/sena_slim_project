<?php
    namespace MyApp\Database\Motors\MySql;

    use MyApp\Database\Motors\MySql\ConnectMysql;
    
    class DeleteMysql extends ConnectMysql {
        # Eliminar informacion la tabla
        public static function data($data) {
            $dtTable = $data['table'];
            $dtWhereCond = $data['whereCond'];
            $dtWhereField = $data['whereField'];
            $dtWhereOperator = $data['whereOperator'];
            $dtWhereEqual = $data['whereEqual'];
    
            // Construir la parte WHERE de la consulta SQL
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
        
            // Construir la sentencia completa con marcadores
            $sql = "DELETE FROM $dtTable WHERE $whereClause";
            $stmt = self::execute($sql);

            $query = "SELECT * FROM $dtTable WHERE $whereClause";
            $select = self::execute($query);

            $messageResponse = array();

            if ($stmt !== false && $select !== false) {
                $messageInfo = 'Registro eliminado correctamente.';
                $messageResponse[] = array('success' => $messageInfo);
            } else {
                $errorMessage = self::getErrorMessage();
                $messageInfo = 'Registro no procesado debidamente:';
                $messageResponse[] = array('error' => $messageInfo . ' ' . $errorMessage);
            }
            return $messageResponse;
        }
    }
