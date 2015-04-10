<?php

class utils {

    public static function test_ftp($a = array()) {
//        Array
//(
//    [host] => 
//    [username] => 
//    [pass] => 
//    [scheme] => 
//    [path] => 
//    [port] => 
//)
        
        $b = array(
            'hostname' => $a['host'],
            'username' => $a['username'],
            'password' => $a['pass'],
            'timeout' => 120,
            'port' => $a['port'],
            'passive' => true,
            'ssl_mode' => $a[''],
            'debug' => false
        );
        $c = Ftp::forge(array(
            'hostname' => 'fuelphp.com',
            'username' => '',
            'password' => '',
            'timeout' => 120,
            'port' => 21,
            'passive' => true,
            'ssl_mode' => false,
            'debug' => false
        ));

    }

}

/* end of file auth.php */
