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

    public function post_changevalue() {
        $name = \Input::post('name');
        $value = \Input::post('value');
        \Cache::delete('settings');
        $a = \Gf\Settings::set($name, $value);

        return $a;
    }

    public function get_delete($name) {
        \Gf\Settings::remove($name);
        \Cache::delete('settings');

        return TRUE;
    }

    public function get_path() {
        $options = \Gf\Path::getAll();
        echo \View::forge('admin/base_layout', array(
            'data' => \View::forge('admin/path', [
                'options' => array_reverse($options)
            ])
        ));
    }

    public function post_addPath() {
        return \Gf\Path::insert(\Input::post('path'));
    }

    public function post_changepath() {
        \Cache::delete('db');

        return \Gf\Path::update(\Input::post('id'), \Input::post('path'));
    }

    public function get_deletepath($id) {
        \Cache::delete('db');

        return \Gf\Path::remove($id);
    }
}
