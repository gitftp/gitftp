<?php

class Controller_Api_Etc extends Controller_Apilogincheck {

    public function action_index() {
        echo 'what ?';
    }

    public function action_dashboard() {
        $deploy = new Model_Deploy();
        $user_id = Auth::get_user_id()[1];

        $dir = DOCROOT . 'fuel/repository/' . $user_id;
        $a = shell_exec("du -hs $dir");
        $a = explode('	', $a);
        $disk_usage_human = $a[0];
        $deploy_list = $deploy->get(NULL, array(
            'repository',
            'id',
            'name',
            'cloned',
        ));

        foreach ($deploy_list as $k => $v) {
            $id = $v['id'];
            $a = shell_exec("du -hs $dir/$id");
            $a = explode('	', $a);
            $deploy_list[$k]['size'] = $a[0];
        }

        echo json_encode(array(
            'status' => TRUE,
            'user'   => array(
                'diskused' => $disk_usage_human,
                'id'       => Auth::get_user_id()[1],
                'name'     => Auth::get_screen_name(),
                'email'    => Auth::get_email(),
                'avatar'   => utils::get_gravatar(Auth::get_email(), 40)
            ),
            'deploy' => $deploy_list,
        ));
    }
}