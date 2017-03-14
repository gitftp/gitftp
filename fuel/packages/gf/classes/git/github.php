<?php

namespace Gf\Git;

use Gf\Auth\OAuth;
use Gf\Exception\AppException;
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

    public function getRepository ($username, $repoName) {
        $data = $this->instance->api('repo')->show($username, $repoName);
        $repository = [];
        $repository['id'] = $data['id'];
        $repository['name'] = $data['name'];
        $repository['full_name'] = $data['full_name'];
        $repository['repo_url'] = $data['html_url'];
        $repository['api_url'] = $data['url'];
        $repository['clone_url'] = $data['clone_url'];
        $repository['private'] = $data['private'];
        $repository['size'] = $data['size'] * 1000;
        $repository['provider'] = OAuth::provider_github;

        return $repository;
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
                'private'   => $repo['private'],
                'size'      => $repo['size'] * 1000, // size is given in KB, convert to bytes.
                'provider'  => OAuth::provider_github,
            ];
            $response[] = $b;
        }

        return $response;
    }

    /**
     * @param      $repoName
     * @param null $username -> this will default to the current user,
     *                       but if an organization repository is to be accessed
     *                       pass in the username of the organization
     *
     * @return array
     */
    public function getBranches ($repoName, $username = null) {
        if (is_null($username))
            $username = $this->username;

        $a = $this->instance->api('repo')->branches($username, $repoName);

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

    public function setHook ($repoName, $username, $url) {
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
            throw new AppException($id . ' is not a valid hook');
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

    private function parseCommits ($commits) {
        $revisions = [];
        foreach ($commits as $item) {
            $revisions[] = [
                'sha'           => $item['sha'],
                'message'       => $item['commit']['message'],
                'author_avatar' => $item['author']['avatar_url'],
                'author'        => $item['author']['login'],
                'time'          => strtotime($item['commit']['author']['date']),
            ];
        }

        return $revisions;
    }

    public function commits ($repoName, $branch, $username = null) {
        if (is_null($username))
            $username = $this->username;

        $commits = $this->instance->repository()->commits()->all($username, $repoName, [
            'sha' => $branch,
        ]);

        $revisions = $this->parseCommits($commits);

        return $revisions;
    }


    /**
     * Response if same
     * Array
     * (
     * [files] => Array
     * (
     * )
     * [status] => identical
     * [ahead_by] => 0
     * [behind_by] => 0
     * [commits] => Array
     * (
     * )
     * )
     *
     *
     * @param      $repoName
     * @param null $username
     * @param      $base
     * @param      $head
     *
     * @return array
     */
    public function compareCommits ($repoName, $username = null, $base, $head) {
        if (is_null($username))
            $username = $this->username;

        $compare = $this->instance->repository()->commits()->compare($username, $repoName, $base, $head);
        $parsedCommit = [];
        $parsedFiles = [];
        foreach ($compare['files'] as $file) {
            $newFile = [
                'filename'  => $file['filename'],
                'status'    => $file['status'],
                'additions' => $file['additions'],
                'deletions' => $file['deletions'],
                'changes'   => $file['changes'],
            ];
            $parsedFiles[] = $newFile;
        }
        $parsedCommit['files'] = $parsedFiles;
        $parsedCommit['status'] = $compare['status']; // ahead or behind
        $parsedCommit['ahead_by'] = $compare['ahead_by'];
        $parsedCommit['behind_by'] = $compare['behind_by'];
        $parsedCommit['commits'] = $this->parseCommits($compare['commits']); // list of commits during that duration

        return $parsedCommit;
    }
}