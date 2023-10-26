<?php


class Controller_Oauth_Authorize extends Controller {

    public function action_github () {
        $this->process_login(\Gf\Auth\OAuth::provider_github);
    }

    public function action_bitbucket () {
        $this->process_login(\Gf\Auth\OAuth::provider_bitbucket);
    }

    public function process_login ($provider) {
        $exception = false;
        $status = 'success';

        try {
            $oauth = \Gf\Auth\OAuth::instance($provider);
            try {
                $oauth->init();
            } catch (Exception $e) {
                if (!$oauth->is_callback)
                    throw $e;

                $status = 'failure';
                $exception = $e->getMessage();
            }

            if ($oauth->is_callback) {
                \Fuel\Core\Response::redirect(\Fuel\Core\Uri::create('settings/connected-accounts', [], [
                    's' => $status,
                    'e' => $exception,
                ]));
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}