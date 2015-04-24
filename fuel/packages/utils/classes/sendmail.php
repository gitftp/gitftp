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

// Set the from address

// Set the to address
        $email->to('bonifacepereira@gmail.com', 'Johny Squid');

// Set a subject
        $email->subject('This is the subject');

// And set the body.
        $email->body('This is my message');
        try
{
    $email->send();
}
catch(\EmailValidationFailedException $e)
{
    // The validation failed
}
catch(\EmailSendingFailedException $e)
{
    // The driver could not send the email
}
        
    }

}
