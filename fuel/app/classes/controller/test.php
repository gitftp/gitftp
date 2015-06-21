<?php

class Controller_Test extends Controller {

    public function action_mail(){
//        $sendmail = new Sendmail();
//        $sendmail->send();
        $a = new Model_Deploy();
        print_r($a->get());
    }

    public function action_ac(){
        $a = 'refs/heads/something';
        $a = explode('/', $a);
        print_r($a[count($a)-1]);
    }
    public function get_ab(){
        echo 'asd';

        $record = new Model_Record();
        $record->insert(array(
            'deploy_id'      => '30',
            'record_type'    => $record->type_service,
            'branch_id'      => '57',
            'date'           => time(),
            'status'         => $record->in_queue,
            'triggerby'      => 'Boniface',
            'hash'           => 'cc65d139c1381ef718a60c91efae6525bc98b111',
        ));
    }
    public function action_s(){
        Gfcore::deploy_in_bg('30');
    }
    public function action_log(){
        $a = DB::select()->from('log')->execute()->as_array();
        echo '<pre>';
        foreach($a as $k => $v){
            try{
                $a[$k] = unserialize($v['a']);
            }catch(Exception $e){
                try{
                    $a[$k] = json_decode($v['a']);
                }catch(Exception $e){
                    $a[$k] = $v['a'];
                }
            }
        }
        print_r(array_reverse($a));
        echo '</pre>';
    }
    public function action_g() {
        $email = "hey@craftpip.com";
        $g = utils::get_gravatar($email);
        echo "<img src='$g' />";
    }

    public function action_deploy(){
        $deploy = new Model_Deploy();
        $a = $deploy->get();
        print_r($a);
    }
    
    public function action_testw() {
        echo is_dash;
        echo '<br>';
        echo home_url;
        echo '<br>';
        echo dash_url;
        echo '----';
        echo Auth::check();
    }
    public function action_ab(){
        echo '<pre>';
        $a = utils::gitGetBranches('https://github.com/craftpip/jquery-confirm');
        print_r($a);
    }
    public function action_testo() {
        Auth::login('bonifacepereira@gmail.com', 'thisissparta');
        $a = DB::select()->from('deploy')->execute()->as_array();
        print_r($a);
    }

    public function action_index() {
        echo '<pre>';
        $b = new gitcore();
        $b->action = array('deploy');
        $b->repo = DOCROOT . 'fuel/repository/228/testrepo';
        $b->ftp = array(
            'scheme' => 'ftps',
            'host' => 'craftpip.com',
            'user' => 'craftrzt',
            'pass' => '6?1Hj8I9k8a3',
            'port' => '21',
            'path' => '/testrepo/',
            'passive' => true,
            'skip' => array(),
            'purge' => array()
        );
        $b->revision = '';
        $b = $b->startDeploy();

        print_r($b);
    }

    public function action_test() {

        $gitcore = new gitcore();

        $gitcore->options = array(
            'repo' => DOCROOT . 'fuel/repository/228/49',
            'debug' => true,
            'server' => 'default',
            'ftp' => array(
                'default' => array(
                    'scheme' => 'ftps',
                    'host' => 'craftpip.com',
                    'user' => 'craftrzt',
                    'pass' => '6?1Hj8I9k8a3',
                    'port' => '21',
                    'path' => '/testrepo',
                    'passive' => true,
                    'skip' => array(),
                    'purge' => array(),
                )
            ),
            'revision' => '',
        );

        try {
            $gitcore->startDeploy();
        } catch (Exception $ex) {
            print_r($ex);
        }
        echo '<pre>';
        print_r($gitcore->log);
    }

    public function action_testuser() {
        $a = Auth::get_profile_fields();
        echo print_r($a);
    }

    public function action_loginuser() {
        $a = Auth::login('bonifacepereira@gmail.com', 'thisissparta');
        echo $a;
    }

}
