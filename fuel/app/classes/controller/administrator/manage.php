<?php

class Controller_Administrator_Manage extends Controller_Administrator_Admincheck {
    public function action_index() {
        $projects = [];
        $deploy = new \Model_Deploy();
        $projects = $deploy->select('*', TRUE);
        $s = \Input::get('search', NULL);
        if (!is_null($s)) {
            $projects = $projects->or_where('name', 'like', '%' . $s . '%')
                ->or_where('repository', 'like', '%' . $s . '%')
                ->or_where('user_id', $s)
                ->or_where('git_name', 'like', '%' . $s . '%');
        }

        $projects = $projects->execute()->as_array();

        echo \View::forge('admin/base_layout', array(
            'data' => \View::forge('admin/manage', array(
                'projects' => $projects
            ), FALSE)
        ), FALSE);
    }
    public function action_env(){
        $branches = [];
        $branch = new \Model_Branch();
        $branches = $branch->select('*', TRUE);
        $s = \Input::get('search', NULL);
        if (!is_null($s)) {
            $branches = $branches->or_where('name', 'like', '%' . $s . '%')
                ->or_where('repository', 'like', '%' . $s . '%')
                ->or_where('user_id', $s)
                ->or_where('git_name', 'like', '%' . $s . '%');
        }

        $branches = $branches->execute()->as_array();

        echo \View::forge('admin/base_layout', array(
            'data' => \View::forge('admin/manage', array(
                'branches' => $branches
            ), FALSE)
        ), FALSE);
    }
}
