<?php

namespace Gf\Git;

use Bitbucket\API\User\Repositories;
use GuzzleHttp\Client;
use League\OAuth2\Client\Token\AccessToken;

/**
 * Class Bitbucket
 *
 * @package Craftpip\GitApi
 */
class Bitbucket implements GitInterface {
    private $username;
    private $options = [];
    private $client;
    private $api_url = "https://api.bitbucket.org/2.0/";
    private $instance;

    /**
     * @param $username
     */
    public function __construct ($username) {
        $this->username = $username;
        $this->client = new Client([
            'base_uri' => $this->api_url,
        ]);
    }

    public function authenticate ($token) {
        $this->options['headers']['Authorization'] = "Bearer $token";
    }

    private function getAll ($list) {
        global $lists;

        if (isset($list['next']) && count($list['values']) == 10) {
            $nextList = $this->client->get($list['next'], [
                'headers' => $this->options['headers'],
            ]);
            $nextList = json_decode($nextList->getBody(), true);
            $listMerge = $this->getAll($nextList, $lists);

            return array_merge($listMerge, $list['values']);
        }

        return $list['values'];
    }

    public function getRepositories () {
        $repo = new Repositories();
        $repo->

        $data = $this->client->get('repositories/' . $this->username, [
            'headers' => $this->options['headers'],
        ]);

        $a = json_decode($data->getBody(), true);
        $a = $this->getAll($a);

        $response = [];
        foreach ($a as $repo) {
            if ($repo['scm'] !== 'git')
                continue;

            $cloneUrl = '';
            foreach ($repo['links']['clone'] as $c) {
                if ($c['name'] == 'https') {
                    $cloneUrl = $c['href'];
                    break;
                }
            }
            $b = [
                'id'        => $repo['uuid'],
                'name'      => $repo['name'],
                'full_name' => $repo['full_name'],
                'repo_url'  => $repo['links']['html']['href'],
                'api_url'   => $repo['links']['self']['href'],
                'clone_url' => $cloneUrl,
                'size'      => $repo['size'],
                'provider'  => 'bitbucket',
            ];

            $response[] = $b;
        }

        return $response;
    }

    public function getBranches ($repoName, $username = null) {
        $repoName = $this->cleanRepoName($repoName);
        $data = $this->client->get(sprintf('repositories/%s/%s/refs/branches', $this->username, $repoName), [
            'headers' => $this->options['headers'],
        ]);
        $a = json_decode($data->getBody(), true);
        $a = $this->getAll($a);

        $branches = [];
        foreach ($a as $branch) {
            $branches[] = $branch['name'];
        }

        return $branches;
    }

    public function getHook ($repoName, $id = null) {
        $repoName = $this->cleanRepoName($repoName);
        if (is_null($id)) {
            $data = $this->client->get(sprintf('repositories/%s/%s/hooks', $this->username, $repoName), [
                'headers' => $this->options['headers'],
            ]);
            $data = json_decode($data->getBody(), true);
            $data = $this->getAll($data);

            $response = [];
            foreach ($data as $k) {
                $response[] = [
                    'id'          => $k['uuid'],
                    'name'        => $k['description'],
                    'events'      => $k['events'],
                    'url'         => $k['url'],
                    'contenttype' => 'json',
                ];
            }
        } else {
            $id = $this->parseUUID($id);
            $data = $this->client->get(sprintf('repositories/%s/%s/hooks/%s', $this->username, $repoName, $id), [
                'headers' => $this->options['headers'],
            ]);
            $data = json_decode($data->getBody(), true);

            $response = [
                'id'          => $data['uuid'],
                'name'        => $data['description'],
                'events'      => $data['events'],
                'url'         => $data['url'],
                'contenttype' => 'json',
            ];
        }

        return $response;
    }

    public function cleanRepoName ($name) {
        return trim(strtolower($name));
    }

    public function parseUUID ($id) {
        if (substr($id, 0, 1) === '{') {
            $id = substr($id, 1, strlen($id) - 2);
        }

        return $id;
    }

    public function setHook ($repoName, $url) {
        $repoName = $this->cleanRepoName($repoName);

        $config = [
            'description' => 'Gitftp Webhook - ' . \Str::random(),
            'url'         => $url,
            'active'      => true,
            'events'      => ['repo:push'],
        ];

        $data = $this->client->post(sprintf('repositories/%s/%s/hooks', $this->username, $repoName), [
            'headers' => $this->options['headers'],
            'body'    => json_encode($config),
        ]);

        $data = json_decode($data->getBody(), true);

        if (isset($data['error'])) {
            throw new Exception($data['error']['message']);
        }

        $response = [
            'id'          => $data['uuid'],
            'name'        => $data['description'],
            'events'      => $data['events'],
            'url'         => $data['url'],
            'contenttype' => 'json',
        ];

        return $response;
    }

    public function removeHook ($repoName, $id) {
        $repoName = $this->cleanRepoName($repoName);
        $id = $this->parseUUID($id);

        $data = $this->client->delete(sprintf('repositories/%s/%s/hooks/%s', $this->username, $repoName, $id), [
            'headers' => $this->options['headers'],
        ]);

        $data = json_decode($data->getBody(), true);

        if (isset($data['error']['message'])) {
            throw new Exception($data['error']['message']);
        } else {
            return true;
        }
    }

    public function updateHook ($repoName, $id, $url) {

        $id = $this->parseUUID($id);
        $repoName = $this->cleanRepoName($repoName);

        $config = [
            'description' => 'Gitftp Webhook - ' . \Str::random(),
            'url'         => $url,
            'active'      => true,
            'events'      => ['repo:push'],
        ];

        $data = $this->client->put(sprintf('repositories/%s/%s/hooks/%s', $this->username, $repoName, $id), [
            'headers' => $this->options['headers'],
            'body'    => json_encode($config),
        ]);

        $data = json_decode($data->getBody(), true);

        if (isset($data['error']['message'])) {
            throw new Exception($data['error']['message']);
        }

        $response = [
            'id'          => $data['uuid'],
            'name'        => $data['description'],
            'events'      => $data['events'],
            'url'         => $data['url'],
            'contenttype' => 'json',
        ];

        return $response;
    }

}