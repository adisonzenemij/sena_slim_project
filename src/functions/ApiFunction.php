<?php
    namespace MyApp\Functions;
    
    class ApiFunction {
        # Funcion para recibir parametros de url
        final public static function queryParams($params) {
            $token = $params['token'] ?? '';
            $table = $params['table'] ?? '';
            $columns = isset($params['column']) && $params['column'] !== '' ? $params['column'] : '*';
            $whereCond = $params['whereCond'] ?? '';
            $whereField = $params['whereField'] ?? '';
            $whereOperator = $params['whereOperator'] ?? '';
            $whereEqual = $params['whereEqual'] ?? '';
            $orderBy = $params['orderBy'] ?? '';
            $orderMode = $params['orderMode'] ?? '';
            $limitStart = $params['limitStart'] ?? '';
            $limitFinal = $params['limitFinal'] ?? '';
            $postData = $params['postData'] ?? '';
            $putData = $params['putData'] ?? '';
            $deleteData = $params['deleteData'] ?? '';
            $dataType = $params['dataType'] ?? '';
            $htmlSelect = $params['htmlSelect'] ?? '';
            $htmlMulti = $params['htmlMulti'] ?? '';
            $multiValue = $params['multiValue'] ?? '';

            return array(
                'token' => $token,
                'table' => $table,
                'column' => $columns,
                'whereCond' => $whereCond,
                'whereField' => $whereField,
                'whereOperator' => $whereOperator,
                'whereEqual' => $whereEqual,
                'orderBy' => $orderBy,
                'orderMode' => $orderMode,
                'limitStart' => $limitStart,
                'limitFinal' => $limitFinal,
                'postData' => $postData,
                'putData' => $putData,
                'deleteData' => $deleteData,
                'dataType' => $dataType,
                'htmlSelect' => $htmlSelect,
                'htmlMulti' => $htmlMulti,
                'multiValue' => $multiValue,
            );
        }
    }
