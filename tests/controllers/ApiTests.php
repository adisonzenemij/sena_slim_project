<?php
    declare(strict_types = 1);

    namespace MyApp\Tests;

    use MyApp\Controllers\ApiController;
    use PHPUNIT\Framework\TestCase;

    class ApiTests extends TestCase {
        /**
         * @covers MyApp\Controllers\ApiController::index
        */
        public function testIndex() : void {
            
        }

        
        /**
         * @covers MyApp\Controllers\ApiController::param
        */
        public function testParam() : void {
            // Crea una instancia de la clase ApiController
            $controller = new ApiController();

            // Crea un objeto de prueba para Request y Response
            $request = $this->createMock(Request::class);
            $response = $this->createMock(Response::class);

            // Llama a la función param con los argumentos de prueba
            $result = $controller->param($request, $response, '');

            // Verifica que el resultado sea una instancia de ResponseInterface
            $this->assertInstanceOf(ResponseInterface::class, $result);

            // Verifica el contenido de la respuesta si es necesario
            // Por ejemplo, si esperas un cierto contenido JSON puedes hacer algo como:
            $expectedJson = '{"key":"value"}';
            $this->assertEquals($expectedJson, (string)$result->getBody());
        }
    }
