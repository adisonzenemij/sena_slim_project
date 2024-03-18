<?php
    namespace MyApp\Controllers;

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Views\Twig;

    use MyApp\Functions\ApiFunction as functionApi;
    use MyApp\Functions\JsonFunction as functionJson;
    use MyApp\Functions\RequestFunction as functionRequest;
    
    use MyApp\Models\JwtModel as modelJwt;

    class JwtController {
        public function index(Request $request, Response $response, $arguments) {
            # Parametros como argumentos en vistas
            $params = [
                'appUrl' => SERVER_URL_CURRENT,
                'appTitle' => 'API Slim',
                'appModelApi' => 'JWT',
            ];
            # Crear una instancia de Twig desde la solicitud
            $view = Twig::fromRequest($request);
            # Renderizar el archivo 'doctype.html'
            $htmlDotcype = $view->fetch('bootstrap/doctype.html', $params);
            # Renderizar el archivo 'navbar.html'
            $htmlNavbar = $view->fetch('bootstrap/navbar.html', $params);
            # Renderizar el archivo 'script.html'
            $htmlScript = $view->fetch('bootstrap/script.html');
            # Renderizar el archivo 'template.html'
            $htmlApi = $view->fetch('app/api.html', $params);
            # Combinar todas las partes en una respuesta HTML completa
            $htmlContent = $htmlDotcype . $htmlNavbar . $htmlApi . $htmlScript;
            # Escribir el contenido HTML en la respuesta
            $response->getBody()->write($htmlContent);
            # Devolver respuesta
            return $response;
        }
        
        public function token(Request $request, Response $response, $arguments) {
            # Obtener los parametros de la url
            $queryParams = $request->getQueryParams();
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
            $token = JWT::encode($payload, $_ENV['JWT_KEY'], $_ENV['JWT_ALG']);
            # Construir array de datos
            $resultApi = array('token' => $token);
            # Encodificar resultado de formato array
            $jsonEncode = json_encode($resultApi);
            # Convierte el arreglo en una cadena JSON
            $jsonData = functionRequest::jsonResult($request, $jsonEncode);
            # Establece el tipo de contenido en la respuesta
            $response = $response->withHeader('Content-Type', 'application/json');
            # Escribe los datos JSON en el cuerpo de la respuesta
            $response->getBody()->write($jsonData);
            # Devolver respuesta
            return $response;
        }
        
        public function verify(Request $request, Response $response, $arguments) {
            # Mensajes de Respuesta
            $mssgResp = array();
            # Obtener headers de la solicitud
            $allHeaders = $request->getHeaders();
            if (!isset($allHeaders['Authorization'])) {
                $mssgResp[] = array('error' => 'Autorizacion Invalida');
            }

            if (isset($allHeaders['Authorization'])) {
                # Obtener header especifico de la solicitud
                $authHeader = $request->getHeader('Authorization');
                # Verificar si $authHeader es un array y no está vacío
                if (is_array($authHeader) && !empty($authHeader)) {
                    $authArray = explode(' ', $authHeader[0]);
                    # Verificar si tiene al menos dos elementos
                    if (!isset($authArray[1])) {
                        $mssgResp[] = array(
                            'error' => 'Bearer Invalido'
                        );
                    }
                    # Verificar si tiene al menos dos elementos
                    if (isset($authArray[1])) {
                        # Obtener valor del array
                        $jwtToken = $authArray[1];
                        # Decodificar token
                        try {
                            $decoded = JWT::decode($jwtToken, new Key(
                                $_ENV['JWT_KEY'], $_ENV['JWT_ALG']
                            ));
                            $mssgResp[] = array('success' => $decoded->sub);
                        } catch (\Throwable $th) {
                            $mssgResp[] = array('error' => 'Token Invalido');
                        }
                    }
                } else {
                    # Manejar el caso en el que $authHeader no es un array o está vacío
                    $mssgResp[] = array('error' => 'Token Invalido');
                }
            }
            # Encodificar resultado de formato array
            $jsonEncode = json_encode($mssgResp);
            # Convierte el arreglo en una cadena JSON
            $jsonData = functionRequest::jsonResult($request, $jsonEncode);
            # Establece el tipo de contenido en la respuesta
            $response = $response->withHeader('Content-Type', 'application/json');
            # Escribe los datos JSON en el cuerpo de la respuesta
            $response->getBody()->write($jsonData);
            # Devolver respuesta
            return $response;
        }
        
        public function user(Request $request, Response $response, $arguments, $flag = false) {
            # Obtener los parametros de la url
            $queryParams = $request->getQueryParams();
            # Obtener headers de la solicitud
            $allHeaders = $request->getHeaders();

            # Obtener datos del modelo en formato JSON
            $jwtAuth = modelJwt::auth($allHeaders);
            # Decodificar datos del formato JSON y devolver booleano
            $apiJsonError = functionJson::jsonError($jwtAuth);
            # Validar y obtener datos del modelo en formato JSON
            if (!$apiJsonError) { $resultJson = $jwtAuth; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$apiJsonError) { $flag = true; }

            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && $apiJsonError) { $resultJson = modelJwt::user($allHeaders); }
            
            # Convierte el arreglo en una cadena JSON
            $jsonData = functionRequest::jsonResult($request, $resultJson);
            # Establece el tipo de contenido en la respuesta
            $response = $response->withHeader('Content-Type', 'application/json');
            # Escribe los datos JSON en el cuerpo de la respuesta
            $response->getBody()->write($jsonData);
            # Devolver respuesta
            return $response;
        }
    }
