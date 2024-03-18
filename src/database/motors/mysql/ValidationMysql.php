<?php
    namespace MyApp\Database\Motors\MySql;

    use MyApp\Database\Motors\MySql\ConnectMysql;
    
    class ValidationMysql extends ConnectMysql {
        # Consultar tablas de la base de datos
        public static function list() {
            $sql = "SHOW TABLES FROM" . ' ' . $_ENV['MYSQL_NAME'];
            return self::execute($sql);
        }

        # Consultar existencia de una tabla
        public static function table($data) {
            $dtTable = $data['table'];
            $sql = "SELECT * FROM information_schema.tables
                WHERE table_schema = '" . $_ENV['MYSQL_NAME'] . "'
                AND table_name = '$dtTable'";
            return self::execute($sql);
        }

        # Consultar existencia de una columna en una tabla
        public static function column($data) {
            $dtTable = $data['table'];
            $dtColumn = $data['column'];
            
            // Inicializar la consulta SQL
            $sql = "SELECT * FROM information_schema.columns
                WHERE table_schema = '" . $_ENV['MYSQL_NAME'] . "'
                AND table_name = '$dtTable'";
            
            // Si la variable no es '*', agregar la condición
            if ($dtColumn !== '*') { $sql .= " AND column_name = '$dtColumn'"; }
            
            return self::execute($sql);
        }

        # Consultar existencia de una columna en una tabla
        public static function whereField($data) {
            $dtTable = $data['table'];
            $dtWhereField = $data['whereField'];
            
            // Inicializar la consulta SQL
            $sql = "SELECT * FROM information_schema.columns
                WHERE table_schema = '" . $_ENV['MYSQL_NAME'] . "'
                AND table_name = '$dtTable'";
            
            // Si la variable no es '*', agregar la condición
            if ($dtWhereField !== '*') { $sql .= " AND column_name = '$dtWhereField'"; }
            
            return self::execute($sql);
        }

        # Consultar existencia de una tabla
        public static function htmlSelect($data) {
            $dtTable = $data['htmlSelect'];
            $sql = "SELECT * FROM information_schema.tables
                WHERE table_schema = '" . $_ENV['MYSQL_NAME'] . "'
                AND table_name = '$dtTable'";
            return self::execute($sql);
        }

        public static function modulePrefix($data) {
            $dtTable = $data['table'];
            $partsTable = explode('_', $dtTable);
            $tablePrefix = $partsTable[0];
            $tableName = $partsTable[1];

            /* Parte 1 */
            $sqlPrefix = "
                SELECT * FROM `sy_prefix`
                WHERE `os_prefix` = '$tablePrefix'
            ";
            $resPrefix = self::execute($sqlPrefix);

            $syPrefixIdRegister = 0;
            if ($resPrefix) { foreach ($resPrefix as $row) { $syPrefixIdRegister = $row->id_register; } }

            /* Parte 2 */
            $sqlModule = "
                SELECT * FROM `sy_module`
                WHERE `os_table` = '$tableName'
                AND `sy_prefix` = '$syPrefixIdRegister'
            ";
            $resModule = self::execute($sqlModule);
            
            $syModuleIdRegister = 0;
            if ($resModule) { foreach ($resModule as $row) { $syModuleIdRegister = $row->id_register; } }
            return $syModuleIdRegister;
        }

    }
