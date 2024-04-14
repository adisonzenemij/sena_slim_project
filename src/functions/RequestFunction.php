<?php
    namespace MyApp\Functions;
    
    class RequestFunction {
        # Funcion para retornar valores formateados
        final public static function jsonEncode($response) {
            // Obtener información relevante de la solicitud
            $formated = [
                'headers' => $response->getHeaders(),
                'method' => $response->getMethod(),
                'query_params' => $response->getQueryParams(),
                'request_body' => (string) $response->getBody(),
                'uri' => $response->getUri()->getPath(),
            ];
            return json_encode($formated, JSON_PRETTY_PRINT);
        }
        
        # Funcion para retornar valores formateados
        final public static function jsonResult($response, $data) {
            // Obtener información relevante de la solicitud
            $formated = [
                'data' => json_decode($data),
                'headers' => $response->getHeaders(),
                'method' => $response->getMethod(),
                'query_params' => $response->getQueryParams(),
                'request_body' => (string) $response->getBody(),
                'uri' => $response->getUri()->getPath(),
            ];
            return json_encode($formated, JSON_PRETTY_PRINT);
        }
    }
