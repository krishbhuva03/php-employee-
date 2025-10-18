<?php
require __DIR__ . '/config/database.php';
try {
    if (!isset($db) || !$db) {
        echo "NO_DB_VARIABLE\n";
        exit(1);
    }
    $driver = $db->getAttribute(PDO::ATTR_DRIVER_NAME);
    echo "DRIVER:" . $driver . "\n";
    if ($driver === 'sqlite') {
        echo "Using SQLite fallback. DB file should be in project root (employees.db)\n";
        $count = $db->query('SELECT COUNT(*) FROM employees')->fetchColumn();
        echo "Employees count: $count\n";
    } else if ($driver === 'mysql') {
        // Show current database name
        $dbName = $db->query('select database()')->fetchColumn();
        echo "MySQL connected to database: $dbName\n";
        $count = $db->query('SELECT COUNT(*) FROM employees')->fetchColumn();
        echo "Employees count: $count\n";
    }
} catch (Exception $e) {
    echo "ERROR:" . $e->getMessage() . "\n";
}
