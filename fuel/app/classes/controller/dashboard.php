<?php

class Controller_Dashboard extends Controller {
    public function action_index() {
        if (!is_dash) {
            throw new HttpNotFoundException;
        }

        if (!\Auth::instance()->check()) {
            $a = substr($_SERVER['REQUEST_URI'], 1);
            Response::redirect(home_url . 'login?ref=' . urlencode(dash_url . $a));
        }

        $view = View::forge('dash/base_layout');
        $view->css = View::forge('dash/css');
        $view->js = View::forge('dash/js');
        $view->header = View::forge('dash/header');
        $view->footer = View::forge('dash/footer');
        $view->body = View::forge('dash/dashboard');

        return $view;
    }
}
