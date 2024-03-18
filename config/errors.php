<?php
    # Visualizar Errores
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    
    // Directorio de logs
    $logDir = DIRSTORAGE . '/logs/';

    // Nombre del archivo de log con la fecha actual
    $logFileName = 'error-' . date('Y-m-d') . '.log';

    // Ruta completa del archivo de log
    $logFilePath = $logDir . $logFileName;

    ini_set('error_log', $logFilePath);
