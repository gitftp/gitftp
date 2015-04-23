<?php

class Sendmail {

    public static function send() {
//        $url = 'http://www.gitftp.com/api/mail';
        $url = home_url.'api/mail';
        $data = array('key1' => 'value1', 'key2' => 'value2');

        // Create an instance
$email = Email::forge();

// Set the from address
$email->from('my@email.me', 'My Name');

// Set the to address
$email->to('receiver@elsewhere.co.uk', 'Johny Squid');

// Set a subject
$email->subject('This is the subject');

// Set multiple to addresses

$email->to(array(
    'example@mail.com',
    'another@mail.com' => 'With a Name',
));

// And set the body.
$email->body('This is my message');
        
        // use ksey 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        var_dump($result);
    }

}
