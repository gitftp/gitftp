<?php

use Fuel\Core\Input;
use Gf\Config;

class Controller_Console_Api_Oauth extends Controller_Console_Authenticate {

    public function post_list () {
        try {
            $list = [];
            if ($github = Config::instance()->get('github', false)) {
                $list['github'] = $github;
            }
            if ($bitbucket = Config::instance()->get('bitbucket', false)) {
                $list['bitbucket'] = $bitbucket;
            }

            $r = [
                'status' => true,
                'data'   => $list,
            ];
        } catch (\Exception $e) {
            $e = \Gf\Exception\ExceptionInterceptor::intercept($e);
            $r = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }
        $this->response($r);
    }

    public function post_save () {
        try {
            $githubClientId = Input::json('github.clientId', false);
            $githubClientSecret = Input::json('github.clientSecret', false);
            $bitbucketClientId = Input::json('bitbucket.clientId', false);
            $bitbucketClientSecret = Input::json('bitbucket.clientSecret', false);
            $set = [];

            if ($githubClientId and $githubClientSecret) {
                $set['github.clientId'] = $githubClientId;
                $set['github.clientSecret'] = $githubClientSecret;
            } else {
                Config::instance()->remove('github');
            }
            if ($bitbucketClientId and $bitbucketClientSecret) {
                $set['bitbucket.clientId'] = $bitbucketClientId;
                $set['bitbucket.clientSecret'] = $bitbucketClientSecret;
            } else {
                Config::instance()->remove('bitbucket');
            }

            if (!$githubClientId and !$githubClientSecret and !$bitbucketClientId and !$bitbucketClientSecret)
                throw new \Gf\Exception\UserException('At least one configuration for oauth application is required');

            Config::instance()->set($set)->save();

            $r = [
                'status' => true,
            ];
        } catch (\Exception $e) {
            $e = \Gf\Exception\ExceptionInterceptor::intercept($e);
            $r = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }
        $this->response($r);
    }

}
