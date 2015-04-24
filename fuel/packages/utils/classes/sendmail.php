<?php

class Sendmail {
    
    private $instance;
    private $toUser = 0;
    private $body;
    
    public function __construct() {
        $this->instance = Email::forge();
            $this->view = View::forge('email/base');
    }
    
    public function body($name){
        $this->view->content = View::forge("email/$name");
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
            $a = DB::select('username', 'email')->from('users')->where('id', $id)->execute()->as_array();
            if(count($a) == 1){
                $email = $a[0]['email'];
                $name = $a[0]['username'];
            }else{
                return false;
            }
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
