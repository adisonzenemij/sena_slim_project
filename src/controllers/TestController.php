<?php
    namespace MyApp\Controllers;
    
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Views\Twig;

    class TestController {
        function index (Request $request, Response $response, $arguments) {

            $response->getBody()->write('Desarrollo API');
            return $response;
            
            $params = ['title' => 'API',];
            $view = Twig::fromRequest($request);
            return $view->render($response, 'app/index.html', $params);
        }
    }
?>
