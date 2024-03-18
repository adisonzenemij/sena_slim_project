<?php
    namespace MyApp\Entities;

    use MyApp\Entities\Technology\TgAction;
    use MyApp\Entities\Technology\TgAuthorization;
    use MyApp\Entities\Technology\TgDocument;
    use MyApp\Entities\Technology\TgPermit;
    use MyApp\Entities\Technology\TgRole;
    use MyApp\Entities\Technology\TgUser;
    
    class TechnologyEntity {
        public static function export($params) {
            $response = array();
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
            $tgAction = new tgAction($dtDataType, $dtBody);
            $tgAuthorization = new tgAuthorization($dtDataType, $dtBody);
            $tgDocument = new tgDocument($dtDataType, $dtBody);
            $tgPermit = new tgPermit($dtDataType, $dtBody);
            $tgRole = new tgRole($dtDataType, $dtBody);
            $tgUser = new tgUser($dtDataType, $dtBody);
            # Validar si existen las tablas con sus respectivos campos
            if ($dtTable == 'tg_action') { $response = $tgAction->validate(); }
            if ($dtTable == 'tg_authorization') { $response = $tgAuthorization->validate(); }
            if ($dtTable == 'tg_document') { $response = $tgDocument->validate(); }
            if ($dtTable == 'tg_permit') { $response = $tgPermit->validate(); }
            if ($dtTable == 'tg_role') { $response = $tgRole->validate(); }
            if ($dtTable == 'tg_user') { $response = $tgUser->validate(); }
            # Retornar respuesta
            return $response;
        }
    }
