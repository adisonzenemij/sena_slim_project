<?php
    namespace MyApp\Functions;
    
    class JsonFunction {
        # Funcion para retornar valores formateados
        final public static function jsonEncode($data) {
            $isArrayObject = JsonFunction::isArrayObject($data);

            if (!$isArrayObject) {
                // Si no es un arreglo ni un objeto, devolver un JSON con error
                $errorResult = array(array('error' => 'Data is not an array or object',),);
                return json_encode($errorResult, JSON_PRETTY_PRINT);
            }
        
            // Verificar si $data está vacío
            //if (empty($data)) { $results = array(array('warning' => 'Sin Informacion',),); }
            if (empty($data)) { $results = array(); }
            if (!empty($data)) {
                $multidimensional = JsonFunction::isMultidimensional($data);

                if (!$multidimensional) {
                    $errorResult = array(array(
                        'error' => 'Data is not a multidimensional array or object',
                    ),);
                    return json_encode($errorResult, JSON_PRETTY_PRINT);
                }
        
                if ($multidimensional) { $results = JsonFunction::jsonFormat($data); }
            }
        
            return json_encode($results, JSON_PRETTY_PRINT);
        }

        final public static function jsonFormat($data) {
            $arrayData = array();
            foreach ($data as $key) {
                $itemArray = array();
                foreach ($key as $itemKey => $itemValue) {
                    if (!is_numeric($itemKey)) {
                        $itemArray[$itemKey] = $itemValue;
                    }
                }
                $arrayData[] = $itemArray;
            }
            return $arrayData;
        }

        final public static function isArrayObject($data) {
            if (!is_array($data) && !is_object($data)) {
                return false;
            } else {
                return true;
            }
        }

        final public static function isMultidimensional($data) {
            // Verificar si $data es un arreglo multidimensional u objeto que se comporta como tal
            $multidimensional = false;
            // Verificar si $data es un objeto y su primer elemento es un array
            if (is_array($data)) { $multidimensional = count(array_filter(array_map('is_array', $data))) > 0; }
            if (is_object($data) && count($data) === 1 && is_array((array) $data[0])) { $multidimensional = true; }
            if (is_array($data) && !empty($data) && is_object($data[0])) { $multidimensional = true; }
            return $multidimensional;
        }

        # Funcion para retornar valores formateados
        final public static function jsonError($data) {
            if (empty($data)) { return false; }
            $data = json_decode($data, true);
            if ($data === null) { return false; }
            foreach ($data as $item) {
                if (isset($item['error'])) {
                    return false;
                }
            }
            return true;
        }

        # Funcion para retornar valores formateados
        final public static function jsonWarning($data) {
            if (empty($data)) { return false; }
            $data = json_decode($data, true);
            if ($data === null) { return false; }
            foreach ($data as $item) {
                if (isset($item['warning'])) {
                    return false;
                }
            }
            return true;
        }
        
    }
