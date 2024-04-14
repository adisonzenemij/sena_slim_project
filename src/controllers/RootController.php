<?php
    namespace MyApp\Controllers;
    
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Views\Twig;

    class RootController {
        public function index(Request $request, Response $response, $arguments) {
            # Parametros como argumentos en vistas
            $params = [
                'appUrl' => SERVER_URL_CURRENT,
                'appTitle' => 'API Slim',
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
            $htmlApi = $view->fetch('app/root.html', $params);
            # Combinar todas las partes en una respuesta HTML completa
            $htmlContent = $htmlDotcype . $htmlNavbar . $htmlApi . $htmlScript;
            # Escribir el contenido HTML en la respuesta
            $response->getBody()->write($htmlContent);
            # Devolver respuesta
            return $response;
        }
    }
