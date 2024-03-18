<?php
    namespace MyApp\Controllers\MySql;
    
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Views\Twig;

    use MyApp\Functions\ApiFunction as functionApi;
    use MyApp\Functions\JsonFunction as functionJson;
    use MyApp\Functions\RequestFunction as functionRequest;

    use MyApp\Models\JwtModel as modelJwt;
    use MyApp\Models\MySql\UnionModel as modelUnion;
    use MyApp\Models\MySql\ValidateModel as modelValidate;

    class UnionController {
        function index(Request $request, Response $response, $arguments) {
            // Convierte el arreglo en una cadena JSON
            $jsonData = functionRequest::jsonEncode($request);
            # Establece el tipo de contenido en la respuesta
            $response = $response->withHeader('Content-Type', 'application/json');
            # Escribir el contenido HTML en la respuesta
            $response->getBody()->write($jsonData);
            # Devolver respuesta
            return $response;
        }
        
        public function label(Request $request, Response $response, $arguments, $flag = false) {
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

            # Obtener datos del modelo en formato JSON
            if (!$flag) { $validateTable = modelValidate::table($queryParams); }
            # Decodificar datos del formato JSON y devolver booleano
            if (!$flag) { $apiJsonError = functionJson::jsonError($validateTable); }
            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && !$apiJsonError) { $resultJson = $validateTable; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$flag && !$apiJsonError) { $flag = true; }

            # Obtener datos del modelo en formato JSON
            if (!$flag) { $validateColumn = modelValidate::column($queryParams); }
            # Decodificar datos del formato JSON y devolver booleano
            if (!$flag) { $apiJsonError = functionJson::jsonError($validateColumn); }
            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && !$apiJsonError) { $resultJson = $validateColumn; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$flag && !$apiJsonError) { $flag = true; }

            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && $apiJsonError) { $resultJson = modelUnion::label($queryParams); }

            # Convierte el arreglo en una cadena JSON
            $jsonData = functionRequest::jsonResult($request, $resultJson);
            # Establece el tipo de contenido en la respuesta
            $response = $response->withHeader('Content-Type', 'application/json');
            # Escribe los datos JSON en el cuerpo de la respuesta
            $response->getBody()->write($jsonData);
            # Devolver respuesta
            return $response;
        }
        
        public function alias(Request $request, Response $response, $arguments, $flag = false) {
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

            # Obtener datos del modelo en formato JSON
            if (!$flag) { $validateTable = modelValidate::table($queryParams); }
            # Decodificar datos del formato JSON y devolver booleano
            if (!$flag) { $apiJsonError = functionJson::jsonError($validateTable); }
            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && !$apiJsonError) { $resultJson = $validateTable; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$flag && !$apiJsonError) { $flag = true; }

            # Obtener datos del modelo en formato JSON
            /*$validateTable = modelValidate::table($queryParams);
            # Decodificar datos del formato JSON y devolver booleano
            $apiJsonError = functionJson::jsonError($validateTable);
            # Validar y obtener datos del modelo en formato JSON
            if (!$apiJsonError) { $resultJson = $validateTable; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$apiJsonError) { $flag = true; }*/

            # Obtener datos del modelo en formato JSON
            if (!$flag) { $validateColumn = modelValidate::column($queryParams); }
            # Decodificar datos del formato JSON y devolver booleano
            if (!$flag) { $apiJsonError = functionJson::jsonError($validateColumn); }
            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && !$apiJsonError) { $resultJson = $validateColumn; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$flag && !$apiJsonError) { $flag = true; }

            # Obtener datos del modelo en formato JSON
            if (!$flag) { $validateWhereCount = modelValidate::whereCount($queryParams); }
            # Decodificar datos del formato JSON y devolver booleano
            if (!$flag) { $apiJsonError = functionJson::jsonError($validateWhereCount); }
            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && !$apiJsonError) { $resultJson = $validateWhereCount; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$flag && !$apiJsonError) { $flag = true; }

            # Obtener datos del modelo en formato JSON
            if (!$flag) { $validateWhereField = modelValidate::whereField($queryParams); }
            # Decodificar datos del formato JSON y devolver booleano
            if (!$flag) { $apiJsonError = functionJson::jsonError($validateWhereField); }
            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && !$apiJsonError) { $resultJson = $validateWhereField; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$flag && !$apiJsonError) { $flag = true; }

            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && $apiJsonError) { $resultJson = modelUnion::alias($queryParams); }
            
            # Convierte el arreglo en una cadena JSON
            $jsonData = functionRequest::jsonResult($request, $resultJson);
            # Establece el tipo de contenido en la respuesta
            $response = $response->withHeader('Content-Type', 'application/json');
            # Escribe los datos JSON en el cuerpo de la respuesta
            $response->getBody()->write($jsonData);
            # Devolver respuesta
            return $response;
        }
        
        public function module(Request $request, Response $response, $arguments, $flag = false) {
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

            # Obtener datos del modelo en formato JSON
            if (!$flag) { $validateWhereCount = modelValidate::whereCount($queryParams); }
            # Decodificar datos del formato JSON y devolver booleano
            if (!$flag) { $apiJsonError = functionJson::jsonError($validateWhereCount); }
            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && !$apiJsonError) { $resultJson = $validateWhereCount; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$flag && !$apiJsonError) { $flag = true; }

            # Obtener datos del modelo en formato JSON
            if (!$flag) { $validateWhereField = modelValidate::whereField($queryParams); }
            # Decodificar datos del formato JSON y devolver booleano
            if (!$flag) { $apiJsonError = functionJson::jsonError($validateWhereField); }
            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && !$apiJsonError) { $resultJson = $validateWhereField; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$flag && !$apiJsonError) { $flag = true; }

            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && $apiJsonError) { $resultJson = modelUnion::module($queryParams); }
            
            # Convierte el arreglo en una cadena JSON
            $jsonData = functionRequest::jsonResult($request, $resultJson);
            # Establece el tipo de contenido en la respuesta
            $response = $response->withHeader('Content-Type', 'application/json');
            # Escribe los datos JSON en el cuerpo de la respuesta
            $response->getBody()->write($jsonData);
            # Devolver respuesta
            return $response;
        }
        
        public function menu(Request $request, Response $response, $arguments, $flag = false) {
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

            # Obtener datos del modelo en formato JSON
            if (!$flag) { $validateWhereCount = modelValidate::whereCount($queryParams); }
            # Decodificar datos del formato JSON y devolver booleano
            if (!$flag) { $apiJsonError = functionJson::jsonError($validateWhereCount); }
            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && !$apiJsonError) { $resultJson = $validateWhereCount; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$flag && !$apiJsonError) { $flag = true; }

            # Obtener datos del modelo en formato JSON
            if (!$flag) { $validateWhereField = modelValidate::whereField($queryParams); }
            # Decodificar datos del formato JSON y devolver booleano
            if (!$flag) { $apiJsonError = functionJson::jsonError($validateWhereField); }
            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && !$apiJsonError) { $resultJson = $validateWhereField; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$flag && !$apiJsonError) { $flag = true; }

            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && $apiJsonError) { $resultJson = modelUnion::menu($queryParams); }
            
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
