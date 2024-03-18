<?php
    namespace MyApp\Entities\System;

    use MyApp\Functions\AttributeFunction as functionAttribute;

    class SySelect {
        private $fnctAttribute;

        private $pmDataType;
        private $fdIdRegister;
        private $fdOsOrder;
        private $fdSyAttribute;
        private $fdSyEliminate;
        private $fdSyModule;
        private $fdSyRelation;

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
            if (isset($data['os_order'])) {
                $field = $data['os_order'];
                $this->fdOsOrder = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['sy_attribute'])) {
                $field = $data['sy_attribute'];
                $this->fdSyAttribute = $field;
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
            if (isset($data['sy_relation'])) {
                $field = $data['sy_relation'];
                $this->fdSyRelation = $field;
            }
        }

        public function validate($flag = false) {
            $message = array();
            # Asignar el tipo de dato
            $alInUp = array('insert', 'update');
            $alInRmRs = array('insert', 'remove', 'restore');
            $param = $this->pmDataType;
            $getIdRegister = $this->getIdRegister();
            $getOsOrder = $this->getOsOrder();
            $getSyEliminate = $this->getSyEliminate();
            $getSyModule = $this->getSyModule();
            $getSyRelation = $this->getSyRelation();
            $getSyAttribute = $this->getSyAttribute();
            # Obtener mensaje validado
            if (!empty($getIdRegister)) {
                $message[] = array('warning' => $getIdRegister);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getOsOrder) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getOsOrder);
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
            if (!$flag && !empty($getSyRelation) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getSyRelation);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getSyAttribute) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getSyAttribute);
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

        private function getOsOrder($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>orden</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdOsOrder);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valNum = $this->fnctAttribute->valNumeric($this->fdOsOrder);
                # Asignar mensaje segun validacion
                if (!$flag && $valNum == 0) { $message .= "$textInfo permite solo numeros"; }
                if (!$flag && $valNum == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }

        private function getSyAttribute($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>atributo</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdSyAttribute);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valNum = $this->fnctAttribute->valNumeric($this->fdSyAttribute);
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

        private function getSyRelation($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>relacion</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdSyRelation);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valNum = $this->fnctAttribute->valNumeric($this->fdSyRelation);
                # Asignar mensaje segun validacion
                if (!$flag && $valNum == 0) { $message .= "$textInfo permite solo valores establecidos"; }
                if (!$flag && $valNum == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }
    }
