<?php
    namespace MyApp\Functions;
    
    class GeneralFunction {
        public static function customExplode($input) {
            // Combina los resultados en un solo array
            $result = [];
            // Encuentra todas las coincidencias de texto entre paréntesis
            preg_match_all('/\([^)]+\)|[^,]+/', $input, $matches);
            foreach ($matches[0] as $match) {
                // Si la coincidencia comienza con '(' y termina con ')', agrégala al resultado sin comas
                if (substr($match, 0, 1) === '(' && substr($match, -1) === ')') {
                    $result[] = $match;
                } else {
                    // De lo contrario, realiza un explode normal por comas
                    $result = array_merge($result, explode(',', $match));
                }
            }
            return $result;
        }
    }