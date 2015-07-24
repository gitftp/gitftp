<?php

class Controller_Dashboard extends Controller {
    public function action_index() {
        if (!is_dash) {
            throw new HttpNotFoundException;
        }
        if (!\Auth::instance()->check()) {
            Response::redirect(home_url . 'login#');
        }

        $view = View::forge('dash/base_layout.mustache');
        $view->css = View::forge('dash/css');
        $view->js = View::forge('dash/js');
        $view->header = View::forge('dash/header');
        $view->footer = View::forge('dash/footer');
        $view->body = View::forge('dash/dashboard');
        return $view;
    }
}
