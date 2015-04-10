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
        
        try{
            $c = Ftp::forge($b);
        } catch (Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

    }

}

/* end of file auth.php */
