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

    public function get_c(){
        echo Fuel::$env;
        echo Crypt::encode('asda', 'randomcode');

    }

    public function get_d(){
//        $deploy_id
//        utils::gitGetBranches_local($branch_data['deploy_id'], $hash)
    }
}
