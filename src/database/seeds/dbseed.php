<?php
require '../../bootstrap.php';

$statement = <<<EOS
    CREATE TABLE IF NOT EXISTS urls (
    id INT NOT NULL AUTO_INCREMENT,
    short_url  VARCHAR(7)       NOT NULL,
    original_url  VARCHAR(400)  NOT NULL,
    user_id   VARCHAR(50)       NOT NULL,
    hits int(11) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
                                           -- INDEX (short_url)
                                           -- INDEX (original_url)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
EOS;

try {
    $createTable = $dbConnection->exec($statement);
    echo "Success!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}