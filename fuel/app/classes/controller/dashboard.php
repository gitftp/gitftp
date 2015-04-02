<?php

class Controller_Dashboard extends Controller {

    public function action_index() {
        $view = View::forge('layout/base_layout.mustache');
        $view->css = View::forge('layout/css');
        $view->js = View::forge('layout/js');
        $view->header = View::forge('layout/header');
        $view->footer = View::forge('layout/footer');
        $view->body = View::forge('page/dashboard');
        return $view;
    }

    public function action_ftp($arg = null) {
        $view = View::forge('layout/base_layout.mustache');
        $view->css = View::forge('layout/css');
        $view->js = View::forge('layout/js');
        $view->header = View::forge('layout/header');
        $view->footer = View::forge('layout/footer');

        if ($arg == null) {
            $ftp = DB::select()->from('ftpdata')->where('user_id', Auth::get_user_id()[1])->execute()->as_array();
            $bodyview = View::forge('page/dashboard_ftp');
            $bodyview->ftp = $ftp;
            $view->body = $bodyview;
            return $view;
        }
        if($arg == 'add'){
            
//            $ftp = DB::select()->from('ftpdata')->where('user_id', Auth::get_user_id()[1])->execute()->as_array();
            $bodyview = View::forge('page/dashboard_ftp_add');
//            $bodyview->ftp = $ftp;
            $view->body = $bodyview;
            return $view;
            
        }
    }

    public function action_git() {
        $view = View::forge('layout/base_layout.mustache');
        $view->css = View::forge('layout/css');
        $view->js = View::forge('layout/js');
        $view->header = View::forge('layout/header');
        $view->footer = View::forge('layout/footer');
        $view->body = View::forge('page/dashboard_git');
        return $view;
    }

}
