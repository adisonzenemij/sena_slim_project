<?php
    namespace MyApp\Entities;

    use MyApp\Entities\System\SyAttribute;
    use MyApp\Entities\System\SyEliminate;
    use MyApp\Entities\System\SyIcon;
    use MyApp\Entities\System\SyModule;
    use MyApp\Entities\System\SyPrefix;
    use MyApp\Entities\System\SyRelation;
    use MyApp\Entities\System\SySelect;
    use MyApp\Entities\System\SyUnion;
    
    class SystemEntity {
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
            $syAttribute = new SyAttribute($dtDataType, $dtBody);
            $syEliminate = new SyEliminate($dtDataType, $dtBody);
            $syIcon = new SyIcon($dtDataType, $dtBody);
            $syModule = new SyModule($dtDataType, $dtBody);
            $syPrefix = new SyPrefix($dtDataType, $dtBody);
            $syRelation = new SyRelation($dtDataType, $dtBody);
            $sySelect = new SySelect($dtDataType, $dtBody);
            $syUnion = new SyUnion($dtDataType, $dtBody);
            # Validar si existen las tablas con sus respectivos campos
            if ($dtTable == 'sy_attribute') { $response = $syAttribute->validate(); }
            if ($dtTable == 'sy_eliminate') { $response = $syEliminate->validate(); }
            if ($dtTable == 'sy_icon') { $response = $syIcon->validate(); }
            if ($dtTable == 'sy_module') { $response = $syModule->validate(); }
            if ($dtTable == 'sy_prefix') { $response = $syPrefix->validate(); }
            if ($dtTable == 'sy_relation') { $response = $syRelation->validate(); }
            if ($dtTable == 'sy_select') { $response = $sySelect->validate(); }
            if ($dtTable == 'sy_union') { $response = $syUnion->validate(); }
            # Retornar respuesta
            return $response;
        }
    }
