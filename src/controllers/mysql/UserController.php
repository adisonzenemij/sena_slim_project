<?php
    namespace MyApp\Controllers\MySql;
    
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Views\Twig;

    use MyApp\Functions\ApiFunction as functionApi;
    use MyApp\Functions\JsonFunction as functionJson;
    use MyApp\Functions\RequestFunction as functionRequest;

    use MyApp\Models\MySql\UserModel as modelUser;
    use MyApp\Models\MySql\ValidateModel as modelValidate;

    class UserController {
        public function login(Request $request, Response $response, $arguments, $flag = false) {
            # Obtener parametros recibidos de la solicitud
            $queryParams = $request->getQueryParams();
            # Obtener body recibido de la solicitud
            $postData = $request->getParsedBody();
            # Obtener informacion de parametros
            $queryParams['postData'] = $postData;

            # Obtener datos del modelo en formato JSON
            $validateTable = modelValidate::table($queryParams);
            # Decodificar datos del formato JSON y devolver booleano
            $apiJsonError = functionJson::jsonError($validateTable);
            # Validar y obtener datos del modelo en formato JSON
            if (!$apiJsonError) { $resultJson = $validateTable; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$apiJsonError) { $flag = true; }

            # Obtener datos del modelo en formato JSON
            if (!$flag) { $validateColumn = modelValidate::column($queryParams); }
            # Decodificar datos del formato JSON y devolver booleano
            if (!$flag) { $apiJsonError = functionJson::jsonError($validateColumn); }
            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && !$apiJsonError) { $resultJson = $validateColumn; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$flag && !$apiJsonError) { $flag = true; }

            # Obtener datos del modelo en formato JSON
            if (!$flag) { $validateBody = modelValidate::body($queryParams); }
            # Decodificar datos del formato JSON y devolver booleano
            if (!$flag) { $apiJsonError = functionJson::jsonError($validateBody); }
            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && !$apiJsonError) { $resultJson = $validateBody; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$flag && !$apiJsonError) { $flag = true; }

            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && $apiJsonError) { $resultJson = modelUser::login($queryParams); }

            # Convierte el arreglo en una cadena JSON
            $jsonData = functionRequest::jsonResult($request, $resultJson);
            # Establece el tipo de contenido en la respuesta
            $response = $response->withHeader('Content-Type', 'application/json');
            # Escribe los datos JSON en el cuerpo de la respuesta
            $response->getBody()->write($jsonData);
            # Devolver respuesta
            return $response;
        }
        
        public function register(Request $request, Response $response, $arguments, $flag = false) {
            # Obtener parametros recibidos de la solicitud
            $queryParams = $request->getQueryParams();
            # Obtener body recibido de la solicitud
            $postData = $request->getParsedBody();
            # Obtener informacion de parametros
            $queryParams['postData'] = $postData;

            # Obtener datos del modelo en formato JSON
            $validateTable = modelValidate::table($queryParams);
            # Decodificar datos del formato JSON y devolver booleano
            $apiJsonError = functionJson::jsonError($validateTable);
            # Validar y obtener datos del modelo en formato JSON
            if (!$apiJsonError) { $resultJson = $validateTable; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$apiJsonError) { $flag = true; }

            # Obtener datos del modelo en formato JSON
            if (!$flag) { $validateColumn = modelValidate::column($queryParams); }
            # Decodificar datos del formato JSON y devolver booleano
            if (!$flag) { $apiJsonError = functionJson::jsonError($validateColumn); }
            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && !$apiJsonError) { $resultJson = $validateColumn; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$flag && !$apiJsonError) { $flag = true; }

            # Obtener datos del modelo en formato JSON
            if (!$flag) { $validateBody = modelValidate::body($queryParams); }
            # Decodificar datos del formato JSON y devolver booleano
            if (!$flag) { $apiJsonError = functionJson::jsonError($validateBody); }
            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && !$apiJsonError) { $resultJson = $validateBody; }
            # Añadir un error de bandera si no se cumple la validacion anterior
            if (!$flag && !$apiJsonError) { $flag = true; }

            # Validar y obtener datos del modelo en formato JSON
            if (!$flag && $apiJsonError) { $resultJson = modelUser::register($queryParams); }

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
