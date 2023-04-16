<?php

use Github\Client;

class Github implements GitProviderInterface {
    /**
     * @var Client
     */
    private $instance;
    private $username;

    public function __construct($username) {
        $this->instance = new Client();
        $this->username = $username;
    }

    public function getInstance() {
        return $this->instance;
    }

    public function authenticate($token) {
        $this->instance->authenticate($token, '', \Github\AuthMethod::ACCESS_TOKEN);
    }


    public function getRepositories() {
        $a = $this->instance->api('user')
                            ->repositories($this->username);
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

    public function getBranches($repoName, $username = null) {
        $a = $this->instance->api('repo')
                            ->branches($this->username, $repoName);

        $branches = array();
        foreach ($a as $k) {
            $branches[] = $k['name'];
        }

        return $branches;
    }


    public function getHook($repoName, $id = NULL) {
        if (is_null($id)) {
            $data = $this->instance->repository()
                                   ->hooks()
                                   ->all($this->username, $repoName);

            $response = array();
            foreach ($data as $k) {
                $response[] = array(
                    'id'          => $k['id'],
                    'name'        => $k['name'],
                    'events'      => $k['events'],
                    'url'         => $k['config']['url'],
                    'contenttype' => $k['config']['content_type'],
                );
            }
        }
        else {
            try {
                $data = $this->instance->repository()
                                       ->hooks()
                                       ->show($this->username, $repoName, $id);
                $response = array(
                    'id'          => $data['id'],
                    'name'        => $data['name'],
                    'events'      => $data['events'],
                    'url'         => $data['config']['url'],
                    'contenttype' => $data['config']['content_type'],
                );
            } catch (\Exception $e) {
                return array();
            }
        }

        return $response;
    }


    public function setHook($repoName, $url, $other = null) {
        $options = array(
            'name'   => 'web',
            'config' => array(
                'url'          => $url,
                'content_type' => 'json',
            ),
        );
        try {
            $data = $this->instance->api('repo')
                                   ->hooks()
                                   ->create($this->username, $repoName, $options);
        } catch (\Exception $e) {
            if ($e->getCode() == 422) {
                throw new Exception('Hook already exist on this repository');
            }
        }

        $response = array(
            'id'          => $data['id'],
            'name'        => $data['name'],
            'events'      => $data['events'],
            'url'         => $data['config']['url'],
            'contenttype' => $data['config']['content_type'],
        );

        return $response;
    }

    public function removeHook($repoName, $id) {
        try {
            $this->instance->api('repo')
                           ->hooks()
                           ->remove($this->username, $repoName, $id);

            return TRUE;
        } catch (\Exception $e) {
            throw new Exception($id . ' is not a valid hook');
        }
    }

    public function updateHook($repoName, $id, $url) {
        $options = array(
            'name'   => 'web',
            'config' => array(
                'url'          => $url,
                'content_type' => 'json',
            ),
        );

        try {
            $data = $this->instance->repositories()
                                   ->hooks()
                                   ->update($this->username, $repoName, $id, $options);
        } catch (\Exception $e) {
            throw new Exception($id . ' is not a valid hook');
        }

        $response = array(
            'id'          => $data['id'],
            'name'        => $data['name'],
            'events'      => $data['events'],
            'url'         => $data['config']['url'],
            'contenttype' => $data['config']['content_type'],
        );

        return $response;
    }

    function commits($repoName, $branch = null, $username = null): array {
        if (is_null($username))
            $username = $this->username;

        $options = [];
        if (!is_null($branch)) {
            //            [
            //                'sha' => $branch,
            //            ]
            $options['sha'] = $branch;
        }
        $commits = $this->instance->repository()
                                  ->commits()
                                  ->all($username, $repoName, $options);

        $revisions = [];

        foreach ($commits as $item) {
            $revisions[] = [
                'sha'           => $item['sha'],
                'message'       => $item['commit']['message'],
                'author_avatar' => $item['author']['avatar_url'],
                'author'        => $item['author']['login'],
                'time'          => \App\Models\Helper::getDateTimeFromTime($item['commit']['author']['date']),
            ];
        }

        return $revisions;
    }


}
