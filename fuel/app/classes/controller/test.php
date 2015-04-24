<?php

class Controller_Test extends Controller {
    
    public function action_mail(){
        
        $sendmail = new Sendmail();
        $sendmail->send(array(
            
        ));
        
    }
    public function action_g() {
        $email = "hey@craftpip.com";
        $g = utils::get_gravatar($email);
        echo "<img src='$g' />";
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
