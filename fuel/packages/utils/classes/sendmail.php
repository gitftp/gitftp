<?php

class Sendmail {
    
    private $instance;
    private $toUser = 0;
    
    public function __construct() {
        $this->instance = Email::forge();
    }
    
    public function send() {
        
        if($this->toUser == 0){
            $this->toUser = Auth::get_user_id()[1];
            $email = Auth::get_email();
             = Auth::get_email();
        }else{
            
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
