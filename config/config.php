<?php

return [
    'db_dsn' => 'mysql:host=mysql-20146c17-ka-jak-ford-ka.c.aivencloud.com;port=21296;dbname=defaultdb;charset=utf8',
    'db_user' => 'avnadmin',
    'db_pass' => 'AVNS_oZzdY04opCD4slZ6RPY',
    'db_options' => [
        PDO::MYSQL_ATTR_SSL_CA => __DIR__ . '/../ca.pem',
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ],
];