<?php

class Controller_Api_User extends Controller {

    /**
     * API called when user tries to login, or register using Oauth.
     *
     * @param null $provider
     */
    public function action_oauth($provider = NULL) {
        if (is_null($provider)) {
            // please provider provider.
            \Response::redirect_back();
        }

        // load Opauth, it will load the provider strategy and redirect to the provider
        \Auth_Opauth::forge();
    }

    /**
     * API called when user tries to login, or register using Oauth.
     * --- callback from OAuth provider. user is redirected to dashboard from here.
     *
     * @throws FuelException
     */
    public function action_callback() {
        try {
            $opauth = \Auth_Opauth::forge(FALSE);
            $status = $opauth->login_or_register();
            $provider = $opauth->get('auth.provider', '?');
            $token = $opauth->get('auth.credentials.token', '?');
            echo '<pre>';
            $user = new \Craftpip\Auth();
            $user->setProvider($provider, 'access_token', $token);
            $user->setAttr('github', $opauth->get('auth.info.nickname'));

            switch ($status) {
                // a local user was logged-in, the provider has been linked to this user
                case 'linked':
                    // inform the user the link was succesfully made
                    echo sprintf(__('login.provider-linked'), ucfirst($provider));
                    // and set the redirect url for this status
                    $url = dash_url;
                    break;

                // the provider was known and linked, the linked account as logged-in
                case 'logged_in':
                    // inform the user the login using the provider was succesful
                    echo sprintf(__('login.logged_in_using_provider'), ucfirst($provider));
                    // and set the redirect url for this status
                    $url = dash_url;
                    break;

                // we don't know this provider login, ask the user to create a local account first
                case 'register':
                    // inform the user the login using the provider was succesful, but we need a local account to continue
                    echo sprintf(__('login.register-first'), ucfirst($provider));
                    // and set the redirect url for this status
                    $url = '';
                    break;

                // we didn't know this provider login, but enough info was returned to auto-register the user
                case 'registered':
                    // inform the user the login using the provider was succesful, and we created a local account
                    echo __('login.auto-registered');
                    // and set the redirect url for this status
                    $url = dash_url;
                    break;

                default:
                    throw new \FuelException('Auth_Opauth::login_or_register() has come up with a result that we dont know how to handle.');
            }

            // redirect to the url set
            if (!empty($url))
                \Response::redirect($url);
        } // deal with Opauth exceptions
        catch (\OpauthException $e) {
            echo $e->getMessage();
//            \Response::redirect_back();
        } // catch a user cancelling the authentication attempt (some providers allow that)
        catch (\OpauthCancelException $e) {
            // you should probably do something a bit more clean here...
            exit('It looks like you canceled your authorisation.' . \Html::anchor('users/oath/' . $provider, 'Click here') . ' to try again.');
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

            $user = new \Craftpip\Auth();
            $users = $user->DBgetByUsernameEmail($i['email']);
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

            $user = new \Craftpip\Auth($i['user_id']);
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