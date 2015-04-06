<?php

class Controller_Test extends Controller {

    public function action_index() {
        echo '<pre>';
        $a = get_class();
        $b = new gitcore();

//        $b = $b->repodeploy('deploy', array(
//            'repo' => DOCROOT . 'fuel/repository/228/testrepo'
//        ));

        $b->action = 'deploy';
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
        
    }

}
