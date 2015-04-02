<?php

class Controller_Welcome extends Controller {

    public function action_index() {
        $a = DB::select()->from('users')->execute()->as_array();
        print_r($a);
    }

    public function action_testmulti() {
        echo 'asdas';
    }

}
