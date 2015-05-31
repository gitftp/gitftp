<?php

class Controller_Welcome extends Controller {

    public function action_index() {
        $view = View::forge('layout/base_layout.mustache');
        $view->css = View::forge('layout/css');
        $view->js = View::forge('layout/js');
        $view->header = View::forge('layout/header');
        $view->footer = View::forge('layout/footer');
        $view->body = View::forge('page/home');

        return $view;
    }

    public function action_test() {

        //        Auth::update_user(array(
        //                'email'         => 'bonifacepereira@gmail.com',
        //                // set a new email address
        //                //                'password'     => 'thisissparta2',
        //                //                'old_password' => 'thisissparta',
        //                //                'phone'        => '+1 (555) 123-1212',
        //                'passwordthing' => 'asdas',
        //            ), 'boniface');

        //        print_r(Auth::get_profile_fields());
    }


}
