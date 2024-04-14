<?php
    declare(strict_types = 1);

    namespace MyApp\Tests\Controllers;

    use PHPUnit\Framework\TestCase;
    
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\UriInterface;
    use Psr\Http\Message\StreamInterface;

    use MyApp\Controllers\ApiController as controllerApi;

    class ApiTest extends TestCase {
        /**
         * @covers MyApp\Controllers\ApiController::param
        */
        public function testParam() : void {
            // Crea un objeto de la clase ApiController
            $controller = new ApiController();

            // Crea una solicitud falsa con algunos parámetros de consulta
            $requestFactory = new ServerRequestFactory();
            $request = $requestFactory->createServerRequest(
                'GET',
                '/api/param',
                ['param1' => 'value1', 'param2' => 'value2']
            );

            // Crea una respuesta falsa
            $responseFactory = new ResponseFactory();
            $response = $responseFactory->createResponse();

            // Llama al método param de ApiController con la solicitud y la respuesta falsas
            $result = $controller->param($request, $response, '');

            // Verifica que la respuesta tenga el encabezado 'Content-Type' esperado
            $this->assertEquals('application/json', $result->getHeaderLine('Content-Type'));

            // Verifica que el cuerpo de la respuesta contenga los datos esperados
            $expectedData = '{"param1":"value1","param2":"value2"}'; // Esto es un ejemplo, ajusta según tu lógica de la función
            $this->assertEquals($expectedData, (string)$result->getBody());
        }
    }
