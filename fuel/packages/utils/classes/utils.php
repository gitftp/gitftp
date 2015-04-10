<?php

class utils {

    public static function test_ftp($a = array()) {

        $c = Ftp::forge(array(
            'hostname' => 'fuelphp.com',
            'username' => '',
            'password' => '',
            'timeout' => 90,
            'port' => 21,
            'passive' => true,
            'ssl_mode' => false,
            'debug' => false
        ));

    }

}

/* end of file auth.php */
