<?php
    namespace MyApp\Entities\Application;

    use MyApp\Functions\AttributeFunction as functionAttribute;

    class ApTraceability {
        private $fnctAttribute;

        private $pmDataType;
        private $fdIdRegister;
        private $fdOsDate;
        private $fdOsHour;
        private $fdOsFollow;
        private $fdApSettled;
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
            if (isset($data['os_date'])) {
                $field = $data['os_date'];
                $this->fdOsDate = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['os_hour'])) {
                $field = $data['os_hour'];
                $this->fdOsHour = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['os_follow'])) {
                $field = $data['os_follow'];
                $this->fdOsFollow = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['ap_settled'])) {
                $field = $data['ap_settled'];
                $this->fdApSettled = $field;
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
            $getOsDate = $this->getOsDate();
            $getOsHour = $this->getOsHour();
            $getOsFollow = $this->getOsFollow();
            $getApSettled = $this->getApSettled();
            $getSyEliminate = $this->getSyEliminate();
            # Obtener mensaje validado
            if (!empty($getIdRegister)) {
                $message[] = array('warning' => $getIdRegister);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getOsDate) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getOsDate);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getOsHour) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getOsHour);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getOsFollow) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getOsFollow);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getApSettled) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getApSettled);
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

        private function getOsDate($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>fecha</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdOsDate);
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valDate = $this->fnctAttribute->isValidDate($this->fdOsDate);
                # Asignar mensaje segun validacion
                if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
                if ($valEmpt) { $flag = true; }
                # Asignar mensaje segun validacion
                if (!$flag && $valDate == 0) { $message .= "$textInfo es invalido"; }
                if (!$flag && $valDate == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }

        private function getOsHour($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>hora</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdOsHour);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            /*if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valHour = $this->fnctAttribute->isValidTime($this->fdOsHour);
                # Asignar mensaje segun validacion
                if (!$flag && !$valHour) { $message .= "$textInfo es invalido"; }
                if (!$flag && !$valHour) { $flag = true; }
            }*/
            # Retornar el mensaje
            return $message;
        }

        private function getOsFollow($flag = false) {
            $message = '';
            $minLengh = 5;
            $maxLengh = 1500;
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>seguimiento</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdOsFollow);
            $valMin = $this->fnctAttribute->hasMinLength($this->fdOsFollow, $minLengh);
            $valMax = $this->fnctAttribute->hasMaxLength($this->fdOsFollow, $maxLengh);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Asignar mensaje segun validacion
            if (!$flag && $valMin == 0) { $message .= "$textInfo debe tener minimo $minLengh caracteres"; }
            if (!$flag && $valMin == 0) { $flag = true; }
            # Asignar mensaje segun validacion
            if (!$flag && $valMax == 0) { $message .= "$textInfo debe tener maximo $maxLengh caracteres"; }
            if (!$flag && $valMax == 0) { $flag = true; }
            # Retornar el mensaje
            return $message;
        }

        private function getApSettled($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>radicado</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdApSettled);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valNum = $this->fnctAttribute->valNumeric($this->fdApSettled);
                # Asignar mensaje segun validacion
                if (!$flag && $valNum == 0) { $message .= "$textInfo permite solo valores establecidos"; }
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
    }
