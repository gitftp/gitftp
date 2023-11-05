<?php

namespace App\Helpers\Git\GitApi;

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

    function commits($repoName, $branch, $username = null);
}
