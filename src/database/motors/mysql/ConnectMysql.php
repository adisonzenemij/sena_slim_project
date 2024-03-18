<?php
    namespace MyApp\Database\Motors\MySql;

    use PDO;
    
    class ConnectMysql {
        protected static function connection() {
            try {
                $dsn = 'mysql:host=' . $_ENV['MYSQL_HOST'] . ';';
                $dsn .= 'dbname=' . $_ENV['MYSQL_NAME'] . ';';
                $dsn .= 'port=' . $_ENV['MYSQL_PORT'];
                $link = new PDO($dsn, $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASS']);
                $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $link->exec('SET NAMES UTF8');
                return $link;
            } catch (PDOException $exception) {
                die('Error: Conexión Fallida BD: ' . $exception->getMessage());
            }
            # Retornar null en caso de error
            return null;
        }

        protected static function execute($sql) {
            try {
                $link = ConnectMysql::connection();
                $stmt = $link->prepare($sql);
                $stmt->execute();
            } catch (PDOException $exception) {
                return $exception;
            }
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        }

        protected static function excBindVal($sql, $params) {
            try {
                $link = ConnectMysql::connection();
                $stmt = $link->prepare($sql);
                // Enlazar los parámetros y sus valores
                foreach ($params as $param => $value) {
                    $stmt->bindValue($param, $value);
                }
                $stmt->execute();
            } catch (PDOException $exception) {
                return $exception;
            }
            // Retornar los resultados como array asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        protected static function insertBindVal($sql, $params) {
            try {
                $link = ConnectMysql::connection();
                $stmt = $link->prepare($sql);
                // Enlazar los parámetros y sus valores
                foreach ($params as $param) {
                    $stmt->bindValue(key($param), current($param), PDO::PARAM_STR);
                }
                $stmt->execute();
            } catch (PDOException $exception) {
                return false;
            }
            return $stmt; // Devolver el objeto $stmt
        }

        public static function bindings($sql, $paramValues) {
            $stmt = self::connection()->prepare($sql);
            foreach ($paramValues as $paramName => $paramValue) {
                $stmt->bindValue($paramName, $paramValue, PDO::PARAM_STR);
            }
            if ($stmt->execute()) {
                return $stmt;
            } else {
                return false;
            }
        }
        
        public static function delete($sql) {
            try {
                $link = ConnectMysql::connection();
                $stmt = $link->prepare($sql);
                $stmt->execute();
                return $stmt->rowCount();
            } catch (PDOException $exception) {
                return $exception;
            }
        }
        
        public static function getErrorMessage() {
            $link = self::connection();
            return $link->errorInfo()[2];
        }
    }
