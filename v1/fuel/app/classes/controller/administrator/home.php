<?php

class Controller_Administrator_Home extends Controller_Administrator_Admincheck {
    public function action_index() {
        echo View::forge('admin/base_layout', array(
            'data' => View::forge('admin/home', array())
        ));
    }
}