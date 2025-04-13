<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once __DIR__ . "/../vendor/autoload.php";

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/../src/Entity'],
    isDevMode: true,
);

$connection = DriverManager::getConnection(
    [
        'driver'   => 'pdo_mysql',
        'user'     => getenv('DB_USER'),
        'password' => file_get_contents(__DIR__ . '/../secrets/db-password.txt'),
        'dbname'   => getenv('DB_NAME'),
        'host' => getenv('DB_HOST'),
    ],
    $config
);

return new EntityManager($connection, $config);
