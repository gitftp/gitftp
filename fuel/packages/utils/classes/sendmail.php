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

// Set multiple to addresses

        $email->to(array(
            'example@mail.com',
            'another@mail.com' => 'With a Name',
        ));

// And set the body.
        $email->body('This is my message');
    }

}
