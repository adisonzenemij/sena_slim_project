-- Borrar tabla de la base de datos
DROP TABLE IF EXISTS api;

-- Creat tabla en la base de datos
CREATE TABLE IF NOT EXISTS api (
    `id` BIGINT(255) NOT NULL AUTO_INCREMENT COMMENT 'Id',
    `test` VARCHAR(250) COMMENT 'Test',
    PRIMARY KEY (`id`)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Agregar un índice de PRIMARY KEY a la columna
-- ALTER TABLE api ADD PRIMARY KEY (`id`);

-- Agregar índice a la columna
ALTER TABLE api ADD INDEX idx_id (`id`);
ALTER TABLE api ADD INDEX idx_test (`test`);
