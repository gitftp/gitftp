<?php

use Gf\Auth\Auth;
use Gf\Auth\OAuth;

class Controller_Init extends Controller {
    public function get_index () {
        $isReady = \Gf\Config::instance()->get('ready', false);
        if (!$isReady or !GF_CONFIG_FILE_EXISTS)
            Response::redirect('setup');

        if (!$user_id = Auth::instance()->user_id) {
            \Fuel\Core\Response::redirect('login');
        } else {
            $user = Auth::instance()->user;
            $user = \Gf\Auth\Users::instance()->parse($user);
            $apiUrl = \Fuel\Core\Uri::base() . 'console/api/';
            $githubCallbackUrl = OAuth::getCallbackUrl(OAuth::provider_github);
            $bitbucketCallbackUrl = OAuth::getCallbackUrl(OAuth::provider_bitbucket);
            $availableProviders = OAuth::getAvailableProviders();
            $readyProviders = OAuth::getReadyProviders($user_id);

            $projects = \Gf\Project::get([
                'owner_id' => $user_id,
            ], [
                'id',
                'name',
                'uri',
                'git_name',
                'created_at',
                'provider',
                'clone_state',
                'status',
            ]);
            if (!$projects)
                $projects = [];

            $projects_object = [];
            foreach ($projects as $project) {
                $servers = \Gf\Server::get([
                    'project_id' => $project['id'],
                ], [
                    'id',
                    'name',
                    'branch',
                    'type',
                    'auto_deploy',
                ]);
                if (!$servers)
                    $servers = [];

                $project['servers'] = $servers;
                $projects_object[$project['id']] = $project;
            }


            return \Fuel\Core\View::forge('panel/base_layout', [
                'js'                 => \Fuel\Core\View::forge('js'),
                'css'                => \Fuel\Core\View::forge('css'),
                'user'               => $user,
                'apiUrl'             => $apiUrl,
                'githubCallback'     => $githubCallbackUrl,
                'bitbucketCallback'  => $bitbucketCallbackUrl,
                'availableProviders' => $availableProviders,
                'readyProviders'     => $readyProviders,
                'projects'           => $projects_object,
            ]);
        }
    }
}
