<?php

class Controller_Test extends Controller {
    public function before() {
        echo '<pre>';
    }

    public function get_ab() {
        $record = new Model_Record();
        $record->insert(array(
            'deploy_id'   => '30',
            'record_type' => $record->type_service,
            'branch_id'   => '57',
            'date'        => time(),
            'status'      => $record->in_queue,
            'triggerby'   => 'Boniface',
            'hash'        => '',
        ));

        Gfcore::deploy_in_bg('30');
    }
    public function get_test(){
        $a = DB::select()->from('deploy')->execute()->as_array();
        print_r($a);
    }
    public function get_test2(){
        $files = array(
            'folder/folder2/',
            'folder/folder2/',
            'asda/asdsada/',
            'asda/',
        );

        $merged = array();
        foreach($files as $v){
            foreach($merged as $m){

            }
        }
        print_r($files);
//        echo utils::get_repo_dir(12);
//        die();
//        $a = '/asdsadsa/asd';
//
//        if(substr($a, 0, 1) == '/'){
//            echo substr($a, 1, strlen($a));
//        }

//        -------------------

//        chdir('/var/www/html/fuel/repository/228/39');
//        exec('git branch -r --contains 3071977f63c9aa67e28c98cd95b0dae7b1d1ade0',$a);
//        exec('git branch', $a);
//        print_r($a);
    }
    public function get_a() {
        $a = 'ftp_chdir(): CWD failed. "/asdsad": directory not found';
        $b = explode(': ', $a);
        print_r($b[count($b) - 1]);
    }

    public function get_purge() {
        $ftp = new Model_Ftp();
        $d = $ftp->get(130);
        $d = $d[0];
        $d['user'] = $d['username'];
        $s = http_build_url($d);
        $conn = new \bridge($s);
        $purge = ['images'];
//        $this->purge($purge);
        $origin = $conn->pwd();
        foreach ($purge as $dir) {
            $this->delete($dir, $conn, $origin);
        }
    }

    public function delete($dir, $conn, $o) {
        $list = $conn->ls($o . '/' . $dir);
        foreach ($list as $item) {
            echo $item;
        }
    }
    public function get_e(){
//        echo strtotime('Tue, 21 Aug 2012 19:50:37 +0900');
        echo strtotime('2015-07-23 20:46:36');
    }
    public function get_c(){
//        echo Fuel::$env;
//        echo Crypt::encode('asda', 'randomcode');
//        $response = new Response();
//        $response->set_status(404);
//        echo $response->send();
        throw new Exception('No', 503);
    }
    public function get_dbspeed(){
        $deploy = new Model_Deploy();
        $a = $deploy->get(47, null, true);
        print_r($a);
    }
    public function get_d(){

//        $a = '{"actor": {"display_name": "boniface pereira", "username": "craftpip", "links": {"self": {"href": "https://api.bitbucket.org/2.0/users/craftpip"}, "avatar": {"href": "https:/' ;
//        echo substr($a, 0, 1);
//        $deploy_id
//        utils::gitGetBranches_local($branch_data['deploy_id'], $hash)

        $a = DB::select()->from('log')->where('id', $_GET['id'])->execute()->as_array();
        $a = unserialize($a[0]['a']);
        print_r($a);

    }

    public function get_logs(){
        $a = DB::select()->from('log')->order_by('id', 'desc')->execute()->as_array();
        print_r($a);
    }
}
