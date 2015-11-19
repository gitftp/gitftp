<?php

class Controller_Administrator_Settings extends Controller_Administrator_Admincheck {
    public function action_index() {
        $options = \Gf\Settings::getAll();
        echo \View::forge('admin/base_layout', array(
            'data' => \View::forge('admin/settings', [
                'options' => array_reverse($options)
            ])
        ));
    }
    public function post_changevalue(){
        $name = \Input::post('name');
        $value = \Input::post('value');
        return \Gf\Settings::set($name, $value);
    }
    public function get_delete($name){
        \Gf\Settings::remove($name);
        return true;
    }
}
