<?php
    declare(strict_types = 1);

    namespace MyApp\Tests\Controllers\MySql;

    use PHPUnit\Framework\TestCase;
    
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\UriInterface;
    use Psr\Http\Message\StreamInterface;

    use Slim\Psr7\Factory\ServerRequestFactory;
    use Slim\Psr7\Factory\ResponseFactory;
    
    use MyApp\Controllers\MySql\UserController as controllerUser;

    class UserControllerTest extends TestCase {
        /**
         * @covers MyApp\Controllers\MySql\UserController::login
        */
        public function testLogin() : void {
            // Crea una solicitud falsa con algunos parámetros de consulta
            $requestFactory = new ServerRequestFactory();
            $request = $requestFactory->createServerRequest(
                'POST',
                '/mysql/user/login',
                []
            );

            // Crea una respuesta falsa
            $responseFactory = new ResponseFactory();
            $response = $responseFactory->createResponse();

            // Llama al método con la solicitud y la respuesta falsas
            $result = controllerUser::login($request, $response, '');

            // Verifica que la respuesta tenga el encabezado 'Content-Type' esperado
            $this->assertEquals('application/json', $result->getHeaderLine('Content-Type'));

            // Define el arreglo asociativo con los datos esperados
            $expectedData = [
                "data" => [
                    [
                        "error" => "Tabla () Inexistente"
                    ]
                ],
                "headers" => [
                    "Host" => [""]
                ],
                "method" => "POST",
                "query_params" => [],
                "request_body" => "",
                "uri" => "/mysql/user/login"
            ];

            // Convertir el arreglo asociativo a una cadena JSON
            $expectedDataJson = json_encode($expectedData, JSON_PRETTY_PRINT);

            // Realizar la comparación
            $this->assertEquals($expectedDataJson, (string)$result->getBody());
        }
    }
