<?php
    namespace MyApp\Entities;

    use MyApp\Entities\Application\ApCausal;
    use MyApp\Entities\Application\ApCommunication;
    use MyApp\Entities\Application\ApPatient;
    use MyApp\Entities\Application\ApRequest;
    use MyApp\Entities\Application\ApResource;
    use MyApp\Entities\Application\ApSettled;
    use MyApp\Entities\Application\ApState;
    use MyApp\Entities\Application\ApTraceability;
    
    class ApplicationEntity {
        public static function export($params) {
            $response = '';
            $dtBody = [];
            $dtDataType = $params['dataType'];
            $dtTable = $params['table'];
            $dtPostData = $params['postData'];
            $dtPutData = $params['putData'];
            $dtDeleteData = $params['deleteData'];
            if (!empty($dtPostData)) { $dtBody = $params['postData']; }
            if (!empty($dtPutData)) { $dtBody = $params['putData']; }
            if (!empty($dtDeleteData)) { $dtBody = $params['deleteData']; }
            # Instanciar clases
            $apCausal = new ApCausal($dtDataType, $dtBody);
            $apCommunication = new ApCommunication($dtDataType, $dtBody);
            $apPatient = new ApPatient($dtDataType, $dtBody);
            $apRequest = new ApRequest($dtDataType, $dtBody);
            $apResource = new ApResource($dtDataType, $dtBody);
            $apSettled = new ApSettled($dtDataType, $dtBody);
            $apState = new ApState($dtDataType, $dtBody);
            $apTraceability = new ApTraceability($dtDataType, $dtBody);
            # Validar si existen las tablas con sus respectivos campos
            if ($dtTable == 'ap_causal') { $response = $apCausal->validate(); }
            if ($dtTable == 'ap_communication') { $response = $apCommunication->validate(); }
            if ($dtTable == 'ap_patient') { $response = $apPatient->validate(); }
            if ($dtTable == 'ap_request') { $response = $apRequest->validate(); }
            if ($dtTable == 'ap_resource') { $response = $apResource->validate(); }
            if ($dtTable == 'ap_settled') { $response = $apSettled->validate(); }
            if ($dtTable == 'ap_state') { $response = $apState->validate(); }
            if ($dtTable == 'ap_traceability') { $response = $apTraceability->validate(); }
            # Retornar respuesta
            return $response;
        }
    }
