<?php
    namespace MyApp\Models\MySql;

    use MyApp\Functions\ApiFunction as functionApi;
    use MyApp\Functions\GeneralFunction as functionGeneral;
    use MyApp\Functions\JsonFunction as functionJson;
    use MyApp\Database\Motors\MySql\InfoMysql as mysqlInfo;
    use MyApp\Database\Motors\MySql\ValidationMysql as mysqlValidation;
    
    class ValidateModel {
        public static function list() {
            # Devolver respuesta en formato array
            $message = array();
            # Retornar resultados de la base de datos
            $result = mysqlValidation::list();
            # Iterar resultados
            foreach ($result as $key) { $message[] = (array) $key; }
            # Retornar mensaje en formato json codificado
            return functionJson::jsonEncode($message);
        }

        public static function table($params, $error = false) {
            # Devolver respuesta en formato array
            $message = array();
            # Obtener parametros recibidos de la solicitud
            $data = functionApi::queryParams($params);
            # Obtener informacion de los parametros
            $dtTable = $data['table'];
            if ($dtTable !== null) { $message = mysqlValidation::table($data); }
            if ($dtTable == null || empty($dtTable) || empty($message)) { $error = true; }
            if ($error) { $message[] = array('error' => 'Tabla (' . $dtTable . ') Inexistente'); }
            # Retornar mensaje en formato json codificado
            return functionJson::jsonEncode($message);
        }

        public static function column($params, $error = false) {
            # Devolver respuesta en formato array
            $message = array();
            # Obtener parametros recibidos de la solicitud
            $data = functionApi::queryParams($params);
            # Obtener informacion de los parametros
            $dtColumn = $data['column'];
            # Validar que este definido y que no esté vacio
            if (isset($dtColumn) && $dtColumn != null) {
                # Dividir la cadena en columnas
                $columns = explode(',', $dtColumn);
                # Iterar sobre las columnas
                foreach ($columns as $key) {
                    # Asignar la columna actual
                    $data['column'] = trim($key);
                    # Retornar resultados de la base de datos
                    $validationResult = mysqlValidation::column($data);
                    # Validar si se encuentra vacio el resultado
                    if (empty($validationResult)) {
                        # Si la columna no existe, agregar el mensaje de error
                        $noteInfo = 'Columna (' . $data['column'] . ') Inexistente';
                        $message[] = array('error' => $noteInfo);
                        $error = true;
                    }
                }
            }
            # Retornar resultado si no se encontró ningun error
            if (!$error) { $message = mysqlValidation::column($data); }
            # Retornar mensaje en formato json codificado
            return functionJson::jsonEncode($message);
        }

        public static function whereCount($params) {
            # Devolver respuesta en formato array
            $message = array();
            # Obtener parametros recibidos de la solicitud
            $data = functionApi::queryParams($params);
            # Obtener informacion de los parametros
            $dtWhereCond = $data['whereCond'];
            $dtWhereField = $data['whereField'];
            $dtWhereOperator = $data['whereOperator'];
            $dtWhereEqual = $data['whereEqual'];
            # Divide las variables en arrays utilizando la coma como delimitador
            $condArray = explode(',', $dtWhereCond);
            $fieldArray = explode(',', $dtWhereField);
            $operatorArray = explode(',', $dtWhereOperator);
            $equalArray = functionGeneral::customExplode($dtWhereEqual);
            # Calcula las longitudes de los arrays
            $condCount = count($condArray);
            $fieldCount = count($fieldArray);
            $operatorCount = count($operatorArray);
            $equalCount = count($equalArray);
            # Compara las longitudes para verificar que sean iguales
            if ($condCount != $fieldCount || $fieldCount != $operatorCount || $operatorCount != $equalCount) {
                # Agregar valores de las variables al mensaje de error
                $whParams = '(whereCond), (whereField), (whereOperator), (whereEqual)';
                $noteInfo = "Los parámetros $whParams deben tener la misma cantidad de valores";
                $message[] = array('error' => $noteInfo);
                # Devolver mensaje de respuesta
                $msWhereCond = 'whereCond: (' . $condCount . ')';
                $msWhereCond .= ': (' . var_export($dtWhereCond, true) . ')';
                $message[] = array('error' => $msWhereCond);
                # Devolver mensaje de respuesta
                $msWhereField = 'whereField: (' . $fieldCount . ')';
                $msWhereField .= ': (' . var_export($dtWhereField, true) . ')';
                $message[] = array('error' => $msWhereField);
                # Devolver mensaje de respuesta
                $msWhereOperator = 'whereOperator: (' . $operatorCount . ')';
                $msWhereOperator .= ': (' . var_export($dtWhereOperator, true) . ')';
                $message[] = array('error' => $msWhereOperator);
                # Devolver mensaje de respuesta
                $msWhereEqual = 'whereEqual: (' . $equalCount . ')';
                $msWhereEqual .= ': (' . var_export($dtWhereEqual, true) . ')';
                $message[] = array('error' => $msWhereEqual);
            }
            # Retornar mensaje en formato json codificado
            return functionJson::jsonEncode($message);
        }

        public static function whereField($params, $error = false) {
            # Devolver respuesta en formato array
            $message = array();
            # Obtener parametros recibidos de la solicitud
            $data = functionApi::queryParams($params);
            # Obtener informacion de los parametros
            $dtWhereField = $data['whereField'];
            # Validar que este definido y que no esté vacio
            if (isset($dtWhereField) && $dtWhereField != null) {
                # Dividir la cadena en columnas
                $columns = explode(',', $dtWhereField);
                # Iterar sobre las columnas
                foreach ($columns as $key) {
                    # Asignar la columna actual
                    $data['whereField'] = trim($key);
                    # Retornar resultados de la base de datos
                    $validationResult = mysqlValidation::whereField($data);
                    # Validar si se encuentra vacio el resultado
                    if (empty($validationResult)) {
                        # Si la columna no existe, agregar el mensaje de error
                        $noteInfo = 'Columna (' . $data['whereField'] . ') Inexistente';
                        $message[] = array('error' => $noteInfo);
                        $error = true;
                    }
                }
            }
            # Retornar resultado si no se encontró ningun error
            if (!$error) { $message = mysqlValidation::whereField($data); }
            # Retornar mensaje en formato json codificado
            return functionJson::jsonEncode($message);
        }

        public static function body($params) {
            # Devolver respuesta en formato array
            $message = array();
            # Obtener parametros recibidos de la solicitud
            $data = functionApi::queryParams($params);
            # Obtener informacion de los parametros
            $dtColumn = $data['column'];
            if (!empty($data['postData'])) { $dtBody = $data['postData']; }
            if (!empty($data['putData'])) { $dtBody = $data['putData']; }
            if (!empty($data['deleteData'])) { $dtBody = $data['deleteData']; }
            # Validar que sea un array
            if (!is_array($dtBody)) {
                $noteInfo = 'Valores proporcionados incorrectamente';
                $message[] = array('error' => $noteInfo);
            }
            # Dividir la cadena en un array de columnas
            $columnArray = explode(',', $dtColumn);
            $bodyDataKeys = array_keys($dtBody);
            $bodyDataImplode = implode(',', $bodyDataKeys);
            $bodyDataArray = explode(',', $bodyDataImplode);
            # Validar la cantidad de resultados
            if (count($columnArray) !== count($bodyDataArray)) {
                $noteInfo = 'Cantidad de elementos no son iguales';
                $message[] = array('error' => $noteInfo);
            }
            # Validar si existen diferencias
            $differences = array_diff($columnArray, $bodyDataArray);
            if (!empty($differences)) {
                $noteInfo = 'Valores proporcionados no son identicos';
                $message[] = array('error' => $noteInfo);
            }
            # Retornar mensaje en formato json codificado
            return functionJson::jsonEncode($message);
        }

        public static function htmlSelect($params, $error = false) {
            # Devolver respuesta en formato array
            $message = array();
            # Obtener parametros recibidos de la solicitud
            $data = functionApi::queryParams($params);
            # Obtener informacion de los parametros
            $dtTable = $data['htmlSelect'];
            # Validar que no se encuentre vacio
            if ($dtTable == null) {
                $noteInfo = 'Parametro htmlSelect está vacio';
                $message[] = array('error' => $noteInfo);
            }
            if ($dtTable !== null) { $message = mysqlValidation::htmlSelect($data); }
            if ($dtTable == null || empty($dtTable) || empty($message)) { $error = true; }
            if ($error) { $message[] = array('error' => 'Tabla (' . $dtTable . ') Inexistente'); }
            # Retornar mensaje en formato json codificado
            return functionJson::jsonEncode($message);
        }
    }
