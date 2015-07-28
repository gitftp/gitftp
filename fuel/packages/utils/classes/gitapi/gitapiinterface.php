<?php

namespace Craftpip\GitApi;

interface GitApiInterface {
    function __construct($username);

    function getRepositories();

//    function getBranches();
//
//    function getHooks();
//
//    function setHooks();
}