<?php

Class Controller_Pages extends Controller{
    public function action_terms (){
        $view = View::forge('home/base_layout.mustache');
        $view->css = View::forge('home/layout/css');
        $view->meta = View::forge('home/layout/meta');
        $view->js = View::forge('home/layout/js');
        $view->header = View::forge('home/layout/header');
        $view->footer = View::forge('home/layout/footer');
        $view->body = View::forge('home/terms', array(

        ));

        return $view;
    }
}