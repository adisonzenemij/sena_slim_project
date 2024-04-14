<?php
    declare(strict_types = 1);

    namespace MyApp\Tests\Functions;

    use PHPUnit\Framework\TestCase;
    
    use MyApp\Functions\JsonFunction as functionJson;

    class JsonTest extends TestCase {
        /**
         * @covers MyApp\Functions\JsonFunction::jsonEncode
        */
        public function testJsonEncode() : void {
            // Preparar datos de prueba
            $data = [
                [
                    'name' => 'John Doe',
                    'age' => 30,
                    'city' => 'New York'
                ],
                [
                    'name' => 'Jane Smith',
                    'age' => 25,
                    'city' => 'Los Angeles'
                ]
            ];

            // Llamar a la función para codificar los datos
            $result = GeneralFunction::jsonEncode($data);

            // Verificar que el resultado no esté vacío y sea un JSON válido
            $this->assertNotEmpty($result);
            $this->assertJson($result);

            // Decodificar el JSON para verificar que los datos son correctos
            $decoded = json_decode($result, true);
            $this->assertEquals($data, $decoded);
        }
        
        /**
         * @covers MyApp\Functions\JsonFunction::jsonFormat
        */
        public function testJsonFormat() : void {
            // Preparar datos de prueba
            $data = [
                [
                    'name' => 'John Doe',
                    'age' => 30,
                    'city' => 'New York'
                ],
                [
                    'name' => 'Jane Smith',
                    'age' => 25,
                    'city' => 'Los Angeles'
                ]
            ];

            // Llamar a la función para formatear los datos
            $result = JsonFunction::jsonFormat($data);

            // Verificar que el resultado tenga el formato esperado
            $expectedResult = [
                [
                    'name' => 'John Doe',
                    'age' => 30,
                    'city' => 'New York'
                ],
                [
                    'name' => 'Jane Smith',
                    'age' => 25,
                    'city' => 'Los Angeles'
                ]
            ];
            $this->assertEquals($expectedResult, $result);
        }
        
        /**
         * @covers MyApp\Functions\JsonFunction::isArrayObject
        */
        public function testIsArrayObject() : void {
            // Caso de prueba con un arreglo
            $arrayData = [1, 2, 3];
            $this->assertTrue(JsonFunction::isArrayObject($arrayData));

            // Caso de prueba con un objeto
            $objectData = new stdClass();
            $this->assertTrue(JsonFunction::isArrayObject($objectData));

            // Caso de prueba con otro tipo de datos
            $stringData = 'hello';
            $this->assertFalse(JsonFunction::isArrayObject($stringData));
            $intData = 123;
            $this->assertFalse(JsonFunction::isArrayObject($intData));
            $boolData = true;
            $this->assertFalse(JsonFunction::isArrayObject($boolData));
            $nullData = null;
            $this->assertFalse(JsonFunction::isArrayObject($nullData));
        }
        
        /**
         * @covers MyApp\Functions\JsonFunction::isMultidimensional
        */
        public function testIsMultidimensional() : void {
            // Caso de prueba con un arreglo multidimensional
            $multidimensionalArray = [
                [1, 2, 3],
                [4, 5, 6],
                [7, 8, 9]
            ];
            $this->assertTrue(JsonFunction::isMultidimensional($multidimensionalArray));

            // Caso de prueba con un objeto que se comporta como un arreglo multidimensional
            $objectData = (object)[
                (object)[1, 2, 3],
                (object)[4, 5, 6],
                (object)[7, 8, 9]
            ];
            $this->assertTrue(JsonFunction::isMultidimensional($objectData));

            // Caso de prueba con un arreglo no multidimensional
            $nonMultidimensionalArray = [1, 2, 3];
            $this->assertFalse(JsonFunction::isMultidimensional($nonMultidimensionalArray));

            // Caso de prueba con un objeto que no se comporta como un arreglo multidimensional
            $nonMultidimensionalObject = (object)[1, 2, 3];
            $this->assertFalse(JsonFunction::isMultidimensional($nonMultidimensionalObject));
        }
        
        /**
         * @covers MyApp\Functions\JsonFunction::jsonError
        */
        public function testJsonError() : void {
            // Caso de prueba con un JSON válido que no contiene errores
            $validJson = json_encode([
                ['name' => 'John', 'age' => 30],
                ['name' => 'Jane', 'age' => 25]
            ]);
            $this->assertTrue(JsonFunction::jsonError($validJson));

            // Caso de prueba con un JSON válido que contiene un elemento con error
            $invalidJson = json_encode([
                ['name' => 'John', 'age' => 30],
                ['error' => 'Invalid data'],
                ['name' => 'Jane', 'age' => 25]
            ]);
            $this->assertFalse(JsonFunction::jsonError($invalidJson));

            // Caso de prueba con un JSON inválido
            $invalidJsonString = '{invalid json}';
            $this->assertFalse(JsonFunction::jsonError($invalidJsonString));

            // Caso de prueba con un JSON vacío
            $emptyJson = '';
            $this->assertFalse(JsonFunction::jsonError($emptyJson));
        }
        
        /**
         * @covers MyApp\Functions\JsonFunction::jsonWarning
        */
        public function testJsonWarning() : void {
            // Caso de prueba con un JSON válido que no contiene advertencias
            $validJson = json_encode([
                ['name' => 'John', 'age' => 30],
                ['name' => 'Jane', 'age' => 25]
            ]);
            $this->assertTrue(JsonFunction::jsonWarning($validJson));

            // Caso de prueba con un JSON válido que contiene un elemento con advertencia
            $jsonWithWarning = json_encode([
                ['name' => 'John', 'age' => 30],
                ['warning' => 'Potential issue'],
                ['name' => 'Jane', 'age' => 25]
            ]);
            $this->assertFalse(JsonFunction::jsonWarning($jsonWithWarning));

            // Caso de prueba con un JSON inválido
            $invalidJsonString = '{invalid json}';
            $this->assertFalse(JsonFunction::jsonWarning($invalidJsonString));

            // Caso de prueba con un JSON vacío
            $emptyJson = '';
            $this->assertFalse(JsonFunction::jsonWarning($emptyJson));
        }
    }
