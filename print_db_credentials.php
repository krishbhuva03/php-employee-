<?php
require __DIR__ . '/config/database.php';
$ref = new ReflectionClass('Database');
$props = $ref->getDefaultProperties();
echo "host=".$props['host']."\n";
echo "db_name=".$props['db_name']."\n";
echo "username=".$props['username']."\n";
echo "password=".$props['password']."\n";
