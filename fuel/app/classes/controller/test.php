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

        $gitcore = new gitcore();
        
        $gitcore->options = array(
            'repo' => DOCROOT.'fuel/repository/228/49',
            'debug' => true,
            'server' => 'default',
            'ftp' => array(
                'scheme' => 'ftps',
                'host' => 'craftpip.com',
                'user' => 'craftrzt',
                'pass' => '6?1Hj8I9k8a3',
                'port' => '$asda',
                'path' => '/testrepo',
                'passive' => true,
                'skip' => array(),
                'purge' => array()
            ),
            'revision' => '',
        );

        try {
            $gitcore->startDeploy();
        } catch (Exception $ex) {

            array_push($log, $gitcore->log);
            $record->set($record_id, array(
                'raw' => serialize($log),
                'status' => 0,
            ));
            return;
        }
    }

}
