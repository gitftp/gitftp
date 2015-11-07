<?php

class Controller_Administrator_Seo extends Controller_Administrator_Admincheck {
    public function get_index() {
        $seo_list = [];

        $seo = new Model_Seo();
        if (\Input::get('search')) {
            $seo_list = $seo->select('*')
                ->where('path', 'like', '%' . \Input::get('search') . '%')
                ->or_where('data', 'like', '%' . \Input::get('search') . '%')
                ->execute($seo->db)
                ->as_array();

            foreach ($seo_list as $k => $k2) {
                $seo_list[$k]['data'] = unserialize($k2['data']);
            }

        } else {
            $seo_list = $seo->getAll();
        }

        echo \View::forge('admin/base_layout', array(
            'data' => \View::forge('admin/seo', array(
                'list' => $seo_list
            ), FALSE)
        ), FALSE);
    }

    public function post_index() {
        $data = \Input::post();
        $seo = new \Model_Seo();
        $data = $seo->getById($data['id']);

        $name = \Input::post('name', NULL);
        $val = \Input::post('val', NULL);

        if($name == 'path'){
            $data['path'] = $val;
        }else{
            $data['data'][$name] = $val;
        }

        $seo->update(\Input::post('id'), $data['path'], $data['data']);
    }

    public function get_create() {
        echo \View::forge('admin/base_layout', array(
            'data' => \View::forge('admin/seo_create', array(), FALSE)
        ), FALSE);
    }

    public function get_delete($id) {
        $seo = new \Model_Seo();
        $seo->delete($id);
        \Response::redirect('administrator/seo');
    }

    public function get_edit($id) {
        $seo = new \Model_Seo();
        $data = $seo->getById($id);

        if (!$data)
            die('404');

        echo \View::forge('admin/base_layout', array(
            'data' => \View::forge('admin/seo_create', array(
                'list' => $data
            ), FALSE)
        ), FALSE);
    }

    public function post_create() {
        $seo = new \Model_Seo();
        if (!\Input::post('path') || !\Input::post('content'))
            \Fuel\Core\Response::redirect_back();

        if (\Input::post('id')) {
            $seo->update(\Input::post('id'), \Input::post('path'), \Input::post('content'));
            $af = 1;
        } else {
            list($id, $af) = $seo->insert(\Input::post('path'), \Input::post('content'));
        }
        if ($af == 0)
            throw new \Craftpip\Exception('Could not create');

        \Response::redirect('administrator/seo');
    }
}
