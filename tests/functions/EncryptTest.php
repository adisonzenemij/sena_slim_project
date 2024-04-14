<?php
    declare(strict_types = 1);

    namespace MyApp\Tests\Functions;

    use PHPUnit\Framework\TestCase;
    
    use MyApp\Functions\EncryptFunction as functionEncrypt;

    class EncryptTest extends TestCase {
        /**
         * @covers MyApp\Functions\EncryptFunction::bcrypt
        */
        public function testBcrypt() : void {
            $password = 'password123';
            $hash = functionEncrypt::bcrypt($password);

            // Verificar que el hash no esté vacío
            $this->assertNotEmpty($hash);

            // Verificar que el hash sea válido
            $this->assertTrue(password_verify($password, $hash));
        }
    }
