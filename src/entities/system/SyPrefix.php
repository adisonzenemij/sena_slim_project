<?php
    namespace MyApp\Entities\System;

    use MyApp\Functions\AttributeFunction as functionAttribute;

    class SyPrefix {
        private $fnctAttribute;

        private $pmDataType;
        private $fdIdRegister;
        private $fdOsModule;
        private $fdOsPrefix;
        private $fdOsTemplate;
        private $fdSyEliminate;

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
            if (isset($data['os_module'])) {
                $field = $data['os_module'];
                $this->fdOsModule = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['os_prefix'])) {
                $field = $data['os_prefix'];
                $this->fdOsPrefix = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['os_template'])) {
                $field = $data['os_template'];
                $this->fdOsTemplate = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['sy_eliminate'])) {
                $field = $data['sy_eliminate'];
                $this->fdSyEliminate = $field;
            }
        }

        public function validate($flag = false) {
            $message = array();
            # Asignar el tipo de dato
            $alInUp = array('insert', 'update');
            $alInRmRs = array('insert', 'remove', 'restore');
            $param = $this->pmDataType;
            $getIdRegister = $this->getIdRegister();
            $getOsModule = $this->getOsModule();
            $getOsPrefix = $this->getOsPrefix();
            $getOsTemplate = $this->getOsTemplate();
            $getSyEliminate = $this->getSyEliminate();
            # Obtener mensaje validado
            if (!empty($getIdRegister)) {
                $message[] = array('warning' => $getIdRegister);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getOsModule) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getOsModule);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getOsPrefix) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getOsPrefix);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getOsTemplate) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getOsTemplate);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getSyEliminate) && in_array($param, $alInRmRs)) {
                $message[] = array('warning' => $getSyEliminate);
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

        private function getOsModule($flag = false) {
            $message = '';
            $minLengh = 5;
            $maxLengh = 255;
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>modulo</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdOsModule);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valAlph = $this->fnctAttribute->valAlphabetic($this->fdOsModule);
                $isAplha = $this->fnctAttribute->isAlphaAccent($this->fdOsModule);
                $valMin = $this->fnctAttribute->hasMinLength($this->fdOsModule, $minLengh);
                $valMax = $this->fnctAttribute->hasMaxLength($this->fdOsModule, $maxLengh);
                # Asignar mensaje segun validacion
                if (!$flag && $valAlph == 0) { $message .= "$textInfo permite solo letras"; }
                if (!$flag && $valAlph == 0) { $flag = true; }
                # Asignar mensaje segun validacion
                if (!$flag && $isAplha == 0) { $message .= "$textInfo permite solo mayusculas y minusculas"; }
                if (!$flag && $isAplha == 0) { $flag = true; }
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

        private function getOsPrefix($flag = false) {
            $message = '';
            $minLengh = 2;
            $maxLengh = 2;
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>prefijo</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdOsPrefix);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valAlph = $this->fnctAttribute->valAlphabetic($this->fdOsPrefix);
                $isLower = $this->fnctAttribute->isLowerCase($this->fdOsPrefix);
                $valMin = $this->fnctAttribute->hasMinLength($this->fdOsPrefix, $minLengh);
                $valMax = $this->fnctAttribute->hasMaxLength($this->fdOsPrefix, $maxLengh);
                # Asignar mensaje segun validacion
                if (!$flag && $valAlph == 0) { $message .= "$textInfo permite solo letras"; }
                if (!$flag && $valAlph == 0) { $flag = true; }
                # Asignar mensaje segun validacion
                if (!$flag && !$isLower) { $message .= "$textInfo permite solo minusculas"; }
                if (!$flag && !$isLower) { $flag = true; }
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

        private function getOsTemplate($flag = false) {
            $message = '';
            $minLengh = 5;
            $maxLengh = 255;
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>plantilla</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdOsTemplate);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valAlph = $this->fnctAttribute->valAlphabetic($this->fdOsTemplate);
                $isLower = $this->fnctAttribute->isLowerCase($this->fdOsTemplate);
                $valMin = $this->fnctAttribute->hasMinLength($this->fdOsTemplate, $minLengh);
                $valMax = $this->fnctAttribute->hasMaxLength($this->fdOsTemplate, $maxLengh);
                # Asignar mensaje segun validacion
                if (!$flag && $valAlph == 0) { $message .= "$textInfo permite solo letras"; }
                if (!$flag && $valAlph == 0) { $flag = true; }
                # Asignar mensaje segun validacion
                if (!$flag && $isLower == 0) { $message .= "$textInfo permite solo minusculas"; }
                if (!$flag && $isLower == 0) { $flag = true; }
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
    }
