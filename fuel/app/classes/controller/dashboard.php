<?php

class Controller_Dashboard extends Controller {
    
    public function action_index() {
            
        if(!is_dash){
            Response::redirect(home_url);
        }
        if(!Auth::check()){
            
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
