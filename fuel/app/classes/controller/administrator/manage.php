<?php

class Controller_Administrator_Manage extends Controller_Administrator_Admincheck {
    public function action_index() {
        $projects = [];
        $deploy = new \Model_Deploy();
        $projects = $deploy->select('*', TRUE);
        $s = \Input::get('search', NULL);
        if (!is_null($s)) {
            if (\Input::get('key')) {
                $projects = $projects
                    ->or_where(\Input::get('key'), $s);
            } else {
                $projects = $projects
                    ->or_where('name', 'like', '%' . $s . '%')
                    ->or_where('repository', 'like', '%' . $s . '%')
                    ->or_where('user_id', $s)
                    ->or_where('id', $s)
                    ->or_where('git_name', 'like', '%' . $s . '%');
            }

        }

        $projects = $projects->execute()->as_array();

        echo \View::forge('admin/base_layout', array(
            'data' => \View::forge('admin/manage', array(
                'projects' => $projects
            ), FALSE)
        ), FALSE);
    }

    public function action_env() {
        $branches = [];
        $branch = new \Model_Branch();
        $branches = $branch->select('*', TRUE);
        $s = \Input::get('search', NULL);
        if (!is_null($s)) {
            if (\Input::get('key')) {
                $branches = $branches
                    ->or_where(\Input::get('key'), $s);
            } else {
                $branches = $branches
                    ->or_where('name', 'like', '%' . $s . '%')
                    ->or_where('branch_name', 'like', '%' . $s . '%')
                    ->or_where('ftp_id', $s)
                    ->or_where('id', $s)
                    ->or_where('deploy_id', $s);
            }
        }

        $branches = $branches->execute()->as_array();

        echo \View::forge('admin/base_layout', array(
            'data' => \View::forge('admin/manage', array(
                'branches' => $branches
            ), FALSE)
        ), FALSE);
    }

    public function action_records() {
        $records = [];
        $record = new \Model_Record();
        $records = $record->select('*', TRUE);
        $s = \Input::get('search', NULL);
        if (!is_null($s)) {
            if (\Input::get('key')) {
                $records = $records
                    ->or_where(\Input::get('key'), $s);
            } else {
                $records = $records
                    ->or_where('hash', 'like', '%' . $s . '%')
                    ->or_where('hash_before', 'like', '%' . $s . '%')
                    ->or_where('user_id', $s)
                    ->or_where('deploy_id', $s)
                    ->or_where('id', $s);
            }
        }

        $records = $records->order_by('id', 'DESC')->execute()->as_array();

        echo \View::forge('admin/base_layout', array(
            'data' => \View::forge('admin/manage', array(
                'records' => $records
            ), FALSE)
        ), FALSE);
    }

    public function action_ftp() {
        $ftps = [];
        $ftp = new \Model_Ftp();
        $ftps = $ftp->select('*', TRUE);
        $s = \Input::get('search', NULL);
        if (!is_null($s)) {
            if (\Input::get('key')) {
                $ftps = $ftps
                    ->or_where(\Input::get('key'), $s);
            } else {
                $ftps = $ftps
                    ->or_where('hash', 'like', '%' . $s . '%')
                    ->or_where('hash_before', 'like', '%' . $s . '%')
                    ->or_where('user_id', $s)
                    ->or_where('deploy_id', $s)
                    ->or_where('id', $s);
            }
        }

        $ftps = $ftps->order_by('id', 'DESC')->execute()->as_array();

        echo \View::forge('admin/base_layout', array(
            'data' => \View::forge('admin/manage', array(
                'ftps' => $ftps
            ), FALSE)
        ), FALSE);
    }

    public function get_recordlog() {
        $r = new \Model_Record();
        $data = $r->select('*', TRUE)->where('id', \Input::get('id'))->execute()->as_array();
        if(!count($data))
            throw new \Exception('The record was not found');

        if(\Input::get('raw')){
            $raw = unserialize($data[0]['raw']);
        }else{
            $raw = $data[0]['post_data'];
        }
        echo '<pre>';
        print_r($raw);
        die;
    }

    public function action_ftp_test($ftpID) {
        echo 'Testing ftp id : ' . $ftpID . '<br>';
        $ftp = new \Model_Ftp();
        $data = $ftp->select('*', TRUE)->where('id', $ftpID)->execute()->as_array();
        if (!count($data))
            die('404');

        $data = $data[0];
        $data['user'] = $data['username'];
        $data['pass'] = \Crypt::instance()->decode($data['pass']);
        $data = http_build_url($data);
        echo $data . '<br>';

        try {
            $data = \Utils::test_ftp($data);
            echo 'Succesful';
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
