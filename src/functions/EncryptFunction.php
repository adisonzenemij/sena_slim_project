<?php
    namespace MyApp\Functions;
    
    class EncryptFunction {
        # Funcion para encriptar contraseñas
        final public static function bcrypt($keyNormal) {
            /*
                Nivel de seguridad estándar: Costo de 12 a 13.
                Esto proporciona un nivel razonable de seguridad y
                es adecuado para la mayoría de las aplicaciones.

                Alta seguridad: Costo de 14 a 15 o superior.
                Si estás manejando información especialmente sensible,
                puedes aumentar el costo para aumentar la seguridad.

                Consideraciones de rendimiento: Valores más altos de costo requerirán
                más tiempo de procesamiento para calcular el hash.
                Si tu servidor tiene recursos limitados o necesitas un rendimiento rápido,
                es posible que debas equilibrar la seguridad con el rendimiento.
            */
            $options = [
                // Controla la resistencia de la encriptación.
                // Un valor más alto es más seguro pero más lento
                'cost' => 14,
                // Uso de memoria (predeterminado: 1024)
                'memory_cost' => 65536,
                // Costo de tiempo (predeterminado: 2)
                'time_cost' => 4,
                // Número de hilos (predeterminado: 2)
                'threads' => 2,
                // Sal personalizada (opcional)
                #'salt' => 'tusaltsecreta',
            ];
            return password_hash($keyNormal, PASSWORD_BCRYPT, $options);
        }
    }
