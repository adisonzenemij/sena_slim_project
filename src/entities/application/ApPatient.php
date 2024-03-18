<?php
    namespace MyApp\Entities\Application;

    use MyApp\Functions\AttributeFunction as functionAttribute;

    class ApPatient {
        private $fnctAttribute;

        private $pmDataType;
        private $fdIdRegister;
        private $fdOsEmail;
        private $fdOsIdentification;
        private $fdOsNames;
        private $fdOsPhone;
        private $fdOsSurnames;
        private $fdSyEliminate;
        private $fdTgDocument;

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
            if (isset($data['os_email'])) {
                $field = $data['os_email'];
                $this->fdOsEmail = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['os_identification'])) {
                $field = $data['os_identification'];
                $this->fdOsIdentification = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['os_names'])) {
                $field = $data['os_names'];
                $this->fdOsNames = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['os_phone'])) {
                $field = $data['os_phone'];
                $this->fdOsPhone = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['os_surnames'])) {
                $field = $data['os_surnames'];
                $this->fdOsSurnames = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['sy_eliminate'])) {
                $field = $data['sy_eliminate'];
                $this->fdSyEliminate = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['tg_document'])) {
                $field = $data['tg_document'];
                $this->fdTgDocument = $field;
            }
        }

        public function validate($flag = false) {
            $message = array();
            # Asignar el tipo de dato
            $alInUp = array('insert', 'update');
            $alInRmRs = array('insert', 'remove', 'restore');
            $param = $this->pmDataType;
            $getIdRegister = $this->getIdRegister();
            $getOsEmail = $this->getOsEmail();
            $getOsIdentification = $this->getOsIdentification();
            $getOsNames = $this->getOsNames();
            $getOsPhone = $this->getOsPhone();
            $getOsSurnames = $this->getOsSurnames();
            $getSyEliminate = $this->getSyEliminate();
            $getTgDocument = $this->getTgDocument();
            # Obtener mensaje validado
            if (!empty($getIdRegister)) {
                $message[] = array('warning' => $getIdRegister);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getOsEmail) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getOsEmail);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getOsIdentification) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getOsIdentification);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getOsNames) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getOsNames);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getOsPhone) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getOsPhone);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getOsSurnames) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getOsSurnames);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getSyEliminate) && in_array($param, $alInRmRs)) {
                $message[] = array('warning' => $getSyEliminate);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getTgDocument) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getTgDocument);
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

        private function getOsEmail($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>correo electronico</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdOsEmail);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valEmail = $this->fnctAttribute->isValidEmail($this->fdOsEmail);
                # Asignar mensaje segun validacion
                if (!$flag && $valEmail == 0) { $message .= "$textInfo es invalido"; }
                if (!$flag && $valEmail == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }

        private function getOsIdentification($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>identificacion</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdOsIdentification);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valNum = $this->fnctAttribute->valNumeric($this->fdOsIdentification);
                # Asignar mensaje segun validacion
                if (!$flag && $valNum == 0) { $message .= "$textInfo permite solo numeros"; }
                if (!$flag && $valNum == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }

        private function getOsNames($flag = false) {
            $message = '';
            $minLengh = 5;
            $maxLengh = 255;
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>nombres</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdOsNames);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valAlph = $this->fnctAttribute->valAlphabeticSpaces($this->fdOsNames);
                $isAlpha = $this->fnctAttribute->isAlphaAccentSpaces($this->fdOsNames);
                $valMin = $this->fnctAttribute->hasMinLength($this->fdOsNames, $minLengh);
                $valMax = $this->fnctAttribute->hasMaxLength($this->fdOsNames, $maxLengh);
                # Asignar mensaje segun validacion
                if (!$flag && $valAlph == 0) { $message .= "$textInfo permite solo letras y espacios"; }
                if (!$flag && $valAlph == 0) { $flag = true; }
                # Asignar mensaje segun validacion
                if (!$flag && $isAlpha == 0) { $message .= "$textInfo permite solo mayusculas y minusculas"; }
                if (!$flag && $isAlpha == 0) { $flag = true; }
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

        private function getOsPhone($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>contacto</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdOsPhone);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valNum = $this->fnctAttribute->valNumeric($this->fdOsPhone);
                # Asignar mensaje segun validacion
                if (!$flag && $valNum == 0) { $message .= "$textInfo permite solo numeros"; }
                if (!$flag && $valNum == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }

        private function getOsSurnames($flag = false) {
            $message = '';
            $minLengh = 5;
            $maxLengh = 255;
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>apellidos</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdOsSurnames);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valAlph = $this->fnctAttribute->valAlphabeticSpaces($this->fdOsSurnames);
                $isAlpha = $this->fnctAttribute->isAlphaAccentSpaces($this->fdOsSurnames);
                $valMin = $this->fnctAttribute->hasMinLength($this->fdOsSurnames, $minLengh);
                $valMax = $this->fnctAttribute->hasMaxLength($this->fdOsSurnames, $maxLengh);
                # Asignar mensaje segun validacion
                if (!$flag && $valAlph == 0) { $message .= "$textInfo permite solo letras y espacios"; }
                if (!$flag && $valAlph == 0) { $flag = true; }
                # Asignar mensaje segun validacion
                if (!$flag && $isAlpha == 0) { $message .= "$textInfo permite solo mayusculas y minusculas"; }
                if (!$flag && $isAlpha == 0) { $flag = true; }
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

        private function getTgDocument($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>documento</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdTgDocument);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valNum = $this->fnctAttribute->valNumeric($this->fdTgDocument);
                # Asignar mensaje segun validacion
                if (!$flag && $valNum == 0) { $message .= "$textInfo permite solo valores establecidos"; }
                if (!$flag && $valNum == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }
    }
