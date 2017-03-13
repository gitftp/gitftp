<?php

namespace Gf\Git;

interface GitInterface {
    function __construct ($username);

    function getRepository ($username, $repoName);

    function getRepositories ();

    function authenticate ($token);

    function getBranches ($repoName, $username);

    function getHook ($repoName, $id);

    function setHook ($repoName, $username, $url);

    function removeHook ($repoName, $id);

    function updateHook ($repoName, $id, $url);

    function commits ($repoName, $branch, $username = null);

    function compareCommits ($repoName, $username = null, $base, $head);
}