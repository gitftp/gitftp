<?php

class Controller_Administrator_Docs extends Controller_Administrator_Admincheck {
    public function get_index($type = 'documentation') {
        $data = \DB::select()->from('pages')->where('type', $type)->execute('frontend')->as_array();
        echo \View::forge('admin/base_layout', array(
            'data' => \View::forge('admin/docs', array(
                'pages' => $data
            ), FALSE)
        ), FALSE);
    }

    public function post_index($type = NULL) {
        $data = Input::post();
        $a = \DB::update('pages')->set($data)->where('id', $data['id'])->execute('frontend');
        echo json_encode($a);
    }

    public function get_new() {
        echo \View::forge('admin/base_layout', array(
            'data' => \View::forge('admin/docs/new', array(), FALSE)
        ), FALSE);
    }

    public function post_new() {
        $data = Input::post();
        $data['created_at'] = time();
        $res = \DB::insert('pages')->set($data)->execute('frontend');
        echo json_encode([
            'id' => $res[0]
        ]);
    }

    public function get_edit($id = NULL) {
        $page = \DB::select()->from('pages')->where('id', $id)->execute('frontend')->as_array();
        if (count($page) == 0)
            die('The page doesnt exist.');

        $page = $page[0];
        echo \View::forge('admin/base_layout', array(
            'data' => \View::forge('admin/docs/new', array(
                'page' => $page
            ), FALSE)
        ), FALSE);
    }

    public function post_edit($id) {
        $data = Input::post();
        $data['published'] = \Input::post('published', 0);
        $res = \DB::update('pages')->set($data)->where('id', $data['id'])->execute('frontend');
        echo json_encode([
            'status' => $res
        ]);
    }
}
