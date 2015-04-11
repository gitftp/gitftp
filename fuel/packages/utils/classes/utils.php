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
            'timeout' => 30,
            'port' => $a['port'],
            'passive' => true,
            'ssl_mode' => ($a['scheme'] == 'ftps') ? true : false,
            'debug' => true
        );
        try{
            $c = \Fuel\Core\Ftp::forge($b);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        try{
            $c->change_dir($a['path']);
        } catch (Exception $ex) {
            return 'The directory '.$a['path'].' does not exist in the FTP server.';
        }
        return 'Ftp server is ready to rock.';
        $c->close();
    }

}

/* end of file auth.php */
