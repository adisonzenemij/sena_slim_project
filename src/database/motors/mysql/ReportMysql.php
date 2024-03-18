<?php
    namespace MyApp\Database\Motors\MySql;

    use MyApp\Database\Motors\MySql\ConnectMysql;
    
    class ReportMysql extends ConnectMysql {
        # Consultar datos de radicados diario
        public static function settled($data) {
            # Verificar si date_since está definido, de lo contrario, asignar null
            $groupBy = isset($data['groupBy']) ? $data['groupBy'] : 'diary';
            # Segun el tipo de agrupacion indicar el formato de fecha
            if ($groupBy == 'diary') { $formatDate = '%Y-%m-%d'; }
            if ($groupBy == 'monthly') { $formatDate = '%Y-%m'; }
            if ($groupBy == 'annual') { $formatDate = '%Y'; }
            # Verificar si date_since está definido, de lo contrario, asignar null
            $dateSince = isset($data['dateSince']) ? $data['dateSince'] : null;
            # Verificar si date_until está definido, de lo contrario, asignar null
            $dateUntil = isset($data['dateUntil']) ? $data['dateUntil'] : null;
            # Inicializar la consulta SQL
            $sql = "SELECT
                DATE_FORMAT(tb_ap_settled.os_date, '$formatDate') AS lbl_ap_settled_os_date,
                COUNT(*) AS lbl_ap_settled_os_count
            FROM ap_settled tb_ap_settled
            WHERE tb_ap_settled.os_date BETWEEN '$dateSince' AND '$dateUntil'
            GROUP BY lbl_ap_settled_os_date
            ORDER BY lbl_ap_settled_os_date ASC";
            return self::execute($sql);
        }

        # Consultar datos de causales diario
        public static function causal($data) {
            # Verificar si date_since está definido, de lo contrario, asignar null
            $groupBy = isset($data['groupBy']) ? $data['groupBy'] : 'diary';
            # Segun el tipo de agrupacion indicar el formato de fecha
            if ($groupBy == 'diary') { $formatDate = '%Y-%m-%d'; }
            if ($groupBy == 'monthly') { $formatDate = '%Y-%m'; }
            if ($groupBy == 'annual') { $formatDate = '%Y'; }
            # Verificar si date_since está definido, de lo contrario, asignar null
            $dateSince = isset($data['dateSince']) ? $data['dateSince'] : null;
            # Verificar si date_until está definido, de lo contrario, asignar null
            $dateUntil = isset($data['dateUntil']) ? $data['dateUntil'] : null;
            # Inicializar la consulta SQL
            $sql = "SELECT
                tb_ap_causal.os_name as lbl_ap_causal_os_name,
                DATE_FORMAT(tb_ap_settled.os_date, '$formatDate') AS lbl_ap_settled_os_date,
                COUNT(*) AS lbl_ap_settled_os_count
            FROM ap_settled tb_ap_settled
            INNER JOIN ap_resource tb_ap_resource
            ON tb_ap_settled.ap_resource = tb_ap_resource.id_register
            INNER JOIN ap_causal tb_ap_causal
            ON tb_ap_resource.ap_causal = tb_ap_causal.id_register
            WHERE tb_ap_settled.os_date BETWEEN '$dateSince' AND '$dateUntil'
            GROUP BY tb_ap_causal.id_register, lbl_ap_settled_os_date
            ORDER BY tb_ap_causal.id_register ASC, lbl_ap_settled_os_date ASC";
            return self::execute($sql);
        }

        # Consultar datos de solicitudes diario
        public static function request($data) {
            # Verificar si date_since está definido, de lo contrario, asignar null
            $groupBy = isset($data['groupBy']) ? $data['groupBy'] : 'diary';
            # Segun el tipo de agrupacion indicar el formato de fecha
            if ($groupBy == 'diary') { $formatDate = '%Y-%m-%d'; }
            if ($groupBy == 'monthly') { $formatDate = '%Y-%m'; }
            if ($groupBy == 'annual') { $formatDate = '%Y'; }
            # Verificar si date_since está definido, de lo contrario, asignar null
            $dateSince = isset($data['dateSince']) ? $data['dateSince'] : null;
            # Verificar si date_until está definido, de lo contrario, asignar null
            $dateUntil = isset($data['dateUntil']) ? $data['dateUntil'] : null;
            # Inicializar la consulta SQL
            $sql = "SELECT
                tb_ap_request.os_name as lbl_ap_request_os_name,
                DATE_FORMAT(tb_ap_settled.os_date, '$formatDate') AS lbl_ap_settled_os_date,
                COUNT(*) AS lbl_ap_settled_os_count
            FROM ap_settled tb_ap_settled
            INNER JOIN ap_request tb_ap_request
            ON tb_ap_settled.ap_request = tb_ap_request.id_register
            WHERE tb_ap_settled.os_date BETWEEN '$dateSince' AND '$dateUntil'
            GROUP BY tb_ap_request.id_register, lbl_ap_settled_os_date
            ORDER BY tb_ap_request.id_register ASC, lbl_ap_settled_os_date ASC";
            return self::execute($sql);
        }

        # Consultar datos de pqrs diario
        public static function pqrs($data) {
            # Verificar si date_since está definido, de lo contrario, asignar null
            $groupBy = isset($data['groupBy']) ? $data['groupBy'] : 'diary';
            # Segun el tipo de agrupacion indicar el formato de fecha
            if ($groupBy == 'diary') { $formatDate = '%Y-%m-%d'; }
            if ($groupBy == 'monthly') { $formatDate = '%Y-%m'; }
            if ($groupBy == 'annual') { $formatDate = '%Y'; }
            # Verificar si date_since está definido, de lo contrario, asignar null
            $dateSince = isset($data['dateSince']) ? $data['dateSince'] : null;
            # Verificar si date_until está definido, de lo contrario, asignar null
            $dateUntil = isset($data['dateUntil']) ? $data['dateUntil'] : null;
            # Inicializar la consulta SQL
            $sql = "SELECT
                DATE_FORMAT(tb_ap_settled.os_date, '$formatDate') AS lbl_ap_settled_os_date,
                tb_ap_settled.os_number AS lbl_ap_settled_os_number,
                tb_ap_state.os_name AS lbl_ap_state_os_name
            FROM ap_settled tb_ap_settled
            INNER JOIN ap_state tb_ap_state
            ON tb_ap_settled.ap_state = tb_ap_state.id_register
            WHERE tb_ap_settled.os_date BETWEEN '$dateSince' AND '$dateUntil'
            AND tb_ap_settled.ap_state = 2
            ORDER BY tb_ap_settled.os_date ASC";
            return self::execute($sql);
        }
    }
