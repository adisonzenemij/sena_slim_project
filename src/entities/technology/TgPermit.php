<?php
    namespace MyApp\Entities\Technology;

    use MyApp\Functions\AttributeFunction as functionAttribute;

    class TgPermit {
        private $fnctAttribute;

        private $pmDataType;
        private $fdIdRegister;
        private $fdSyEliminate;
        private $fdSyModule;
        private $fdTgAction;
        private $fdTgAuthorization;
        private $fdTgRole;

        public function __construct($param, $data) {
            # Instanciando clases del aplicativo
            $this->fnctAttribute = new functionAttribute;
            # Asignar valores recibidos
            $this->assignValues($param, $data);
        }

        private function assignValues($param, $data) {
            # Asignar valor del frontend si existe
            if (!empty($param)) { $this->pmDataType = $param; }
            # Asignar valor del frontend si existe
            if (isset($data['id_register'])) {
                $field = $data['id_register'];
                $this->fdIdRegister = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['sy_eliminate'])) {
                $field = $data['sy_eliminate'];
                $this->fdSyEliminate = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['sy_module'])) {
                $field = $data['sy_module'];
                $this->fdSyModule = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['tg_action'])) {
                $field = $data['tg_action'];
                $this->fdTgAction = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['tg_authorization'])) {
                $field = $data['tg_authorization'];
                $this->fdTgAuthorization = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['tg_role'])) {
                $field = $data['tg_role'];
                $this->fdTgRole = $field;
            }
        }

        public function validate($flag = false) {
            $message = array();
            # Asignar el tipo de dato
            $alInUp = array('insert', 'update');
            $alInRmRs = array('insert', 'remove', 'restore');
            $param = $this->pmDataType;
            $getIdRegister = $this->getIdRegister();
            $getSyEliminate = $this->getSyEliminate();
            $getSyModule = $this->getSyModule();
            $getTgAction = $this->getTgAction();
            $getTgAuthorization = $this->getTgAuthorization();
            $getTgRole = $this->getTgRole();
            # Obtener mensaje validado
            if (!empty($getIdRegister)) {
                $message[] = array('warning' => $getIdRegister);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getSyEliminate) && in_array($param, $alInRmRs)) {
                $message[] = array('warning' => $getSyEliminate);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getSyModule) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getSyModule);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getTgAction) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getTgAction);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getTgAuthorization) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getTgAuthorization);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getTgRole) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getTgRole);
                $flag = true;
            }
            # Retornar el mensaje
            return $message;
        }

        private function getIdRegister($flag = false) {
            $message = '';
            # Validar si existe informacion
            if (!empty($this->fdIdRegister)) {
                # Mensaje general para retornar en validacion
                $textInfo = 'El campo <b>registro</b> del formulario';
                # Funciones de validación para el campo del formulario
                $valEmpt = $this->fnctAttribute->isEmpty($this->fdIdRegister);
                $valNum = $this->fnctAttribute->valNumeric($this->fdIdRegister);
                # Asignar mensaje segun validacion
                if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
                if ($valEmpt) { $flag = true; }
                # Asignar mensaje segun validacion
                if (!$flag && $valNum == 0) { $message .= "$textInfo permite solo numeros"; }
                if (!$flag && $valNum == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }

        private function getSyEliminate($flag = false) {
            $message = '';
            # Validar si existe informacion
            if (!empty($this->fdSyEliminate)) {
                # Mensaje general para retornar en validacion
                $textInfo = 'El campo <b>eliminado</b> del formulario';
                # Funciones de validación para el campo del formulario
                $valEmpt = $this->fnctAttribute->isEmpty($this->fdSyEliminate);
                $valNum = $this->fnctAttribute->valNumeric($this->fdSyEliminate);
                # Asignar mensaje segun validacion
                if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
                if ($valEmpt) { $flag = true; }
                # Asignar mensaje segun validacion
                if (!$flag && $valNum == 0) { $message .= "$textInfo permite solo valores establecidos"; }
                if (!$flag && $valNum == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }

        private function getSyModule($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>modulo</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdSyModule);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valNum = $this->fnctAttribute->valNumeric($this->fdSyModule);
                # Asignar mensaje segun validacion
                if (!$flag && $valNum == 0) { $message .= "$textInfo permite solo valores establecidos"; }
                if (!$flag && $valNum == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }

        private function getTgAction($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>accion</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdTgAction);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valNum = $this->fnctAttribute->valNumeric($this->fdTgAction);
                # Asignar mensaje segun validacion
                if (!$flag && $valNum == 0) { $message .= "$textInfo permite solo valores establecidos"; }
                if (!$flag && $valNum == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }

        private function getTgAuthorization($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>autorizacion</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdTgAuthorization);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valNum = $this->fnctAttribute->valNumeric($this->fdTgAuthorization);
                # Asignar mensaje segun validacion
                if (!$flag && $valNum == 0) { $message .= "$textInfo permite solo valores establecidos"; }
                if (!$flag && $valNum == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }

        private function getTgRole($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>rol</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdTgRole);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valNum = $this->fnctAttribute->valNumeric($this->fdTgRole);
                # Asignar mensaje segun validacion
                if (!$flag && $valNum == 0) { $message .= "$textInfo permite solo valores establecidos"; }
                if (!$flag && $valNum == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }
    }
