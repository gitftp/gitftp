<?php

class Sendmail {

    public static function send() {
//        $url = 'http://www.gitftp.com/api/mail';
        $url = home_url.'api/mail';
        $data = array('key1' => 'value1', 'key2' => 'value2');

//        
//        $email = Email::forge();
//        $email->from('my@email.me', 'My Name');
//        $email->to('receiver@elsewhere.co.uk', 'Johny Squid');
//        $email->subject('This is the subject');
//        $email->to(array(
//            'example@mail.com',
//            'another@mail.com' => 'With a Name',
//        ));
//        $email->body('This is my message');
        
        
        echo http_build_query($email);
        
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
