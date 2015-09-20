<?php
namespace Craftpip;

class Mail {

    protected $instance;
    private $theme = 'default';

    public function __construct($user_id = NULL) {
        $this->instance = \Email::forge();
        $this->user = new \Craftpip\OAuth\Auth($user_id);
    }

    public function subject($subject) {
        $this->instance->subject($subject);

        return $this;
    }

    public function body($body) {
        $this->instance->html_body($body);

        return $this;
    }

    public function to($email, $name) {
        $this->instance->to($email, $name);

        return $this;
    }

    public function send() {

        try {
            $this->instance->send();
        } catch (\EmailValidationFailedException $e) {
            throw $e;
        } catch (\EmailSendingFailedException $e) {
            throw $e;
        }

        return TRUE;
    }

    /**
     * When user signup's with the Web interface.
     * @return $this
     */
    public function template_signup() {
        $user = $this->user->user;
        $random = \Str::random();

        $this->subject('Welcome to Gitftp');
        $this->to($user['email'], $user['username']);

        $view = \View::forge('email/' . $this->theme . '/base', array(
            'content' => \View::forge('email/' . $this->theme . '/signup', array(
                'username'    => $user['username'],
                'confirmLink' => home_url . 'login?verify=' . $user['id'] . '-' . $random,
            ))
        ));
        $this->body($view);
        $this->user->setAttr('verified', FALSE);
        $this->user->setAttr('verify_key', $random);

        return $this;
    }

    /**
     * When user request for forgot password via web interface.
     * @return $this
     */
    public function template_forgotpassword() {
        $user = $this->user->user;
        $random = \Str::random();

        $this->subject('Reset your password');
        $this->to($user['email'], $user['username']);

        $view = \View::forge('email/' . $this->theme . '/base', array(
            'content' => \View::forge('email/' . $this->theme . '/forgotpassword', array(
                'username'  => $user['username'],
                'resetlink' => home_url . 'forgot-password?token=' . $user['id'] . '-' . $random,
            ))
        ));

        $this->body($view);

        $this->user->setAttr('forgotpassword_key', $random);

        return $this;
    }

    /**
     * Invite a user to gitftp. registered via Admin panel.
     *
     * @return $this
     */
    public function template_new_user_invite() {
        $user = $this->user->user;
        $random = \Str::random();

        $this->subject('Welcome to Gitftp');
        $this->to($user['email'], $user['username']);

        $view = \View::forge('email/' . $this->theme . '/base', array(
            'content' => \View::forge('email/' . $this->theme . '/newuserinvite', array(
                'username'  => $user['username'],
                'resetlink' => home_url . 'forgot-password?token=' . $user['id'] . '-' . $random,
            ))
        ));

        $this->body($view);
        $this->user->setAttr('forgotpassword_key', $random);

        return $this;
    }

}
