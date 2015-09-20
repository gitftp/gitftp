<?php

class Controller_Welcome extends Controller_Homepage {

    public function action_index() {
        $view = View::forge('home/base_layout.mustache');
        $view->css = View::forge('home/layout/css');
        $view->js = View::forge('home/layout/js');
        $view->header = View::forge('home/layout/header');
        $view->footer = View::forge('home/layout/footer');
        $view->body = View::forge('home/welcome');
        return $view;
    }

    public function action_404(){
        echo \View::forge('errors/404');
    }

}
