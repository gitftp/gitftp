<?php

use App\Exceptions\AppException;
use Illuminate\Support\Facades\DB;
use League\OAuth2\Client\Token\AccessToken;

interface GitProviderInterface {
    function __construct($username);

    function getInstance();

    function getRepositories();

    function authenticate($token);

    function getBranches($repoName);

    function getHook($repoName, $id);

    function setHook($repoName, $url);

    function removeHook($repoName, $id);

    function updateHook($repoName, $id, $url);
}
