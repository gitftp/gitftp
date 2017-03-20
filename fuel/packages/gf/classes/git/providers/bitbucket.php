<?php

namespace Gf\Git\Providers;

use Bitbucket\API\Api;
use Bitbucket\API\Http\ClientInterface;
use Bitbucket\API\Http\Listener\OAuth2Listener;
use Bitbucket\API\User;
use Bitbucket\API\User\Repositories;
use Fuel\Core\Uri;
use Gf\Auth\OAuth;
use Gf\Exception\AppException;
use Gf\Exception\UserException;
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

    /**
     * @var ClientInterface
     */
    private $client;
    private $api_url = "https://api.bitbucket.org/2.0/";
    private $instance;
    private $api;

    /**
     * @param $username
     */
    public function __construct ($username) {
        $this->username = $username;
//        $this->client = new Client([
//            'base_uri' => $this->api_url,
//        ]);
        $this->api = new Api([
            'api_version' => '2.0',
        ]);
    }

    public function authenticate ($token) {
        $this->api->getClient()->addListener(
            new OAuth2Listener([
                'access_token' => $token,
            ])
        );
        $this->client = $this->api->getClient();

//        $this->options['headers']['Authorization'] = "Bearer $token";
    }

    function getRepository ($username, $repoName) {
        $repoName = strtolower($repoName);

        $repository = $this->client->setApiVersion('2.0')
            ->get("repositories/$username/$repoName");
        $repository_data = $repository->getContent();
        $repository_data = json_decode($repository_data, true);

        $cloneUrl = '';
        foreach ($repository_data['links']['clone'] as $link) {
            if ($link['name'] == 'https') {
                $cloneUrl = $link['href'];
                break;
            }
        }

        $repository_parsed = [
            'id'        => $repository_data['uuid'],
            'name'      => $repository_data['name'],
            'full_name' => $repository_data['full_name'],
            'repo_url'  => $repository_data['links']['html']['href'],
            'api_url'   => $repository_data['links']['self']['href'],
            'clone_url' => $cloneUrl,
            'size'      => $repository_data['size'],
            'private'   => $repository_data['is_private'],
            'provider'  => OAuth::provider_bitbucket,
        ];

        return $repository_parsed;
    }

    private $repositoriesPaginated = [];

    private function getRepositoriesPaginateAll ($page, $after = null) {
        $query = [
            'role' => 'admin',
            'page' => $page,
        ];

        if (!is_null($after))
            $query['after'] = $after;

        $repositories = $this->client->setApiVersion('2.0')->get('repositories', $query);
        $data = $repositories->getContent();
        $data = json_decode($data, true);
        $this->repositoriesPaginated = array_merge($this->repositoriesPaginated, $data['values']);
        if (!empty($data['next'])) {
            $parts = parse_url($data['next']);
            parse_str($parts['query'], $query);

            return $this->getRepositoriesPaginateAll($query['page'], $query['after']);
        } else {
            $repo = $this->repositoriesPaginated;
            $this->repositoriesPaginated = [];

            return $repo;
        }
    }

    public function getRepositories () {
        $repositories = $this->getRepositoriesPaginateAll(1);

        //scm = "git"
        //website = ""
        //has_wiki = false
        //name = "Global3"
        //links = {array} [12]
        //fork_policy = "no_public_forks"
        //uuid = "{39498ad5-fc0c-4e69-be59-95ce2537707e}"
        //language = ""
        //created_on = "2015-01-05T13:23:49.485463+00:00"
        //mainbranch = {array} [0]
        //full_name = "gaurish_rane/global3"
        //has_issues = false
        //owner = {array} [5]
        //updated_on = "2015-04-16T15:13:32.224238+00:00"
        //size = 147420877
        //type = "repository"
        //slug = "global3"
        //is_private = true
        //description = ""


        $response = [];
        foreach ($repositories as $repo) {
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
                'private'   => $repo['is_private'],
                'provider'  => OAuth::provider_bitbucket,
            ];

            $response[] = $b;
        }

        return $response;
    }

    private $branchesPaginated = [];

    private function getBranchesPaginateAll ($username, $repoName, $page, $after = null) {
        $query = [
            'page' => $page,
        ];

        if (!is_null($after))
            $query['after'] = $after;

        $branchesList = $this->client->setApiVersion('2.0')->get("repositories/$username/$repoName/refs/branches", $query);
        $data = $branchesList->getContent();
        $data = json_decode($data, true);
        $this->branchesPaginated = array_merge($this->branchesPaginated, $data['values']);
        if (!empty($data['next'])) {
            $parts = parse_url($data['next']);
            parse_str($parts['query'], $query);

            return $this->getBranchesPaginateAll($username, $repoName, $query['page'], $query['after']);
        } else {
            $branches = $this->branchesPaginated;
            $this->branchesPaginated = [];

            return $branches;
        }
    }

    public function getBranches ($repoName, $username = null) {
        if (is_null($username))
            $username = $this->username;

        $repoName = $this->cleanRepoName($repoName);

        $branchesList = $this->getBranchesPaginateAll($username, $repoName, 1);

        $branches = [];
        foreach ($branchesList as $branch) {
            if ($branch['type'] == 'branch')
                $branches[] = $branch['name'];
        }

        return $branches;
    }

    public function getHook ($repoName, $id = null) {
        if (is_null($id)) {
            // not tested
            $response = $this->getRequest("repositories/{$this->username}/$repoName/hooks");

            foreach ($response as $k) {
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
            try {
                $response = $this->getRequest("repositories/{$this->username}/$repoName/hooks/$id");
            } catch (\Exception $e) {
                return false;
            }

            $response = [
                'id'          => $response['uuid'],
                'name'        => $response['description'],
                'events'      => $response['events'],
                'url'         => $response['url'],
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

    private function postRequest ($apiPath, $payload) {
        $response = $this->client->post($apiPath, json_encode($payload), [
            'Content-Type' => 'application/json',
        ]);
        $content = $response->getContent();
        $content = json_decode($content, true);
        if (isset($content['type']) and $content['type'] == 'error')
            throw new AppException($content['error']['message']);

        return $content;
    }

    private function deleteRequest ($apiPath) {
        $response = $this->client->delete($apiPath, [
            'Content-Type' => 'application/json',
        ]);
        $content = $response->getContent();
        $content = json_decode($content, true);
        if (isset($content['type']) and $content['type'] == 'error')
            throw new AppException($content['error']['message']);

        return $content;
    }

    private function getRequest ($apiPath) {
        $apiPath = strtolower($apiPath);
        $response = $this->client->get($apiPath);
        $content = $response->getContent();
        $content = json_decode($content, true);
        if (isset($content['type']) and $content['type'] == 'error')
            throw new AppException($content['error']['message']);

        return $content;
    }

    public function setHook ($repoName, $username, $url) {
        $repoName = $this->cleanRepoName($repoName);

        $config = [
            'description' => 'Gitftp hook - ' . \Str::random('alnum', 6),
            'url'         => $url,
            'active'      => true,
            'events'      => ['repo:push'],
        ];

        $apiPath = "repositories/$username/$repoName/hooks";
        $content = $this->postRequest($apiPath, $config);

        $response = [
            'id'          => $content['uuid'],
            'name'        => $content['description'],
            'events'      => $content['events'],
            'url'         => $content['url'],
            'contenttype' => 'json',
        ];

        return $response;
    }

    /**
     * @todo: Needs work
     *
     * @param $repoName
     * @param $id
     *
     * @return bool
     */
    public function removeHook ($repoName, $id) {
        $repoName = $this->cleanRepoName($repoName);
        $id = $this->parseUUID($id);

        try {
            $response = $this->deleteRequest("repositories/{$this->username}/$repoName/hooks/$id");
        } catch (\Exception $e) {

        }

        return true;
    }

    /**
     * @todo needs work
     *
     * @param $repoName
     * @param $id
     * @param $url
     *
     * @return array
     */
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

    function commits ($repoName, $branch, $username = null) {
        $response = $this->getRequest("repositories/$username/$repoName/commits/$branch");

        $revisions = [];
        foreach ($response['values'] as $value) {
            $revisions[] = [
                'sha'           => $value['hash'],
                'message'       => $value['message'],
                'author_avatar' => $value['author']['user']['links']['avatar']['href'],
                'author'        => $value['author']['user']['username'],
                'time'          => strtotime($value['date']),
            ];
        }

        return $revisions;
    }

    function compareCommits ($repoName, $username = null, $base, $head) {
        // TODO: Implement compareCommits() method.
        $response = $this->getRequest("repositories/$username/$repoName/diff/$base..$head");
    }
}