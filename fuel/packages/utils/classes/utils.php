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
        
        $service = 'none';
        
        
        if(isset($i->canon_url)){
            if(preg_match('/bitbucket/i', $i->canon_url)){
                $service = 'bitbucket';
            }
        }
        
        if(isset($i->repository)){
            if(isset($i->repository->url)){
                if(preg_match('/github/i', $i->repository->url)){
                    $service = 'github';
                }
            }
        }
                
        DB::insert('test')->set(array(
            'test'=> $service
        ))->execute();
        
        if($service == 'github'){
            $lc = count($i->commits)-1;
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
            $lc = count($i->commits)-1;
            return array(
                'pushby' => $i->commits[$lc]->author,
                'avatar_url' => '',
                'hash' => $i->commits[$lc]->raw_node,
                'post_data' => serialize($i),
                'commit_count' => count($i->commits),
                'commit_message' => $i->commits[$lc]->message
            );
        }
    }
    
    public static humanize_data($data){
        
        $bytes = $data;
        $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' );
        $base = 1024;
        $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
        echo sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class] . '<br />';
    }

}

/* end of file auth.php */
