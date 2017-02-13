<?php

class Controller_Setup_Start extends Controller_Hybrid {
    public $template = 'base_layout';

    public function get_index () {
        if (GF_CONFIG_FILE_EXISTS) {
            echo 'You\'ve already done the setup';
            die;
        }

        $this->template->body = \Fuel\Core\View::forge('setup/start');
        $this->template->title = "Setup";
        $this->template->js = \Fuel\Core\View::forge('js');
        $this->template->css = \Fuel\Core\View::forge('css');
    }
}
