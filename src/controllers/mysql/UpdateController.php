<?php
    namespace MyApp\Controllers\MySql;
    
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Views\Twig;

    use MyApp\Functions\ApiFunction as functionApi;
    use MyApp\Functions\JsonFunction as functionJson;
    use MyApp\Functions\RequestFunction as functionRequest;

    use MyApp\Models\JwtModel as modelJwt;
    use MyApp\Models\MySql\UpdateModel as modelUpdate;
    use MyApp\Models\MySql\ValidateModel as modelValidate;

    class UpdateController {
        public function data(Request $request, Response $response, $arguments, $flag = false) {
            # Obtener los parametros de la url
            $queryParams = $request->getQueryParams();
            # Obtener headers de la solicitud
            $allHeaders = $request->getHeaders();
            // Obtener los datos enviados en la solicitud
            $putData = $request->getParsedBody();
            # Agregar $putData a $queryParams con la clave
            $queryParams['putData'] = $putData;

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
            if (!$flag && $apiJsonError) { $resultJson = modelUpdate::data($queryParams); }
            
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
