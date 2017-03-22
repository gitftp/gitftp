<?php

namespace Gf;

use Fuel\Core\Input;
use Fuel\Core\Request;
use Gf\Auth\OAuth;
use Gf\Exception\AppException;
use Gf\Exception\UserException;

/**
 * Validate and parse the webhook payload
 * Class WebHook
 *
 * @package Gf
 */
class WebHook {

    public static function parse ($user_id, $project_id, $key) {
        if (!$user_id or !$project_id or !$key)
            throw new UserException('Missing parameters');

        $project = Project::get_one([
            'id'       => $project_id,
            'owner_id' => $user_id,
            'hook_key' => $key,
        ]);
        if (!$project)
            throw new UserException("The project was not found");

        $provider = $project['provider'];

        if ($provider == OAuth::provider_github) {
            return self::parseGithub();
        } elseif ($provider == OAuth::provider_bitbucket) {
            return self::parseBitBucket();
        } else {
            throw new AppException('Provider type found invalid, given: ' . $provider);
        }
    }

    private static function parseGithub () {
        $header = Input::headers('X-GitHub-Event', false);
        if (!$header or $header != 'push')
            throw new AppException('Unexpected payload');

        $ref = Input::json('ref', false);
        $after = Input::json('after', false);
        $compare = Input::json('compare', false);
        $commits = Input::json('commits', false);

        if (!$ref or !$after or !$compare or !$commits)
            throw new AppException('Invalid payload');

        $parts = explode('/', $ref);
        if (!isset($parts[2]))
            throw new AppException("Invalid ref $ref");

        $branch = $parts[2];

        $latestCommit = [];
        foreach ($commits as $commit) {
            if ($commit['id'] == $after) {
                $latestCommit = $commit;
            }
        }

        if (!count($latestCommit))
            throw new AppException('Could not read commit');

        $parsedCommit['sha'] = $latestCommit['id'];
        $parsedCommit['message'] = $latestCommit['message'];
        $parsedCommit['author_email'] = $latestCommit['author']['email'];
        $parsedCommit['author'] = $latestCommit['author']['username'];
        $parsedCommit['time'] = strtotime($latestCommit['timestamp']);

        $hash = $after;

        $response = [
            'branch' => $branch,
            'commit' => $parsedCommit,
            'hash'   => $hash,
        ];

        return $response;
    }

    private static function parseBitBucket () {

    }
}