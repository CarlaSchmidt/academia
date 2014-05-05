<?php
return array(
    'db' => array(
        'driver' => 'Pdo',
        'dsn' => 'pgsql:dbname=postgres;host=localhost',
    ),
    'service_manager' => array(
        'factories' => array(
            'AdapterDb'   => 'Zend\Db\Adapter\AdapterServiceFactory', // new \Zend\Db\Adapter\AdapterServiceFactory
        ),
    ),
);
