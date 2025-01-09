<?php

$dsn = 'mysql:dbname=;host=mysql';
$user = 'root';
$password = 'password';

$defaultOptions = [
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

$pdo = new PDO($dsn, $user, $password, $defaultOptions);

$query = $pdo->query('SHOW VARIABLES like "version"');

$result = $query->fetch();

echo "Database version: " . $result['Value'];

