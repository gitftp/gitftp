<?php

namespace Craftpip\GitApi;

use Craftpip\Exception;
use Fuel\Core\Inflector;
use GuzzleHttp\Exception\ServerException;

/**
 * Class Bitbucket
 * @package Craftpip\GitApi
 */
class Bitbucket implements GitApiInterface {
    private $username;
    private $options = array();
    private $client;
    private $api_url = "https://api.bitbucket.org/2.0/";

    /**
     * @param $username
     */
    public function __construct($username) {
        $this->username = $username;
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $this->api_url
        ]);
    }

    public function authenticate($token) {
        $this->options['headers']['Authorization'] = "Bearer $token";
    }

    private function getAll($list) {
        global $lists;

        if (isset($list['next']) && count($list['values']) == 10) {
            $nextList = $this->client->get($list['next'], [
                'headers' => $this->options['headers']
            ]);
            $nextList = json_decode($nextList->getBody(), TRUE);
            $listMerge = $this->getAll($nextList, $lists);

            return array_merge($listMerge, $list['values']);
        }

        return $list['values'];
    }

    public function getRepositories() {
        $data = $this->client->get('repositories/' . $this->username, [
            'headers' => $this->options['headers']
        ]);
        $a = json_decode($data->getBody(), TRUE);
        $a = $this->getAll($a);

        $response = array();
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
            $b = array(
                'id'        => $repo['uuid'],
                'name'      => $repo['name'],
                'full_name' => $repo['full_name'],
                'repo_url'  => $repo['links']['html']['href'],
                'api_url'   => $repo['links']['self']['href'],
                'clone_url' => $cloneUrl,
                'size'      => $repo['size'],
                'provider'  => 'bitbucket',
            );

            $response[] = $b;
        }

        return $response;
    }

    public function getBranches($repoName) {
        $repoName = $this->cleanRepoName($repoName);
        $data = $this->client->get(sprintf('repositories/%s/%s/refs/branches', $this->username, $repoName), [
            'headers' => $this->options['headers']
        ]);
        $a = json_decode($data->getBody(), TRUE);
        $a = $this->getAll($a);

        $branches = array();
        foreach ($a as $branch) {
            $branches[] = $branch['name'];
        }

        return $branches;
    }

    public function getHook($repoName, $id = NULL) {
        $repoName = $this->cleanRepoName($repoName);
        if (is_null($id)) {
            $data = $this->client->get(sprintf('repositories/%s/%s/hooks', $this->username, $repoName), [
                'headers' => $this->options['headers']
            ]);
            $data = json_decode($data->getBody(), TRUE);
            $data = $this->getAll($data);

            $response = array();
            foreach ($data as $k) {
                $response[] = array(
                    'id'          => $k['uuid'],
                    'name'        => $k['description'],
                    'events'      => $k['events'],
                    'url'         => $k['url'],
                    'contenttype' => 'json'
                );
            }
        } else {
            $id = $this->parseUUID($id);
            $data = $this->client->get(sprintf('repositories/%s/%s/hooks/%s', $this->username, $repoName, $id), [
                'headers' => $this->options['headers']
            ]);
            $data = json_decode($data->getBody(), TRUE);

            $response = array(
                'id'          => $data['uuid'],
                'name'        => $data['description'],
                'events'      => $data['events'],
                'url'         => $data['url'],
                'contenttype' => 'json'
            );
        }

        return $response;
    }

    public function cleanRepoName($name) {
        return trim(strtolower($name));
    }

    public function parseUUID($id) {
        if (substr($id, 0, 1) === '{') {
            $id = substr($id, 1, strlen($id) - 2);
        }

        return $id;
    }

    public function setHook($repoName, $url) {
        $repoName = $this->cleanRepoName($repoName);

        $config = array(
            'description' => 'Gitftp Webhook - ' . \Str::random(),
            'url'         => $url,
            'active'      => TRUE,
            'events'      => array('repo:push')
        );

        $data = $this->client->post(sprintf('repositories/%s/%s/hooks', $this->username, $repoName), [
            'headers' => $this->options['headers'],
            'body'    => json_encode($config)
        ]);

        $data = json_decode($data->getBody(), TRUE);

        if (isset($data['error'])) {
            throw new Exception($data['error']['message']);
        }

        $response = array(
            'id'          => $data['uuid'],
            'name'        => $data['description'],
            'events'      => $data['events'],
            'url'         => $data['url'],
            'contenttype' => 'json'
        );

        return $response;
    }

    public function removeHook($repoName, $id) {
        $repoName = $this->cleanRepoName($repoName);
        $id = $this->parseUUID($id);

        $data = $this->client->delete(sprintf('repositories/%s/%s/hooks/%s', $this->username, $repoName, $id), [
            'headers' => $this->options['headers']
        ]);

        $data = json_decode($data->getBody(), TRUE);

        if (isset($data['error']['message'])) {
            throw new Exception($data['error']['message']);
        } else {
            return TRUE;
        }
    }

    public function updateHook($repoName, $id, $url) {

        $id = $this->parseUUID($id);
        $repoName = $this->cleanRepoName($repoName);

        $config = array(
            'description' => 'Gitftp Webhook - ' . \Str::random(),
            'url'         => $url,
            'active'      => TRUE,
            'events'      => array('repo:push')
        );

        $data = $this->client->put(sprintf('repositories/%s/%s/hooks/%s', $this->username, $repoName, $id), [
            'headers' => $this->options['headers'],
            'body'    => json_encode($config)
        ]);

        $data = json_decode($data->getBody(), TRUE);

        if (isset($data['error']['message'])) {
            throw new Exception($data['error']['message']);
        }

        $response = array(
            'id'          => $data['uuid'],
            'name'        => $data['description'],
            'events'      => $data['events'],
            'url'         => $data['url'],
            'contenttype' => 'json'
        );

        return $response;
    }

}