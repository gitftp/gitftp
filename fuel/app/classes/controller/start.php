<?php

class Controller_Start extends Controller {
    public function get_index () {
        echo GF_CONFIG_FILE_EXISTS;

        if (!GF_CONFIG_FILE_EXISTS) {
            \Fuel\Core\Response::redirect('setup/start');
        } else {
            echo 'welcome';
        }
    }
}
