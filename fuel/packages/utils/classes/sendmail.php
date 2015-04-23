<?php

class Sendmail {

    public static function send() {
        echo 'asd';

        $url = 'http://www.gitftp.com/';
        $data = array('key1' => 'value1', 'key2' => 'value2');

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
