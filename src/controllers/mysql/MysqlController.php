<?php
    namespace MyApp\Controllers\MySql;
    
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Views\Twig;

    use MyApp\Functions\RequestFunction as functionRequest;

    use MyApp\Models\MySql\ValidateModel as modelValidate;

    class MysqlController {
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
        
        function list(Request $request, Response $response, $arguments) {
            # Validar y obtener datos del modelo en formato JSON
            $modelValidateList = modelValidate::list();
            // Convierte el arreglo en una cadena JSON
            $jsonData = functionRequest::jsonResult($request, $modelValidateList);
            # Establece el tipo de contenido en la respuesta
            $response = $response->withHeader('Content-Type', 'application/json');
            # Escribe los datos JSON en el cuerpo de la respuesta
            $response->getBody()->write($jsonData);
            # Devolver respuesta
            return $response;
        }
    }
