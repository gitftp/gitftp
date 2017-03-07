<?php

namespace Gf\Git;

use Github\Client;

/**
 * Class Github
 *
 * @package Craftpip\GitApi
 */
class Github implements GitInterface {
    private $instance;
    private $username;

    public function __construct ($username) {
        $this->instance = new Client();
        $this->username = $username;
    }

    public function authenticate ($token) {
        $this->instance->authenticate($token, '', Client::AUTH_HTTP_TOKEN);
    }

    public function getRepositories () {
        $a = $this->instance->api('me')->repositories('all');

        foreach ($a as $repo) {
            $b = [
                'id'        => $repo['id'],
                'name'      => $repo['name'],
                'full_name' => $repo['full_name'],
                'repo_url'  => $repo['html_url'],
                'api_url'   => $repo['url'],
                'clone_url' => $repo['clone_url'],
                'size'      => $repo['size'],
                'provider'  => 'github',
            ];
            $response[] = $b;
        }

        return $response;
    }

    public function getBranches ($repoName) {
        $a = $this->instance->api('repo')->branches($this->username, $repoName);

        $branches = [];
        foreach ($a as $k) {
            $branches[] = $k['name'];
        }

        return $branches;
    }

    public function getHook ($repoName, $id = null) {
        if (is_null($id)) {
            $data = $this->instance->repository()->hooks()->all($this->username, $repoName);

            $response = [];
            foreach ($data as $k) {
                $response[] = [
                    'id'          => $k['id'],
                    'name'        => $k['name'],
                    'events'      => $k['events'],
                    'url'         => $k['config']['url'],
                    'contenttype' => $k['config']['content_type'],
                ];
            }
        } else {
            try {
                $data = $this->instance->repository()->hooks()->show($this->username, $repoName, $id);
                $response = [
                    'id'          => $data['id'],
                    'name'        => $data['name'],
                    'events'      => $data['events'],
                    'url'         => $data['config']['url'],
                    'contenttype' => $data['config']['content_type'],
                ];
            } catch (\Exception $e) {
                return [];
            }
        }

        return $response;
    }

    public function setHook ($repoName, $url) {
        $options = [
            'name'   => 'web',
            'config' => [
                'url'          => $url,
                'content_type' => 'json',
            ],
        ];
        try {
            $data = $this->instance->api('repo')->hooks()->create($this->username, $repoName, $options);
        } catch (\Exception $e) {
            if ($e->getCode() == 422) {
                throw new Exception('Hook already exist on this repository');
            }
        }

        $response = [
            'id'          => $data['id'],
            'name'        => $data['name'],
            'events'      => $data['events'],
            'url'         => $data['config']['url'],
            'contenttype' => $data['config']['content_type'],
        ];

        return $response;
    }

    public function removeHook ($repoName, $id) {
        try {
            $this->instance->api('repo')->hooks()->remove($this->username, $repoName, $id);

            return true;
        } catch (\Exception $e) {
            throw new Exception($id . ' is not a valid hook');
        }
    }

    public function updateHook ($repoName, $id, $url) {
        $options = [
            'name'   => 'web',
            'config' => [
                'url'          => $url,
                'content_type' => 'json',
            ],
        ];

        try {
            $data = $this->instance->repositories()->hooks()->update($this->username, $repoName, $id, $options);
        } catch (\Exception $e) {
            throw new Exception($id . ' is not a valid hook');
        }

        $response = [
            'id'          => $data['id'],
            'name'        => $data['name'],
            'events'      => $data['events'],
            'url'         => $data['config']['url'],
            'contenttype' => $data['config']['content_type'],
        ];

        return $response;
    }
}