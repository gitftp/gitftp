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
        try {
            $c = \Fuel\Core\Ftp::forge($b);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        try {
            $c->change_dir($a['path']);
        } catch (Exception $ex) {
            return 'The directory ' . $a['path'] . ' does not exist in the FTP server.';
        }
        return 'Ftp server is ready to rock.';
        $c->close();
    }

    /**
     * Returns array
     * pushby
     * avatar_url
     * hash
     * post_data
     * commit_count
     * commit_message
     * 
     * @param type $input -> payload.
     * @param type $deploy_id -> deploy to id optional
     */
    public static function parsePayload($input, $deploy_id = null) {

        $i = json_decode($input['payload']);
        
        if(isset($i->canon_url)){
            if(preg_match('', $i->canon_url))
        }
        
        if($service == 'github'){
            $lc = count($i->commits)-1;
            echo '-------------';
            print_r($lc);
            echo '-------------';
            
            return array(
                'pushby' => $i->pusher->name,
                'avatar_url' => $i->sender->avatar_url,
                'hash' => $i->after,
                'post_data' => serialize($i),
                'commit_count' => count($i->commits),
                'commit_message' => $i->commits[$lc]->message
            );
        }
        
        if($service == 'bitbucket'){
            
        }
    }

}

/* end of file auth.php */
