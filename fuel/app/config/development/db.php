<?php
/**
 * The development database settings. These get merged with the global settings.
 */

return array(
    'default'  => array(
        'connection' => array(
            'dsn'      => 'mysql:host=127.0.0.1;dbname=craftrzt_gitftp',
            'username' => 'root',
            'password' => '',
        ),
    ),
    'frontend' => array(
        'type'         => 'mysqli',
        'connection'   => array(
            'hostname' => '127.0.0.1',
            'port'     => '3306',
            'database' => 'craftrzt_gitftp_frontend',
            'username' => 'root',
            'password' => '',
        ),
        'table_prefix' => '',
    ),
);