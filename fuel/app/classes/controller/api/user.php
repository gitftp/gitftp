<?php

class Controller_Api_User extends Controller {

    /**
     * API called when user tries to login, or register using Oauth.
     * @param null $provider
     */
    public function action_authorize($provider = NULL) {
        if (is_null($provider)) {
            \Response::redirect_back();
        }
        $OAuth = new \Craftpip\OAuth\OAuth();
        try {
            $OAuth->init($provider);
            if ($OAuth->OAuth_is_callback) {
                switch ($OAuth->OAuth_state) {
                    case 'logged_in':
                        $url = dash_url;
                        // was registered and linked, now logged in.
                        break;
                    case 'linked':
                        $url = dash_url . 'settings/services';
                        $OAuth->setAttr('verified', TRUE);
                        // was already registered but linked.
                        break;
                    case 'registered':
                        $OAuth->setAttr('project_limit', 1);
                        $OAuth->setAttr('verified', TRUE);
                        $url = dash_url;
                        // was registered and linked.
                        break;
                }
                \Response::redirect($url);
            }
        } catch (Exception $e) {
            echo \View::forge('errors/generic_error', [
                'message' => 'Maybe your autorization code has Expired, please go back and try again.'
            ]);
        }
    }

    /**
     * API called when user performs login from homepage.
     */
    public function action_login() {
        try {
            $i = Input::post();
            \Auth::instance()->logout();
            if (\Auth::instance()->check()) {
                $response = array(
                    'status'   => TRUE,
                    'redirect' => dash_url,
                );
            } else {
                $a = \Auth::instance()->login($i['email'], $i['password']);
                if ($a) {
                    $response = array(
                        'status'   => TRUE,
                        'redirect' => dash_url,
                    );
                } else {
                    throw new Exception('The username & password did not match.');
                }
            }
        } catch (Exception $e) {
            $response = array(
                'status' => FALSE,
                'reason' => $e->getMessage(),
            );
        }

        echo json_encode($response);
    }

    /**
     * API called from homepage when user submits the registration form.
     */
    public function action_register() {
        // todo: have to make this happen
    }

    /**
     * API call from dashboard, when user enters old and new password to changes his/hers password.
     */
    public function post_changepassword() {
        try {
            $i = Input::post();

            if (!\Auth::instance()->check()) {
                throw new Exception('Sorry, we got confused. Please try again later.', 123);
            }

            if ($i['newpassword'] !== $i['newpassword2']) {
                throw new Exception('Sorry, the new passwords do not match.', 123);
            }

            $a = \Auth::instance()->change_password($i['oldpassword'], $i['newpassword']);

            if (!$a) {
                throw new Exception('Sorry, the old password is incorrect. Please try again.', 123);
            }

            // todo: count length of password please...

            $response = array(
                'status' => TRUE,
            );
        } catch (Exception $e) {
            $response = array(
                'status' => FALSE,
                'reason' => $e->getMessage(),
            );
        }

        echo json_encode($response);
    }

    /**
     * API call from forgot password,
     * when request to send email is done.
     *
     */
    public function post_forgotpassword() {
        try {
            $i = Input::post();

            $user = new \Craftpip\OAuth\Auth();
            $users = $user->DB->getByUsernameEmail($i['email']);
            if (!$users) {
                throw new Exception('Email/Username not registered with us.');
            }

            $mail = new \Craftpip\Mail($users['id']);
            $mail->template_forgotpassword();
            $mail->send();

            $response = array(
                'status'  => TRUE,
                'message' => 'asdsa',
            );
        } catch (Exception $e) {
            $response = array(
                'status' => FALSE,
                'reason' => $e->getMessage(),
            );
        }

        echo json_encode($response);
    }

    /**
     * API called from forgot password,
     * When user is redirected from email.
     *
     */
    public function post_forgotpasswordconfirmed() {
        try {
            $i = Input::post();

            $user = new \Craftpip\OAuth\Auth($i['user_id']);
            $key = $user->getAttr('forgotpassword_key');
            if ($key != $i['key']) {
                throw new Exception('Sorry, the token has expired.');
            }

            if (!(strlen($i['password']) > 5 && strlen($i['password']) < 12))
                throw new Exception('Sorry, something went wrong.');

            $user->setPassword($i['password']);
            $user->removeAttr('forgotpassword_key');
            $user->setAttr('verified', TRUE); // because password reset happened via email.
            if ($user->existAttr('verify_key'))
                $user->removeAttr('verify_key');
            $user->force_login($user->user_id);

            $response = array(
                'status'  => TRUE,
                'message' => 'Password has been changed successfully.',
            );
        } catch (Exception $e) {
            $response = array(
                'status' => FALSE,
                'reason' => $e->getMessage(),
            );
        }
        echo json_encode($response);
    }
}