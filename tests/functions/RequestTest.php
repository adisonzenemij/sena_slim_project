<?php
    declare(strict_types = 1);

    namespace MyApp\Tests\Functions;

    use PHPUnit\Framework\TestCase;
    
    use MyApp\Functions\RequestFunction as functionRequest;

    class RequestTest extends TestCase {
        /**
         * @covers MyApp\Functions\RequestFunction::jsonEncode
        */
        public function testJsonEncode() : void {
            // Crear un objeto Response simulado
            $response = new Response();
            $response = $response
                ->withAddedHeader('Content-Type', 'application/json')
                ->withMethod('POST')
                ->withQueryParams(['param1' => 'value1', 'param2' => 'value2'])
                ->withBody(stream_for('{"key": "value"}'))
                ->withUri(new Uri('https://example.com/api'));

            // Llamar a la función jsonEncode y obtener el resultado
            $result = JsonFunction::jsonEncode($response);

            // Decodificar el resultado para verificar si es un JSON válido
            $decoded = json_decode($result);

            // Verificar que la decodificación fue exitosa y que contiene los datos esperados
            $this->assertNotNull($decoded);
            $this->assertEquals($decoded->headers->{'Content-Type'}, 'application/json');
            $this->assertEquals($decoded->method, 'POST');
            $this->assertEquals($decoded->query_params, ['param1' => 'value1', 'param2' => 'value2']);
            $this->assertEquals($decoded->request_body, '{"key": "value"}');
            $this->assertEquals($decoded->uri, '/api');
        }

        /**
         * @covers MyApp\Functions\RequestFunction::jsonResult
        */
        public function testJsonResult() : void {
            // Crear un objeto Response simulado
            $response = new Response();
            $response = $response
                ->withAddedHeader('Content-Type', 'application/json')
                ->withMethod('POST')
                ->withQueryParams(['param1' => 'value1', 'param2' => 'value2'])
                ->withBody(stream_for('{"key": "value"}'))
                ->withUri(new Uri('https://example.com/api'));

            // Crear datos JSON simulados
            $data = '{"result": "success"}';

            // Llamar a la función jsonResult y obtener el resultado
            $result = JsonFunction::jsonResult($response, $data);

            // Decodificar el resultado para verificar si es un JSON válido
            $decoded = json_decode($result);

            // Verificar que la decodificación fue exitosa y que contiene los datos esperados
            $this->assertNotNull($decoded);
            $this->assertEquals($decoded->data, json_decode($data));
            $this->assertEquals($decoded->headers->{'Content-Type'}, 'application/json');
            $this->assertEquals($decoded->method, 'POST');
            $this->assertEquals($decoded->query_params, ['param1' => 'value1', 'param2' => 'value2']);
            $this->assertEquals($decoded->request_body, '{"key": "value"}');
            $this->assertEquals($decoded->uri, '/api');
        }
    }
