<?php

Class Controller_home_api extends Controller {
    public function post_pagefeedback() {
        $messages = new \Model_Messages();
        $messages->insert(array(
            'type'    => $messages->type_pagefeedback,
            'message' => \Input::post('message', '-No message-'),
            'extras'  => array(
                'page_id'      => \Input::post('pageid'),
                'page_helpful' => \Input::post('type') == 0 ? 'No' : 'Yes'
            )
        ));
        echo json_encode(array(
            'status' => TRUE
        ));
    }
}