<?php

class Controller_Test extends Controller {

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

//        exec(sprintf("%s > %s 2>&1 & echo $! >> %s", 'git status', 'asd.txt', 'pid.txt'));
        bg::init();
    }

}
