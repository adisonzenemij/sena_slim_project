<?php
    declare(strict_types = 1);

    namespace MyApp\Tests\Controllers;

    use PHPUnit\Framework\TestCase;
    
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\UriInterface;
    use Psr\Http\Message\StreamInterface;

    use Slim\Psr7\Factory\ServerRequestFactory;
    use Slim\Psr7\Factory\ResponseFactory;

    use MyApp\Controllers\ApiController as controllerApi;

    class ApiTest extends TestCase {
        /**
         * @covers MyApp\Controllers\ApiController::param
        */
        public function testParam() : void {
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
            $result = controllerApi::param($request, $response, '');

            // Verifica que la respuesta tenga el encabezado 'Content-Type' esperado
            $this->assertEquals('application/json', $result->getHeaderLine('Content-Type'));

            // Define el arreglo asociativo con los datos esperados
            $expectedData = [
                "data" => [
                    "token" => "",
                    "table" => "",
                    "column" => "*",
                    "whereCond" => "",
                    "whereField" => "",
                    "whereOperator" => "",
                    "whereEqual" => "",
                    "orderBy" => "",
                    "orderMode" => "",
                    "limitStart" => "",
                    "limitFinal" => "",
                    "postData" => "",
                    "putData" => "",
                    "deleteData" => "",
                    "dataType" => "",
                    "htmlSelect" => "",
                    "htmlMulti" => "",
                    "multiValue" => ""
                ],
                "headers" => [
                    "Host" => [""]
                ],
                "method" => "GET",
                "query_params" => [],
                "request_body" => "",
                "uri" => "/api/param"
            ];

            // Convertir el arreglo asociativo a una cadena JSON
            $expectedDataJson = json_encode($expectedData, JSON_PRETTY_PRINT);

            // Realizar la comparación
            $this->assertEquals($expectedDataJson, (string)$result->getBody());
        }
    }
