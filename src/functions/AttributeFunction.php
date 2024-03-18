<?php
    namespace MyApp\Functions;
    
    class AttributeFunction {
        # Verificar si el campo está vacío
        public static function isEmpty($str) {
            return empty($str);
        }

        # Verificar si la cadena contiene letras alfabéticas
        public static function valAlphabetic($str) {
            return preg_match('/^\p{L}+$/u', $str);
        }

        # Verificar si la cadena contiene solo letras alfabéticas y espacios
        public static function valAlphabeticSpaces($str) {
            return preg_match('/^[\p{L} ]+$/u', $str);
        }

        # Verificar si la cadena contiene solo letras minúsculas
        public static function isLowerCase($str) {
            return ctype_lower($str);
        }

        # Verificar si la cadena contiene solo letras mayúsculas
        public static function isUpperCase($str) {
            return ctype_upper($str);
        }

        # Verificar si la cadena contiene solo letras (mayúsculas y minúsculas)
        public static function isAlpha($str) {
            return ctype_alpha($str);
        }

        # Verificar si la cadena contiene solo letras minúsculas con tildes y la letra "ñ"
        public static function isLowerCaseAccent($str) {
            return preg_match('/^[a-záéíóúüñ]+$/u', $str);
        }

        # Verificar si la cadena contiene solo letras mayúsculas con tildes y la letra "ñ"
        public static function isUpperCaseAccent($str) {
            return preg_match('/^[A-ZÁÉÍÓÚÜÑ]+$/u', $str);
        }
        
        # Verificar si la cadena contiene solo letras (mayúsculas y minúsculas) con tildes y la letra "ñ"
        public static function isAlphaAccent($str) {
            return preg_match('/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]+$/u', $str);
        }

        # Verificar si la cadena contiene solo letras minúsculas con tildes y la letra "ñ" y espacios
        public static function isLowerCaseAccentSpaces($str) {
            return preg_match('/^[a-záéíóúüñ ]+$/u', $str);
        }

        # Verificar si la cadena contiene solo letras mayúsculas con tildes y la letra "ñ" y espacios
        public static function isUpperCaseAccentSpaces($str) {
            return preg_match('/^[A-ZÁÉÍÓÚÜÑ ]+$/u', $str);
        }

        # Verificar si la cadena contiene solo letras (mayúsculas y minúsculas) con tildes y la letra "ñ" y espacios
        public static function isAlphaAccentSpaces($str) {
            return preg_match('/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ ]+$/u', $str);
        }

        # Verificar si la cadena contiene dígitos numéricos
        public static function valNumeric($str) {
            return ctype_digit($str);
        }

        # Verificar si la longitud de la cadena es al menos $minLength
        public static function hasMinLength($str, $minLength) {
            return strlen($str) >= $minLength;
        }

        # Verificar si la longitud de la cadena no supera $maxLength
        public static function hasMaxLength($str, $maxLength) {
            return strlen($str) <= $maxLength;
        }

        # Verificar si la cadena de fecha es válida y coincide
        public static function isValidDate($dateString, $format = 'Y-m-d') {
            # Crear un objeto DateTime con la cadena de fecha
            $dateTime = \DateTime::createFromFormat($format, $dateString);
            return $dateTime && $dateTime->format($format) === $dateString;
        }

        # Utilizar expresión regular para validar el formato de la hora (24 horas)
        public static function isFormatTime($format) {
            return preg_match('/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/', $format) === 1;
        }

        public static function isValidTime($time) {
            $dateTime = \DateTime::createFromFormat('H:i:s', $time);
            return $dateTime && $dateTime->format('H:i:s') === $time;
        }

        # Verificar si la cadena de fecha y hora es válida y coincide
        public static function isIsoValidDateTime($dateTimeString, $format = 'Y-m-d\TH:i:s') {
            # Crear un objeto DateTime con la cadena de fecha y hora
            $dateTime = \DateTime::createFromFormat($format, $dateTimeString);
            return $dateTime && $dateTime->format($format) === $dateTimeString;
        }

        # Verificar si la cadena de fecha y hora es válida y coincide
        public static function isValidDateTime($dateTimeString, $format = 'Y-m-d H:i:s') {
            # Crear un objeto DateTime con la cadena de fecha y hora
            $dateTime = \DateTime::createFromFormat($format, $dateTimeString);
            return $dateTime && $dateTime->format($format) === $dateTimeString;
        }

        # Verificar si la cadena no contiene ningún espacio en blanco
        public static function hasNoSpaces($str) {
            return strpos($str, ' ') === false;
        }

        # Verificar si la cadena contiene al menos un espacio en blanco
        public static function hasSpaces($str) {
            return strpos($str, ' ') !== false;
        }
        
        # Verificar si la cadena contiene solo letras y números
        public static function lettersAndNumbers($str) {
            return ctype_alnum($str);
        }

        # Verificar si el formato del correo electrónico
        public static function isValidEmail($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
        }
        
    }
