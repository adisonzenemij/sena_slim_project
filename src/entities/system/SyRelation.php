<?php
    namespace MyApp\Entities\System;

    use MyApp\Functions\AttributeFunction as functionAttribute;

    class SyRelation {
        private $fnctAttribute;

        private $pmDataType;
        private $fdIdRegister;
        private $fdOsName;
        private $fdSyEliminate;
        private $fdSyModule;

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
            if (isset($data['os_name'])) {
                $field = $data['os_name'];
                $this->fdOsName = $field;
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
        }

        public function validate($flag = false) {
            $message = array();
            # Asignar el tipo de dato
            $alInUp = array('insert', 'update');
            $alInRmRs = array('insert', 'remove', 'restore');
            $param = $this->pmDataType;
            $getIdRegister = $this->getIdRegister();
            $getOsName = $this->getOsName();
            $getSyEliminate = $this->getSyEliminate();
            $getSyModule = $this->getSyModule();
            # Obtener mensaje validado
            if (!empty($getIdRegister)) {
                $message[] = array('warning' => $getIdRegister);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getOsName) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getOsName);
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
    
        private function getOsName($flag = false) {
            $message = '';
            $minLengh = 5;
            $maxLengh = 255;
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>nombre</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdOsName);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valMin = $this->fnctAttribute->hasMinLength($this->fdOsName, $minLengh);
                $valMax = $this->fnctAttribute->hasMaxLength($this->fdOsName, $maxLengh);
                # Asignar mensaje segun validacion
                if (!$flag && $valMin == 0) { $message .= "$textInfo debe tener minimo $minLengh caracteres"; }
                if (!$flag && $valMin == 0) { $flag = true; }
                # Asignar mensaje segun validacion
                if (!$flag && $valMax == 0) { $message .= "$textInfo debe tener maximo $maxLengh caracteres"; }
                if (!$flag && $valMax == 0) { $flag = true; }
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
    }
