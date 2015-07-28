<?php

namespace Craftpip\GitApi;

use Github\Client;


/**
 * Class Github
 * @package Craftpip\GitApi
 */
class Github implements GitApiInterface {
    private $instance;
    private $username;

    public function __construct($username) {
        $this->instance = new Client();
        $this->username = $username;
    }

    public function authenticate($token) {
        $this->instance->authenticate($token, '', Client::AUTH_HTTP_TOKEN);
    }

    public function getRepositories() {
        $a = $this->instance->api('user')->repositories($this->username);
        $response = array();

        foreach ($a as $repo) {
            $b = array(
                'id'        => $repo['id'],
                'name'      => $repo['name'],
                'full_name' => $repo['full_name'],
                'repo_url'  => $repo['html_url'],
                'api_url'   => $repo['url'],
                'clone_url' => $repo['clone_url'],
                'size'      => $repo['size'],
                'provider'  => 'github',
            );
            $response[] = $b;
        }

        return $response;
    }

}