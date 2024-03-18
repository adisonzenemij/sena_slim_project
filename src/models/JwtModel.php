<?php
    namespace MyApp\Models;

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    use MyApp\Functions\ApiFunction as functionApi;
    use MyApp\Functions\JsonFunction as functionJson;

    use MyApp\Database\Motors\MySql\InfoMysql as mysqlInfo;
    use MyApp\Database\Motors\MySql\ValidationMysql as mysqlValidation;
    
    class JwtModel {
        public static function token($data) {
            # Obtener marca de tiempo actual
            $nowTime = strtotime('now');
            # Construir token de JWT
            $payload = array(
                'iss' => SERVER_URL_CURRENT,
                'aud' => $_ENV['JWT_AUD'],
                'iat' => $nowTime,
                'nbf' => $nowTime,
                'exp' => $nowTime + $_ENV['JWT_EXP'],
                'sub' => '1',
                'jti' => base64_encode(random_bytes(16)),
            );
            # Generar token firmado con la libreria
            $token = JWT::encode($payload, $_ENV['JWT_KEY'], $_ENV['JWT_ALG']);
            # Construir array de datos
            $result = array('token' => $token);
            return functionJson::jsonEncode($result);
        }

        public static function login($data) {
            $sub = array();
            if (!empty($data) && is_array($data)) {
                $sub[] = array(
                    'id_register' => $data[0]['id_register'],
                    'tg_role' => $data[0]['tg_role']
                );
            }
            # Obtener marca de tiempo actual
            $nowTime = strtotime('now');
            # Construir token de JWT
            $payload = array(
                'iss' => SERVER_URL_CURRENT,
                'aud' => $_ENV['JWT_AUD'],
                'iat' => $nowTime,
                'nbf' => $nowTime,
                'exp' => $nowTime + $_ENV['JWT_EXP'],
                'sub' => $sub,
                'jti' => base64_encode(random_bytes(16)),
            );
            # Generar token firmado con la libreria
            $token = JWT::encode($payload, $_ENV['JWT_KEY'], $_ENV['JWT_ALG']);
            # Construir array de datos
            return array('token' => $token);
        }

        public static function auth($data) {
            # Mensajes de Respuesta
            $message = array();
            if (!isset($data['Authorization'])) {
                $noteInfo = 'Autorizacion Invalida';
                $message[] = array('error' => $noteInfo);
            }
            # Validar si existe la autorizacion
            if (isset($data['Authorization'])) {
                # Obtener header especifico de la solicitud
                $authHeader = $data['Authorization'];
                if (!is_array($authHeader) && empty($authHeader)) {
                    $noteInfo = 'Token Invalido';
                    $message[] = array('error' => 'Token Invalido');
                }
                # Verificar si $authHeader es un array y no está vacío
                if (is_array($authHeader) && !empty($authHeader)) {
                    $authArray = explode(' ', $authHeader[0]);
                    # Verificar si tiene al menos dos elementos
                    if (!isset($authArray[1])) {
                        $noteInfo = 'Bearer Invalido';
                        $message[] = array('error' => $noteInfo);
                    }
                    # Verificar si tiene al menos dos elementos
                    if (isset($authArray[1])) {
                        try {
                            # Obtener valor del array
                            $jwtToken = $authArray[1];
                            # Decodificar token recibido
                            JWT::decode($jwtToken, new Key(
                                $_ENV['JWT_KEY'], $_ENV['JWT_ALG']
                            ));
                        } catch (\Firebase\JWT\ExpiredException $th) {
                            $noteInfo = 'Token Expirado';
                            $message[] = array('error' => $noteInfo);
                        } catch (\Firebase\JWT\BeforeValidException $th) {
                            // Token aún no es válido
                            $noteInfo = 'Token Invalido';
                            $message[] = array('error' => $noteInfo);
                        } catch (\Firebase\JWT\SignatureInvalidException $th) {
                            // Firma inválida
                            $noteInfo = 'Firma Invalida';
                            $message[] = array('error' => $noteInfo);
                        } catch (\Firebase\JWT\InvalidTokenException $th) {
                            // Token inválido en general
                            $noteInfo = 'Token Invalido';
                            $message[] = array('error' => $noteInfo);
                        } catch (\Exception $th) {
                            // Otras excepciones
                            $noteInfo = 'Token Decodificado Incorrectamente';
                            $message[] = array('error' => $noteInfo);
                        }
                    }
                }
            }
            # Encodificar resultado de formato array
            return functionJson::jsonEncode($message);
        }

        public static function user($data) {
            # Mensajes de Respuesta
            $message = array();
            # Validar si existe la autorizacion
            if (isset($data['Authorization'])) {
                # Obtener header especifico de la solicitud
                $authHeader = $data['Authorization'];
                # Verificar si $authHeader es un array y no está vacío
                if (is_array($authHeader) && !empty($authHeader)) {
                    $authArray = explode(' ', $authHeader[0]);
                    # Verificar si tiene al menos dos elementos
                    if (isset($authArray[1])) {
                        # Decodificar token
                        try {
                            # Obtener valor del array
                            $jwtToken = $authArray[1];
                            # Decodificar token recibido
                            $decoded = JWT::decode($jwtToken, new Key(
                                $_ENV['JWT_KEY'], $_ENV['JWT_ALG']
                            ));
                            $noteInfo = $decoded->sub;
                            $message = $noteInfo;
                        } catch (\Firebase\JWT\ExpiredException $th) {
                            $noteInfo = 'Token Expirado';
                            $message[] = array('error' => $noteInfo);
                        } catch (\Firebase\JWT\BeforeValidException $th) {
                            // Token aún no es válido
                            $noteInfo = 'Token Invalido';
                            $message[] = array('error' => $noteInfo);
                        } catch (\Firebase\JWT\SignatureInvalidException $th) {
                            // Firma inválida
                            $noteInfo = 'Firma Invalida';
                            $message[] = array('error' => $noteInfo);
                        } catch (\Firebase\JWT\InvalidTokenException $th) {
                            // Token inválido en general
                            $noteInfo = 'Token Invalido';
                            $message[] = array('error' => $noteInfo);
                        } catch (\Exception $th) {
                            // Otras excepciones
                            $noteInfo = 'Token Decodificado Incorrectamente';
                            $message[] = array('error' => $noteInfo);
                        }
                    }
                }
            }
            # Encodificar resultado de formato array
            return functionJson::jsonEncode($message);
        }
    }
