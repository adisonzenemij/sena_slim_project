<?php
    namespace MyApp\Entities\Application;

    use MyApp\Functions\AttributeFunction as functionAttribute;

    class ApSettled {
        private $fnctAttribute;

        private $pmDataType;
        private $fdIdRegister;
        private $fdOsDate;
        private $fdOsExhibit;
        private $fdOsFoundation;
        private $fdOsNumber;
        private $fdApCommunication;
        private $fdApPatient;
        private $fdApRequest;
        private $fdApResource;
        private $fdApState;
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
            if (isset($data['os_exhibit'])) {
                $field = $data['os_exhibit'];
                $this->fdOsExhibit = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['os_foundation'])) {
                $field = $data['os_foundation'];
                $this->fdOsFoundation = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['os_number'])) {
                $field = $data['os_number'];
                $this->fdOsNumber = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['ap_communication'])) {
                $field = $data['ap_communication'];
                $this->fdApCommunication = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['ap_patient'])) {
                $field = $data['ap_patient'];
                $this->fdApPatient = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['ap_request'])) {
                $field = $data['ap_request'];
                $this->fdApRequest = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['ap_resource'])) {
                $field = $data['ap_resource'];
                $this->fdApResource = $field;
            }
            # Asignar valor del frontend si existe
            if (isset($data['ap_state'])) {
                $field = $data['ap_state'];
                $this->fdApState = $field;
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
            $getOsExhibit = $this->getOsExhibit();
            $getOsFoundation = $this->getOsFoundation();
            $getOsNumber = $this->getOsNumber();
            $getApCommunication = $this->getApCommunication();
            $getApPatient = $this->getApPatient();
            $getApRequest = $this->getApRequest();
            $getApResource = $this->getApResource();
            $getApState = $this->getApState();
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
            if (!$flag && !empty($getOsExhibit) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getOsExhibit);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getOsFoundation) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getOsFoundation);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getOsNumber) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getOsNumber);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getApCommunication) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getApCommunication);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getApPatient) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getApPatient);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getApRequest) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getApRequest);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getApResource) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getApResource);
                $flag = true;
            }
            # Obtener mensaje validado
            if (!$flag && !empty($getApState) && in_array($param, $alInUp)) {
                $message[] = array('warning' => $getApState);
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
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valDate = $this->fnctAttribute->isValidDate($this->fdOsDate);
                # Asignar mensaje segun validacion
                if (!$flag && $valDate == 0) { $message .= "$textInfo es invalido"; }
                if (!$flag && $valDate == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }

        private function getOsExhibit($flag = false) {
            $message = '';
            # Validar si existe informacion
            if (!empty($this->fdOsExhibit)) {
                # Mensaje general para retornar en validacion
                $textInfo = 'El campo <b>anexo</b> del formulario';
                # Funciones de validación para el campo del formulario
                $valEmpt = $this->fnctAttribute->isEmpty($this->fdOsExhibit);
                # Asignar mensaje segun validacion
                if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
                if ($valEmpt) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }

        private function getOsFoundation($flag = false) {
            $message = '';
            $minLengh = 5;
            $maxLengh = 1500;
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>fundamento</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdOsFoundation);
            $valMin = $this->fnctAttribute->hasMinLength($this->fdOsFoundation, $minLengh);
            $valMax = $this->fnctAttribute->hasMaxLength($this->fdOsFoundation, $maxLengh);
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

        private function getOsNumber($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>numero</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdOsNumber);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valNum = $this->fnctAttribute->valNumeric($this->fdOsNumber);
                # Asignar mensaje segun validacion
                if (!$flag && $valNum == 0) { $message .= "$textInfo permite solo numeros"; }
                if (!$flag && $valNum == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }

        private function getApCommunication($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>comunicacion</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdApCommunication);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valNum = $this->fnctAttribute->valNumeric($this->fdApCommunication);
                # Asignar mensaje segun validacion
                if (!$flag && $valNum == 0) { $message .= "$textInfo permite solo valores establecidos"; }
                if (!$flag && $valNum == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }

        private function getApPatient($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>paciente</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdApPatient);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valNum = $this->fnctAttribute->valNumeric($this->fdApPatient);
                # Asignar mensaje segun validacion
                if (!$flag && $valNum == 0) { $message .= "$textInfo permite solo valores establecidos"; }
                if (!$flag && $valNum == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }

        private function getApRequest($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>solicitud</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdApRequest);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valNum = $this->fnctAttribute->valNumeric($this->fdApRequest);
                # Asignar mensaje segun validacion
                if (!$flag && $valNum == 0) { $message .= "$textInfo permite solo valores establecidos"; }
                if (!$flag && $valNum == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }

        private function getApResource($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>recurso</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdApResource);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valNum = $this->fnctAttribute->valNumeric($this->fdApResource);
                # Asignar mensaje segun validacion
                if (!$flag && $valNum == 0) { $message .= "$textInfo permite solo valores establecidos"; }
                if (!$flag && $valNum == 0) { $flag = true; }
            }
            # Retornar el mensaje
            return $message;
        }

        private function getApState($flag = false) {
            $message = '';
            # Mensaje general para retornar en validacion
            $textInfo = 'El campo <b>estado</b> del formulario';
            # Funciones de validación para el campo del formulario
            $valEmpt = $this->fnctAttribute->isEmpty($this->fdApState);
            # Asignar mensaje segun validacion
            if ($valEmpt) { $message .= "$textInfo es obligatorio"; }
            if ($valEmpt) { $flag = true; }
            # Validar si existe informacion
            if (!$flag) {
                # Funciones de validación para el campo del formulario
                $valNum = $this->fnctAttribute->valNumeric($this->fdApState);
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
