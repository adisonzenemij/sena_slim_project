<?php
    namespace MyApp\Database\Motors\MySql;

    use MyApp\Database\Motors\MySql\ConnectMysql;
    use MyApp\Functions\EncryptFunction as functionEncrypt;
    use MyApp\Models\JwtModel as modelJwt;
    
    class UserMysql extends ConnectMysql {
        # Encriptar contraseña de forma segura
        private static function password($data) {
            # Obtener informacion de parametros
            $dtPostData = $data['postData'];
            # Verificar si está presente en la variable
            if (is_array($dtPostData) &&
                array_key_exists('os_password', $dtPostData)
            ) {
                # Obtener contraseña sin encriptar
                $plainPassword = $dtPostData['os_password'];
                return functionEncrypt::bcrypt($plainPassword);
            }
        }

        # Insertar registros en respectivas tablas
        public static function login($data) {
            # Devolver respuesta en formato array
            $message = array();
            # Obtener informacion de parametros
            $dtColumn = $data['column'];
            $dtPostData = $data['postData'];
            # Dividir la cadena en un array de columnas
            $columnArray = explode(',', $dtColumn);
            # Inicializar valores vacios
            $paramValues = array();
            # Iterar o recorrer elementos
            foreach ($columnArray as $columnName) {
                # Validar si existe la clave en el array
                if (array_key_exists($columnName, $dtPostData)) {
                    # Representa el nombre de un parámetro
                    $paramColumn = ":$columnName";
                    # Agregar elementos al array
                    $paramValues[$paramColumn] = $dtPostData[$columnName];
                }
            }
            # Asignar un valor a la variable basado en la clave 
            if (!$dtPostData['os_login']) { $osLogin = ''; }
            if ($dtPostData['os_login']) { $osLogin = $dtPostData['os_login']; }
            # Construccion de la cadena de consulta SQL
            $sql = "SELECT * FROM tg_user WHERE os_login = '$osLogin'";
            # Ejecutar consulta para retornar informacion
            $stmt = self::excBindVal($sql, $paramValues);
            if (!$stmt) {
                $noteInfo = 'Credenciales Incorrectas';
                $message[] = array('warning' => $noteInfo);
            }
            if ($stmt) {
                # Recuperar contraseña encriptada almacenada
                $storedPassword = $stmt[0]['os_password'];
                # Verificar contraseña proporcionada por el usuario
                if (password_verify($dtPostData['os_password'], $storedPassword)) {
                    $token = modelJwt::login($stmt);
                    return array($token);
                } else {
                    $noteInfo = 'Credenciales Incorrectas';
                    $message[] = array('warning' => $noteInfo);
                }
            }
            return $message;
        }

        # Insertar registros en respectivas tablas
        public static function register($data) {
            # Devolver respuesta en formato array
            $message = array();
            # Obtener informacion de parametros
            $dtColumn = $data['column'];
            $dtPostData = $data['postData'];
            # Encriptar contraseña de forma segura
            $hassPassword = UserMysql::password($data);
            $dtPostData['os_password'] = $hassPassword;
            # Dividir la cadena en un array de columnas
            $columnArray = explode(',', $dtColumn);
            # Array para almacenar valores
            $columnNames = array();
            $paramNames = array();
            $paramValues = array();
            # Iterar o recorrer elementos
            foreach ($columnArray as $columnName) {
                # Validar si existe la clave en el array
                if (array_key_exists($columnName, $dtPostData)) {
                    # Representa el nombre de un parámetro
                    $columnNames[] = $columnName;
                    $paramColumn = ":$columnName";
                    $paramNames[] = $paramColumn;
                    # Agregar elementos al array
                    $paramValues[$paramColumn] = $dtPostData[$columnName];
                }
            }
            # Construir parte de la sentencia SQL
            $columnsPart = implode(', ', $columnNames);
            $paramNamesPart = implode(', ', $paramNames);
            # Construir la sentencia completa con marcadores
            $sql = "INSERT INTO tg_user ($columnsPart) VALUES ($paramNamesPart)";
            # Ejecutar consulta para retornar informacion
            $stmt = self::bindings($sql, $paramValues);
            # Validar sentencia sql ejecutada
            if ($stmt) {
                $noteInfo = 'Registro almacenado correctamente.';
                $message[] = array('success' => $noteInfo);
            }
            # Validar sentencia sql ejecutada
            if (!$stmt) {
                $errorMessage = self::getErrorMessage();
                $noteInfo = 'Registro no procesado debidamente:';
                $noteInfo .= $errorMessage;
                $message[] = array('error' => $noteInfo);
            }
            return $message;
        }
    }
