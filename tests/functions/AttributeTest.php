<?php
    declare(strict_types = 1);

    namespace MyApp\Tests\Functions;

    use PHPUnit\Framework\TestCase;
    
    use MyApp\Functions\AttributeFunction as functionAttribute;

    class AttributeTest extends TestCase {
        
        /**
         * @covers MyApp\Functions\AttributeFunction::isEmpty
        */
        public function testIsEmpty() : void {
            $this->assertTrue(functionAttribute::isEmpty(''));
            $this->assertFalse(functionAttribute::isEmpty('abc'));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::valAlphabetic
        */
        public function testValAlphabetic() : void {
            $this->assertTrue(functionAttribute::valAlphabetic('abc'));
            $this->assertFalse(functionAttribute::valAlphabetic('abc123'));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::valAlphabeticSpaces
        */
        public function testValAlphabeticSpaces() : void {
            $this->assertTrue(functionAttribute::valAlphabeticSpaces('abc'));
            $this->assertTrue(functionAttribute::valAlphabeticSpaces('abc def'));
            $this->assertFalse(functionAttribute::valAlphabeticSpaces('abc123'));
            $this->assertFalse(functionAttribute::valAlphabeticSpaces('abc!'));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::isLowerCase
        */
        public function testIsLowerCase() : void {
            $this->assertTrue(functionAttribute::isLowerCase('abc'));
            $this->assertFalse(functionAttribute::isLowerCase('Abc'));
            $this->assertFalse(functionAttribute::isLowerCase('123'));
            $this->assertFalse(functionAttribute::isLowerCase('abc123'));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::isUpperCase
        */
        public function testIsUpperCase() : void {
            $this->assertTrue(functionAttribute::isUpperCase('ABC'));
            $this->assertFalse(functionAttribute::isUpperCase('AbC'));
            $this->assertFalse(functionAttribute::isUpperCase('123'));
            $this->assertFalse(functionAttribute::isUpperCase('ABC123'));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::isAlpha
        */
        public function testIsAlpha() : void {
            $this->assertTrue(functionAttribute::isAlpha('ABC'));
            $this->assertTrue(functionAttribute::isAlpha('abc'));
            $this->assertFalse(functionAttribute::isAlpha('123'));
            $this->assertFalse(functionAttribute::isAlpha('ABC123'));
            $this->assertFalse(functionAttribute::isAlpha('AbC'));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::isLowerCaseAccent
        */
        public function testIsLowerCaseAccent() : void {
            $this->assertTrue(functionAttribute::isLowerCaseAccent('abcdefghijklmnñopqrstuvwxyzáéíóúü'));
            $this->assertFalse(functionAttribute::isLowerCaseAccent('ABCDEFGHIJKLMNOPQRSTUVWXYZ'));
            $this->assertFalse(functionAttribute::isLowerCaseAccent('1234567890'));
            $this->assertFalse(functionAttribute::isLowerCaseAccent('!@#$%^&*()_+-=[]{}|;:,.<>?'));
            $this->assertFalse(functionAttribute::isLowerCaseAccent('AbC'));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::isUpperCaseAccent
        */
        public function testIsUpperCaseAccent() : void {
            $this->assertTrue(functionAttribute::isUpperCaseAccent('ABCDEFGHIJKLMNOPQRSTUVWXYZÁÉÍÓÚÜÑ'));
            $this->assertFalse(functionAttribute::isUpperCaseAccent('abcdefghijklmnopqrstuvwxyz'));
            $this->assertFalse(functionAttribute::isUpperCaseAccent('1234567890'));
            $this->assertFalse(functionAttribute::isUpperCaseAccent('!@#$%^&*()_+-=[]{}|;:,.<>?'));
            $this->assertFalse(functionAttribute::isUpperCaseAccent('AbC'));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::isAlphaAccent
        */
        public function testIsAlphaAccent() : void {
            $this->assertTrue(functionAttribute::isAlphaAccent('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyzÁÉÍÓÚÜÑáéíóúüñ'));
            $this->assertFalse(functionAttribute::isAlphaAccent('1234567890'));
            $this->assertFalse(functionAttribute::isAlphaAccent('!@#$%^&*()_+-=[]{}|;:,.<>?'));
            $this->assertFalse(functionAttribute::isAlphaAccent('AbC1'));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::isLowerCaseAccentSpaces
        */
        public function testIsLowerCaseAccentSpaces() : void {
            $this->assertTrue(functionAttribute::isLowerCaseAccentSpaces('aáeéiíoóuúüñ '));
            $this->assertFalse(functionAttribute::isLowerCaseAccentSpaces('ABCDEFGHIJKLMNOPQRSTUVWXYZ'));
            $this->assertFalse(functionAttribute::isLowerCaseAccentSpaces('1234567890'));
            $this->assertFalse(functionAttribute::isLowerCaseAccentSpaces('!@#$%^&*()_+-=[]{}|;:,.<>?'));
            $this->assertFalse(functionAttribute::isLowerCaseAccentSpaces('AbC1'));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::isUpperCaseAccentSpaces
        */
        public function testIsUpperCaseAccentSpaces() : void {
            $this->assertTrue(functionAttribute::isUpperCaseAccentSpaces('ABCDEFGHIJKLMNOPQRSTUVWXYZ ÁÉÍÓÚÜÑ'));
            $this->assertFalse(functionAttribute::isUpperCaseAccentSpaces('abcdefghijklmnopqrstuvwxyz'));
            $this->assertFalse(functionAttribute::isUpperCaseAccentSpaces('1234567890'));
            $this->assertFalse(functionAttribute::isUpperCaseAccentSpaces('!@#$%^&*()_+-=[]{}|;:,.<>?'));
            $this->assertFalse(functionAttribute::isUpperCaseAccentSpaces('AbC1'));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::isAlphaAccentSpaces
        */
        public function testIsAlphaAccentSpaces() : void {
            $this->assertTrue(functionAttribute::isAlphaAccentSpaces('ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz ÁÉÍÓÚÜÑ áéíóúüñ'));
            $this->assertFalse(functionAttribute::isAlphaAccentSpaces('1234567890'));
            $this->assertFalse(functionAttribute::isAlphaAccentSpaces('!@#$%^&*()_+-=[]{}|;:,.<>?'));
            $this->assertFalse(functionAttribute::isAlphaAccentSpaces('AbC1'));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::valNumeric
        */
        public function testValNumeric() : void {
            $this->assertTrue(functionAttribute::valNumeric('12345'));
            $this->assertFalse(functionAttribute::valNumeric('abcde'));
            $this->assertFalse(functionAttribute::valNumeric('12345abcde'));
            $this->assertFalse(functionAttribute::valNumeric('abcde12345'));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::hasMinLength
        */
        public function testHasMinLength() : void {
            $this->assertTrue(functionAttribute::hasMinLength('abcde', 3));
            $this->assertTrue(functionAttribute::hasMinLength('abcde', 5));
            $this->assertFalse(functionAttribute::hasMinLength('abcde', 6));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::hasMaxLength
        */
        public function testHasMaxLength() : void {
            $this->assertTrue(functionAttribute::HasMaxLength('abc', 5));
            $this->assertTrue(functionAttribute::HasMaxLength('abcde', 5));
            $this->assertFalse(functionAttribute::HasMaxLength('abcdef', 5));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::isValidDate
        */
        public function testIsValidDate() : void {
            $this->assertTrue(functionAttribute::isValidDate('2024-04-20', 'Y-m-d'));
            $this->assertFalse(functionAttribute::isValidDate('2024-04-31', 'Y-m-d'));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::isFormatTime
        */
        public function testIsFormatTime() : void {
            $this->assertTrue(functionAttribute::isFormatTime('13:45'));
            $this->assertTrue(functionAttribute::isFormatTime('23:59'));
            $this->assertFalse(functionAttribute::isFormatTime('25:00'));
            $this->assertFalse(functionAttribute::isFormatTime('12:60'));
            $this->assertFalse(functionAttribute::isFormatTime('abc:def'));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::isValidTime
        */
        public function testIsValidTime() : void {
            $this->assertTrue(functionAttribute::isValidTime('12:34:56'));
            $this->assertFalse(functionAttribute::isValidTime('25:00:00'));
            $this->assertFalse(functionAttribute::isValidTime('12:60:00'));
            $this->assertFalse(functionAttribute::isValidTime('12:34'));
            $this->assertFalse(functionAttribute::isValidTime('abc'));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::isIsoValidDateTime
        */
        public function testIsIsoValidDateTime() : void {
            $this->assertTrue(functionAttribute::isIsoValidDateTime('2024-04-16T12:34:56'));
            $this->assertFalse(functionAttribute::isIsoValidDateTime('2024-04-16 12:34:56'));
            $this->assertFalse(functionAttribute::isIsoValidDateTime('2024-04-16T12:34'));
            $this->assertFalse(functionAttribute::isIsoValidDateTime('abc'));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::isValidDateTime
        */
        public function testIsValidDateTime() : void {
            $this->assertTrue(functionAttribute::isValidDateTime('2024-04-16 12:34:56'));
            $this->assertFalse(functionAttribute::isValidDateTime('2024-04-16T12:34:56'));
            $this->assertFalse(functionAttribute::isValidDateTime('2024-04-16 12:34'));
            $this->assertFalse(functionAttribute::isValidDateTime('abc'));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::hasNoSpaces
        */
        public function testHasNoSpaces() : void {
            $this->assertTrue(functionAttribute::hasNoSpaces('stringwithoutspaces'));
            $this->assertFalse(functionAttribute::hasNoSpaces('string with spaces'));
            $this->assertFalse(functionAttribute::hasNoSpaces(''));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::hasSpaces
        */
        public function testHasSpaces() : void {
            $this->assertTrue(functionAttribute::hasSpaces('string with spaces'));
            $this->assertFalse(functionAttribute::hasSpaces('stringwithoutspaces'));
            $this->assertFalse(functionAttribute::hasSpaces(''));
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::lettersAndNumbers
        */
        public function testLettersAndNumbers() : void {
            $this->assertTrue(functionAttribute::lettersAndNumbers('abc123'));
            $this->assertTrue(functionAttribute::lettersAndNumbers('ABC123'));
            $this->assertTrue(functionAttribute::lettersAndNumbers('123'));
            $this->assertFalse(functionAttribute::lettersAndNumbers('abc 123')); // Contiene un espacio
            $this->assertFalse(functionAttribute::lettersAndNumbers('abc-123')); // Contiene un guion
            $this->assertFalse(functionAttribute::lettersAndNumbers('abc@123')); // Contiene un caracter especial
        }

        /**
         * @covers MyApp\Functions\AttributeFunction::isValidEmail
        */
        public function testIsValidEmail() : void {
            $this->assertTrue(functionAttribute::isValidEmail('email@example.com'));
            $this->assertTrue(functionAttribute::isValidEmail('email123@example.com'));
            $this->assertTrue(functionAttribute::isValidEmail('email+test@example.com'));
            $this->assertFalse(functionAttribute::isValidEmail('invalidemail@')); // Falta el dominio
            $this->assertFalse(functionAttribute::isValidEmail('invalidemail@.com')); // Falta el dominio
            $this->assertFalse(functionAttribute::isValidEmail('invalidemail.com')); // Falta el arroba
            $this->assertFalse(functionAttribute::isValidEmail('invalidemail@invalid')); // Dominio inválido
        }
    }
