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
            'ssl_mode' => ($a['scheme'] == 'ftps') ? true : false,
            'debug' => true
        );

            $c = Ftp::forge($b);
        
        $c->change_dir($a['path']);
        
        $c->close()
    }

}

/* end of file auth.php */
