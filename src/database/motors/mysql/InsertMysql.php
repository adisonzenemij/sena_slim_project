<?php
    namespace MyApp\Database\Motors\MySql;

    use MyApp\Functions\EncryptFunction as functionEncrypt;
    use MyApp\Database\Motors\MySql\ConnectMysql;
    
    class InsertMysql extends ConnectMysql {
        # Encriptar contraseña de forma segura
        private static function password($data) {
            $dtPostData = $data['postData'];
            # Verificar si está presente en la variable
            if (is_array($dtPostData) && array_key_exists('os_password', $dtPostData)) {
                # Obtiene la contraseña sin encriptar
                $plainPassword = $dtPostData['os_password'];
                return functionEncrypt::bcrypt($plainPassword);
            }
        }

        # Insertar registros en respectivas tablas
        public static function data($data) {
            $messageResponse = array();
            $dtTable = $data['table'];
            $dtColumn = $data['column'];
            $dtPostData = $data['postData'];
            if ($dtTable == 'tg_user') {
                $hassPassword = InsertMysql::password($data);
                $dtPostData['os_password'] = $hassPassword;
            }
            # Dividir la cadena en un array de columnas
            $columnArray = explode(',', $dtColumn);
            # Crear un array para almacenar los valores
            $columnNames = array();
            $paramNames = array();
            $paramValues = array();
            # Iterar a través de las columnas proporcionadas
            foreach ($columnArray as $columnName) {
                if (array_key_exists($columnName, $dtPostData)) {
                    $columnNames[] = $columnName;
                    $paramName = ":$columnName";
                    $paramNames[] = $paramName;
                    $paramValues[$paramName] = $dtPostData[$columnName];
                }
            }
            if (empty($columnNames) || empty($paramNames)) {
                $messageResponse[] = array('error' => 'No se proporcionaron valores correctos');
                return $messageResponse;
            }
            # Crear la parte de la sentencia SQL para los nombres de las columnas
            $columnsPart = implode(', ', $columnNames);
            $paramNamesPart = implode(', ', $paramNames);
            # Construir la sentencia completa con marcadores
            $sql = "INSERT INTO $dtTable ($columnsPart) VALUES ($paramNamesPart)";
            $stmt = self::bindings($sql, $paramValues);
            
            if ($stmt) {
                $response = ''; $multi = false;
                $msgError = 'Registro no almacenado debidamente.';
                $msgSuccess = 'Registro almacenado correctamente.';
                if ($dtTable != 'tg_action' &&
                    $dtTable != 'tg_role' &&
                    $dtTable != 'sy_module'
                ) { $multi = true; }
                if ($dtTable == 'tg_action') { $multi = InsertMysql::tgAction($data); }
                if ($dtTable == 'tg_role') { $multi = InsertMysql::tgRole($data); }
                if ($dtTable == 'sy_module') { $multi = InsertMysql::syModule($data); }
                if (!$multi) { $messageInfo = $msgError; $response = 'error'; }
                if ($multi) { $messageInfo = $msgSuccess; $response = 'success'; }
                $messageResponse[] = array($response => $messageInfo);
            }
            if (!$stmt) {
                $errorMessage = self::getErrorMessage();
                $messageInfo = 'Registro no procesado debidamente:';
                $messageResponse[] = array('error' => $messageInfo . ' ' . $errorMessage);
            }
            return $messageResponse;
        }

        # Consultar columnas de una tabla con alias
        public static function maxIdRegister($data, $lblMax = 0) {
            $dtTable = $data['table'];
            # Inicializar la consulta SQL
            $sql = "SELECT MAX(id_register) AS 'lbl_max' FROM $dtTable";
            # Ejecutar la consulta
            $stmt = self::execute($sql);
            # Verificar si la consulta fue exitosa
            if ($stmt !== false && count($stmt) > 0) {
                # Obtener el resultado como arreglo asociativo
                $result = $stmt[0];
                # Obtener el valor de lbl_max
                $lblMax = $result->lbl_max;
            }
            return $lblMax;
        }

        # Consultar columnas de una tabla con alias
        public static function rowIdRegister($dtTable) {
            # Arreglo de almacen para resultados
            $results = [];
            # Inicializar la consulta SQL
            $sql = "SELECT id_register FROM $dtTable";
            # Ejecutar la consulta
            $stmt = self::execute($sql);
            # Verificar si la consulta fue exitosa
            if ($stmt !== false && count($stmt) > 0) {
                foreach ($stmt as $object) {
                    $results[] = $object->id_register;
                }
            }
            return $results;
        }
        
        # Consultar columnas de una tabla con alias
        public static function tgAction($data, $mssg = false) {
            $valuesFields = '';
            $paramValues = array();
            $tgAction = InsertMysql::maxIdRegister($data);
            $syModule = InsertMysql::rowIdRegister('sy_module');
            $tgRole = InsertMysql::rowIdRegister('tg_role');
            if ($tgAction != 0 && !empty($tgAction)) {
                if (count($syModule) > 0 && count($tgRole) > 0) {
                    foreach ($syModule as $module) {
                        foreach ($tgRole as $role) {
                            $valuesFields .= "(1, $module, $tgAction, 2, $role),";
                            // Agregar parámetros a $paramValues
                            $paramValues[] = array(
                                ':sy_eliminate' => 1,
                                ':sy_module' => $tgAction,
                                ':tg_action' => $module,
                                ':tg_authorization' => 2,
                                ':tg_role' => $role
                            );
                        }
                    }
                }
                $valuesFields = rtrim($valuesFields, ',');
                $column = "sy_eliminate, sy_module,";
                $column .= "tg_action, tg_authorization, tg_role";
                $insert = "INSERT INTO tg_permit ($column) VALUES $valuesFields";
                // Llamar a excBindVal en lugar de bindings
                $stmt = self::insertBindVal($insert, $paramValues);
                // Aquí puedes manejar el resultado según tus necesidades
                if ($stmt) { $mssg = true; } else { $mssg = false; }
            }
            return $mssg;
        }
        
        # Consultar columnas de una tabla con alias
        public static function tgRole($data, $mssg = false) {
            $valuesFields = '';
            $paramValues = array();
            $tgRole = InsertMysql::maxIdRegister($data);
            $syModule = InsertMysql::rowIdRegister('sy_module');
            $tgAction = InsertMysql::rowIdRegister('tg_action');
            if ($tgRole != 0 && !empty($tgRole)) {
                if (count($syModule) > 0 && count($tgAction) > 0) {
                    foreach ($syModule as $module) {
                        foreach ($tgAction as $action) {
                            $valuesFields .= "(1, $module, $action, 2, $tgRole),";
                            // Agregar parámetros a $paramValues
                            $paramValues[] = array(
                                ':sy_eliminate' => 1,
                                ':sy_module' => $module,
                                ':tg_action' => $action,
                                ':tg_authorization' => 2,
                                ':tg_role' => $tgRole
                            );
                        }
                    }
                }
                $valuesFields = rtrim($valuesFields, ',');
                $column = "sy_eliminate, sy_module,";
                $column .= "tg_action, tg_authorization, tg_role";
                $insert = "INSERT INTO tg_permit ($column) VALUES $valuesFields";
                // Llamar a excBindVal en lugar de bindings
                $stmt = self::insertBindVal($insert, $paramValues);
                // Aquí puedes manejar el resultado según tus necesidades
                if ($stmt) { $mssg = true; } else { $mssg = false; }
            }
            return $mssg;
        }

        # Consultar columnas de una tabla con alias
        public static function syModule($data, $mssg = false) {
            $valuesFields = '';
            $paramValues = array();
            $syModule = InsertMysql::maxIdRegister($data);
            $tgAction = InsertMysql::rowIdRegister('tg_action');
            $tgRole = InsertMysql::rowIdRegister('tg_role');
            if ($syModule != 0 && !empty($syModule)) {
                if (count($tgAction) > 0 && count($tgRole) > 0) {
                    foreach ($tgRole as $role) {
                        foreach ($tgAction as $action) {
                            $valuesFields .= "(1, $syModule, $action, 2, $role),";
                            // Agregar parámetros a $paramValues
                            $paramValues[] = array(
                                ':sy_eliminate' => 1,
                                ':sy_module' => $syModule,
                                ':tg_action' => $action,
                                ':tg_authorization' => 2,
                                ':tg_role' => $role
                            );
                        }
                    }
                }
                $valuesFields = rtrim($valuesFields, ',');
                $column = "sy_eliminate, sy_module,";
                $column .= "tg_action, tg_authorization, tg_role";
                $insert = "INSERT INTO tg_permit ($column) VALUES $valuesFields";
                // Llamar a excBindVal en lugar de bindings
                $stmt = self::insertBindVal($insert, $paramValues);
                // Aquí puedes manejar el resultado según tus necesidades
                if ($stmt) { $mssg = true; } else { $mssg = false; }
            }
            return $mssg;
        }
    }
