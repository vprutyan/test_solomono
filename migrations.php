<?php

// DB init logic
$sqlFiles = [
   'products_categories'
];

foreach ($sqlFiles as $sqlFileName) {
    $initFile = __DIR__ . '/init/db_initialized_' . $sqlFileName . '.txt';
    $sqlFile = __DIR__ . '/migrations/' . $sqlFileName . '.sql';
    if (!file_exists($initFile) && file_exists($sqlFile)) {
        $pdo = DB::getInstance()->getConnection();
        $sql = file_get_contents($sqlFile);
        $pdo->exec($sql);
        file_put_contents($initFile, 'initialized on ' . date('Y-m-d H:i:s'));
    }
}
