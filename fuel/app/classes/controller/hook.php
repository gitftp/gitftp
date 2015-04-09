<?php

class Controller_Hook extends Controller {

    public function action_index() {
        $view = View::forge('layout/base_layout.mustache');
        $view->css = View::forge('layout/css');
        $view->js = View::forge('layout/js');
        $view->header = View::forge('layout/header');
        $view->footer = View::forge('layout/footer');
        $view->body = View::forge('page/home');
        return $view;
    }
    
    public function action_test(){
        Debug::constants();
    }
}
