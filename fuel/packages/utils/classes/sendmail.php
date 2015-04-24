<?php

class Sendmail {
    
    private $instance;
    private $toUser = 0;
    private $body;
    
    public function __construct() {
        $this->instance = Email::forge();
        $this->body = View::forge('email/base');
    }
    
    public function body($name){
        $this->body = $this->body("email/$name");
    }
    
    public function send() {
        
        if($this->toUser == 0){
            if(!Auth::check()){
                return false;
            }
            $this->toUser = Auth::get_user_id()[1];
            $email = Auth::get_email();
            $name = Auth::get_screen_name();
        }else{
            DB::select('')->from('users')
        }
        
        
        $email->to('bonifacepereira@outlook.com', 'Boniface Pereira');
        $email->subject('This is the subject');
        $email->html_body(View::forge('email/signup'));
        
        try {
            $email->send();
        } catch (\EmailValidationFailedException $e) {
            return false;
        } catch (\EmailSendingFailedException $e) {
            return false;
        }
        return true;
        
    }

}
