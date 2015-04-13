<?php

/**
 * The production database settings. These get merged with the global settings.
 */
return array(
    'default' => array(
        'connection' => array(
            'dsn' => 'mysql:host=http://ec2-54-149-18-148.us-west-2.compute.amazonaws.com/;dbname=gitftp',
            'username' => 'gitftp',
            'password' => 'thisissparta',
        ),
    ),
);
