<?php
/**
 * The test database settings. These get merged with the global settings.
 *
 * This environment is primarily used by unit tests, to run on a controlled environment.
 */

return array(
    'default' => array(
        'connection' => array(
            'dsn'      => 'mysql:host=craftpip.com;dbname=craftrzt_gitftp',
            'username' => 'craftrzt_gitftp',
            'password' => 's.AmN-V?rXCT',
        ),
    ),
    'frontend' => array(
        'type'         => 'mysqli',
        'connection'   => array(
            'hostname' => 'craftpip.com',
            'port'     => '3306',
            'database' => 'craftrzt_gitftp',
            'username' => 'craftrzt_gitftp',
            'password' => 's.AmN-V?rXCT',
        ),
        'table_prefix' => '',
    ),
);