<?php
    declare(strict_types = 1);

    namespace MyApp\Tests\Functions;

    use PHPUnit\Framework\TestCase;
    
    use MyApp\Functions\GeneralFunction as functionGeneral;

    class GeneralTest extends TestCase {
        /**
         * @covers MyApp\Functions\GeneralFunction::customExplode
        */
        public function testCustomExplode() : void {
            $input = 'apple,orange,(banana,kiwi),grape';
            $expected = ['apple', 'orange', 'banana', 'kiwi', 'grape'];
            $result = functionGeneral::customExplode($input);
        
            // Verificar que el resultado coincide con el esperado
            $this->assertEquals($expected, $result);
        }
    }
