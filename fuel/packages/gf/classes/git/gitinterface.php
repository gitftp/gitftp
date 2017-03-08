<?php

namespace Gf\Git;

interface GitInterface {
    function __construct ($username);

    function getRepositories ();

    function authenticate ($token);

    function getBranches ($repoName, $username);

    function getHook ($repoName, $id);

    function setHook ($repoName, $url);

    function removeHook ($repoName, $id);

    function updateHook ($repoName, $id, $url);
}