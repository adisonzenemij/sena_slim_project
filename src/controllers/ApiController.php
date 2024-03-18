<?php
    namespace MyApp\Controllers;
    
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Views\Twig;

    use MyApp\Functions\ApiFunction as functionApi;
    use MyApp\Functions\JsonFunction as functionJson;
    use MyApp\Functions\RequestFunction as functionRequest;

    class ApiController {
        public function index(Request $request, Response $response, $arguments) {
            # Parametros como argumentos en vistas
            $params = [
                'appUrl' => SERVER_URL_CURRENT,
                'appTitle' => 'API Slim',
                'appModelApi' => 'API',
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
        
        public function param(Request $request, Response $response, $arguments) {
            # Obtener los parametros de la url
            $queryParams = $request->getQueryParams();
            # Retornar parametros de peticiones
            $resultApi = functionApi::queryParams($queryParams);
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
    }
