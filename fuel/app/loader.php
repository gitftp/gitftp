<?php

/**
 * Gitftp loading configs
 */
define('GF_CONFIG_FILE', '.config.json');
define('GF_CONFIG_FILE_NEW', '.config.new.json');
$is_exists = file_exists(DOCROOT . GF_CONFIG_FILE);
$db_host = false;
$db_username = false;
$db_password = false;
$db_name = false;
$githubClientId = false;
$githubClientSecret = false;

if ($is_exists) {
    $config_file_h = fopen(DOCROOT . GF_CONFIG_FILE, 'r');
    $config_file = fread($config_file_h, filesize(DOCROOT . GF_CONFIG_FILE));
    $config = json_decode($config_file, true);
    if (isset($config['mysql'])) {
        $db_host = $config['mysql']['host'];
        $db_username = $config['mysql']['username'];
        $db_password = $config['mysql']['password'];
        $db_name = $config['mysql']['dbname'];
    }
    if (isset($config['github']) and isset($config['github']['clientId']) and isset($config['github']['clientSecret'])) {
        $githubClientId = $config['github']['clientId'];
        $githubClientSecret = $config['github']['clientSecret'];
    }
} else {
    $config_file_h = fopen(DOCROOT . GF_CONFIG_FILE_NEW, 'r');
    $config_file = fread($config_file_h, filesize(DOCROOT . GF_CONFIG_FILE_NEW));
}
define('GF_CONFIG_FILE_EXISTS', $is_exists);
define('GF_DB_HOST', $db_host);
define('GF_DB_USERNAME', $db_username);
define('GF_DB_PASSWORD', $db_password);
define('GF_DB_NAME', $db_name);
define('GF_GITHUB_CLIENT_ID', $githubClientId);
define('GF_GITHUB_CLIENT_SECRET', $githubClientSecret);

