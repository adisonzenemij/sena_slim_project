<?php
    namespace MyApp\Controllers\MySql;
    
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Views\Twig;

    use MyApp\Functions\ApiFunction as functionApi;
    use MyApp\Functions\JsonFunction as functionJson;
    use MyApp\Functions\RequestFunction as functionRequest;

    use MyApp\Models\JwtModel as modelJwt;
    use MyApp\Models\MySql\InsertModel as modelInsert;
    use MyApp\Models\MySql\ValidateModel as modelValidate;

    class InsertController {
        public function data(Request $request, Response $response, $arguments, $flag = false) {
            # Obtener los parametros de la url
            $queryParams = $request->getQueryParams();
            # Obtener headers de la solicitud
            $allHeaders = $request->getHeaders();
            # Obtener los datos enviados en la solicitud
            $postData = $request->getParsedBody();
            # Agregar $postData a $queryParams con la clave
            $queryParams['postData'] = $postData;

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
            if (!$flag) { $validateColumnn = modelValidate::column($queryParams); }
            # Decodificar datos del formato JSON y devolver booleano
            if (!$flag) { $apiJsonError = functionJson::jsonError($validateColumnn); }
            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && !$apiJsonError) { $resultJson = $validateColumnn; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$flag && !$apiJsonError) { $flag = true; }

            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && $apiJsonError) { $resultJson = modelInsert::data($queryParams); }

            # Convierte el arreglo en una cadena JSON
            $jsonData = functionRequest::jsonResult($request, $resultJson);
            # Establece el tipo de contenido en la respuesta
            $response = $response->withHeader('Content-Type', 'application/json');
            # Escribe los datos JSON en el cuerpo de la respuesta
            $response->getBody()->write($jsonData);
            # Devolver respuesta
            return $response;
        }
        
        public function symodule(Request $request, Response $response, $arguments, $flag = false) {
            # Obtener los parametros de la url
            $queryParams = $request->getQueryParams();
            # Obtener headers de la solicitud
            $allHeaders = $request->getHeaders();
            # Obtener los datos enviados en la solicitud
            $postData = $request->getParsedBody();
            # Agregar $postData a $queryParams con la clave
            $queryParams['postData'] = $postData;

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
            if (!$flag) { $validateColumnn = modelValidate::column($queryParams); }
            # Decodificar datos del formato JSON y devolver booleano
            if (!$flag) { $apiJsonError = functionJson::jsonError($validateColumnn); }
            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && !$apiJsonError) { $resultJson = $validateColumnn; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$flag && !$apiJsonError) { $flag = true; }

            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && $apiJsonError) { $resultJson = modelInsert::symodule($queryParams); }

            # Convierte el arreglo en una cadena JSON
            $jsonData = functionRequest::jsonResult($request, $resultJson);
            # Establece el tipo de contenido en la respuesta
            $response = $response->withHeader('Content-Type', 'application/json');
            # Escribe los datos JSON en el cuerpo de la respuesta
            $response->getBody()->write($jsonData);
            # Devolver respuesta
            return $response;
        }
        
        public function tgrole(Request $request, Response $response, $arguments, $flag = false) {
            # Obtener los parametros de la url
            $queryParams = $request->getQueryParams();
            # Obtener headers de la solicitud
            $allHeaders = $request->getHeaders();
            # Obtener los datos enviados en la solicitud
            $postData = $request->getParsedBody();
            # Agregar $postData a $queryParams con la clave
            $queryParams['postData'] = $postData;

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
            if (!$flag) { $validateColumnn = modelValidate::column($queryParams); }
            # Decodificar datos del formato JSON y devolver booleano
            if (!$flag) { $apiJsonError = functionJson::jsonError($validateColumnn); }
            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && !$apiJsonError) { $resultJson = $validateColumnn; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$flag && !$apiJsonError) { $flag = true; }

            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && $apiJsonError) { $resultJson = modelInsert::tgrole($queryParams); }

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
