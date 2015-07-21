<?php

class Controller_Homepage extends Controller {

    public function before(){
        parent::before();
        if(is_dash){
            $url = \Input::uri();
            Response::redirect(home_url.substr($url, 1, strlen($url)));
        }
    }

}
