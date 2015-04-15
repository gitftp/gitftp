<?php

class Controller_Login extends Controller {
    
    public function action_index() {
            
        if(!Auth::check() or !is_dash){
            Response::redirect(home_url);
        }
        
        $view = View::forge('layout/base_layout.mustache');
        $view->css = View::forge('layout/css');
        $view->js = View::forge('layout/js');
        $view->header = View::forge('layout/header');
        $view->footer = View::forge('layout/footer');
        $view->body = View::forge('page/dashboard');
        return $view;
    }

}
