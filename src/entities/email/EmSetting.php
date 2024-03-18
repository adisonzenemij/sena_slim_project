<?php
    namespace MyApp\Entities\Email;

    use MyApp\Functions\AttributeFunction as functionAttribute;

    class EmSetting {
        private $fnctAttribute;

        private $pmDataType;
        private $fdIdRegister;
        private $fdOsPassword;
        private $fdOsUsername;
        private $fdEmHosting;
        private $fdEmSecurity;
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
            if (isset($data['os_password'])) {
                $field = $data['os_password'];
                $this->fdOsPassword = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['os_username'])) {
                $field = $data['os_username'];
                $this->fdOsUsername = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['em_hosting'])) {
                $field = $data['em_hosting'];
                $this->fdEmHosting = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['em_security'])) {
                $field = $data['em_security'];
                $this->fdEmSecurity = $field;
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
            $getOsPassword = $this->getOsPassword();
            $getOsUsername = $this->getOsUsername();
            $getEmHosting = $this->getEmHosting();
            $getEmSecurity = $this->getEmSecurity();
            $getSyEliminate = $this->getSyEliminate();
            # Obtener mensaje validado
            if (!empty($getIdRegister)) {
                $message[] = array('warning' => $getIdRegister);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getOsPassword) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getOsPassword);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getOsUsername) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getOsUsername);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getEmHosting) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getEmHosting);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getEmSecurity) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getEmSecurity);
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

        private function getOsPassword($flag = false) {
            $message = '';
            $minLengh = 5;
            $maxLengh = 255;
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>contraseña</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdOsPassword);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valSpac = $this->fnctAttribute->hasNoSpaces($this->fdOsPassword);
                $valMin = $this->fnctAttribute->hasMinLength($this->fdOsPassword, $minLengh);
                $valMax = $this->fnctAttribute->hasMaxLength($this->fdOsPassword, $maxLengh);
                # Asignar mensaje segun validacion
                if (!$flag && !$valSpac) { $message .= "$textInfo no permite ningun espacio"; }
                if (!$flag && !$valSpac) { $flag = true; }
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

        private function getOsUsername($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>usuario</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdOsUsername);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valEmail = $this->fnctAttribute->isValidEmail($this->fdOsUsername);
                # Asignar mensaje segun validacion
                if (!$flag && $valEmail == 0) { $message .= "$textInfo es invalido"; }
                if (!$flag && $valEmail == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }

        private function getEmHosting($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>hosting</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdEmHosting);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valNum = $this->fnctAttribute->valNumeric($this->fdEmHosting);
                # Asignar mensaje segun validacion
                if (!$flag && $valNum == 0) { $message .= "$textInfo permite solo valores establecidos"; }
                if (!$flag && $valNum == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }

        private function getEmSecurity($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>seguridad</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdEmSecurity);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Mensaje general para retornar en validacion
                $valNum = $this->fnctAttribute->valNumeric($this->fdEmSecurity);
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
