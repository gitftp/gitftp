<?php

class Controller_Administrator_Feedback extends Controller_Administrator_Admincheck {
    public function action_index() {
        $messages = new Model_Messages();
        $feedback = $messages->get(NULL, $messages->type_feedback, TRUE, 'DESC');
        $user = new \Craftpip\OAuth\Auth();

        foreach ($feedback as $k => $f) {
            $user->setId($f['user_id']);
            $username = $user->getProperty('username');
            $feedback[$k]['username'] = $username;
        }

        echo View::forge('admin/base_layout', array(
            'data' => View::forge('admin/feedback', array(
                'feedback' => $feedback
            ))
        ));
    }

    public function get_page(){
        $messages = new Model_Messages();
        $feedback = $messages->get(NULL, $messages->type_pagefeedback, TRUE, 'DESC');
        $user = new \Craftpip\OAuth\Auth();

        foreach ($feedback as $k => $f) {
            if($f['user_id'] != 0){
                $user->setId($f['user_id']);
                $username = $user->getProperty('username');
                $feedback[$k]['username'] = $username;
            }
        }

        echo View::forge('admin/base_layout', array(
            'data' => View::forge('admin/pagefeedback', array(
                'feedback' => $feedback
            ))
        ));
    }

    public function get_delete($id) {
        $messages = new Model_Messages();
        $messages->delete($id, TRUE);

        echo 'OK';
    }
}