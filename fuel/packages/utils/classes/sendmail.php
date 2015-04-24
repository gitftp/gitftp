<?php

class Sendmail {

    /**
     * $data = array(
     *      'to' => $user_id,
     *      'format' => 1,
     * )
     * @param array $data
     */
    
    public function send() {
        
        $email = Email::forge();
        $email->to('bonifacepereira@gmail.com', 'Johny Squid');
        $email->subject('This is the subject');
        $email->body('This is my message');
        
        try {
            $email->send();
        } catch (\EmailValidationFailedException $e) {
            return false;
        } catch (\EmailSendingFailedException $e) {
            return false;
        }
        
    }

}
