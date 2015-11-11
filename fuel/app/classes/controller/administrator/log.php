<?php

class Controller_Administrator_Log extends Controller_Administrator_Admincheck {
    public function action_index() {
        $logs = [];
        $file = '';

        if (\Input::get('file', NULL)) {
            $dir = DOCROOT . 'fuel/app/logs/' . \Input::get('file');
            $file = (String)\Fuel\Core\File::read($dir, TRUE);
            $file = str_replace("\n", "<br>", $file);
            $file = explode('<br>', $file);
            if (\Input::get('rev', 0)) {
                $file = array_reverse($file);
            }
        } else {
            $dir = \File::read_dir(DOCROOT . 'fuel/app/logs');
            $logs = \Arr::flatten_assoc($dir, '');
        }
        echo \View::forge('admin/base_layout', array(
            'data' => \View::forge('admin/log', array(
                'log'   => $logs,
                'files' => $file
            ), FALSE)
        ), FALSE);
    }
}
