<?php

class Controller_Administrator_Log extends Controller_Administrator_Admincheck {
    public function action_index() {
        $logs = [];
        $file = '';

        if (\Input::get('file', NULL)) {
            $dir = DOCROOT . 'fuel/app/logs/' . \Input::get('file');
            $file = (String)\Fuel\Core\File::read($dir, TRUE);

//            $file = \Fuel\Core\Security::strip_tags($file);
            $file = str_replace("\n", "<br>", $file);
            $file = str_replace("\r", "<br>", $file);

        } else {
            $dir = \File::read_dir(DOCROOT . 'fuel/app/logs');
            $logs = \Arr::flatten_assoc($dir, '');
        }

        echo \View::forge('admin/base_layout', array(
            'data' => \View::forge('admin/log', array(
                'log'   => $logs,
                'files' => (String)$file
            ), false)
        ), false);
    }
}
