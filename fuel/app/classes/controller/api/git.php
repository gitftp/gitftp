<?php

class Controller_Api_Git extends Controller_Api_Apilogincheck {

    public function get_repositories() {
        try {
            $gitapi = new \Craftpip\GitApi();
            $response = array(
                'status' => TRUE,
                'data'   => $gitapi->getRepositories()
            );
        } catch (Exception $e) {
            throw $e;
            $e = new \Craftpip\Exception($e->getMessage(), $e->getCode());
            $response = array(
                'status' => FALSE,
                'reason' => $e->getMessage()
            );
        }
        $this->response($response);
    }

}