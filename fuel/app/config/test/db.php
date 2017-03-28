<?php
/**
 * The test database settings. These get merged with the global settings.
 *
 * This environment is primarily used by unit tests, to run on a controlled environment.
 */

return [
    'default' => [
        'type'         => 'mysqli',
        'connection'   => [
            'hostname' => GF_DB_HOST,
            'port'     => '3306',
            'database' => GF_DB_NAME,
            'username' => GF_DB_USERNAME,
            'password' => GF_DB_PASSWORD,
        ],
        'table_prefix' => '',
    ],
];