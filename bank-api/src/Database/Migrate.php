<?php

require __DIR__.'/../../vendor/autoload.php';

use App\Database\Connection;

$pdo = Connection::get();

$migrationsPath = __DIR__.'/Migrations';
$files = scandir($migrationsPath);

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
        $sql = require $migrationsPath.'/'.$file;
        $pdo->exec($sql);

        echo "Migration executed: ".$file."\n";
    }
}

echo "Migrations finished \n";