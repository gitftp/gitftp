<?php

class Controller_Api_Ftp extends Controller_Api_Apilogincheck {

    public function get_unused() {
        $ftp = new Model_Ftp();
        $unusedftp = $ftp->getUnused();

        $this->response(array(
            'status' => TRUE,
            'data'   => $unusedftp
        ));
    }

    /**
     * List one or more FTP.
     *
     * @param type $id
     * @return type
     */
    public function action_get($id = NULL) {
        $ftp = new Model_Ftp();
        $data = $ftp->get($id);
        $data = Utils::strip_passwords($data);
        $this->response(array(
            'status' => TRUE,
            'data'   => $data
        ));
    }

    /**
     * test connection to a ftp server.
     *
     * @param null $a
     * @param bool $return
     */
    public function post_testftp($a = NULL, $return = FALSE) {
        $i = Input::post();

        try {
            if (!isset($i['host']) || !isset($i['scheme'])) {
                throw new Exception('Please enter necessary details to connect to your Server.');
            } else if (trim($i['host']) == '' || trim($i['scheme']) == '') {
                throw new Exception('Please enter necessary details to connect to your Server.');
            }

            $options = array(
                'user'   => $i['username'],
                'host'   => $i['host'],
                'pass'   => (isset($i['pass'])) ? $i['pass'] : '',
                'scheme' => $i['scheme'],
                'port'   => $i['port'],
                'path'   => $i['path'],
            );

            if (!isset($i['pass']) && isset($i['id'])) {
                /*
                 * Take the password that is stored with us.
                 */
                $ftp_id = $i['id'];
                $ftp_model = new Model_Ftp();
                $ftp_data = $ftp_model->get($ftp_id);
                if (count($ftp_data) !== 1) {
                    throw new Exception('Ftp does not exist, or has been deleted.');
                }
                $ftp_data = $ftp_data[0];
                if (!empty($ftp_data['pass'])) {
                    $options['pass'] = $ftp_data['pass'];
                }
            }

            $ftp_url = http_build_url($options);
            if (Utils::test_ftp($ftp_url)) {
                $response = array(
                    'status' => TRUE
                );
            } else {
                throw new Exception('Could not connect');
            }

        } catch (Exception $e) {
            $response = array(
                'status' => FALSE,
                'reason' => $e->getMessage()
            );
        }

        $this->response($response);
    }

    /**
     * adding a FTP server.
     * @return boolean
     */
    public function post_addftp() {
        /**
         * test ftp before adding,
         */
        $data = Input::post();
        $data = Utils::escapeHtmlChars($data);

        try {

            $ftp = new Model_Ftp();

            $stripformatch = $data;
            if (isset($data['name']))
                unset($stripformatch['name']);

            $existing = $ftp->match($stripformatch);

            if (count($existing) > 0) {
                throw new Exception('Sorry, A FTP account "' . $existing[0]['name'] . '" with the same configuration already exist in your account.');
            } else {
                $a = $ftp->insert($data);
                if ($a) {
                    $response = array(
                        'status'  => TRUE,
                        'request' => Input::post()
                    );
                }
            }

        } catch (Exception $e) {
            $response = array(
                'status'  => FALSE,
                'reason'  => $e->getMessage(),
                'request' => (Input::method() == 'POST') ? Input::post() : ''
            );
        }

        $this->response($response);

    }

    /**
     * editing a FTP server by id.
     * @return boolean
     */
    public function post_editftp($id) {

        try {
            $ftp = new Model_Ftp();
            $data = Input::post();
            $data = Utils::escapeHtmlChars($data);
            $a = $ftp->set($id, $data);

            if ($a || FALSE) {
                $response = array(
                    'status'  => TRUE,
                    'request' => Input::post(),
                );
            } else {
                throw new Exception('No changes were saved.');
            }

        } catch (Exception $e) {
            $response = array(
                'status'  => FALSE,
                'reason'  => $e->getMessage(),
                'request' => $id
            );
        }
        $this->response($response);
    }

    /**
     * as the name explains,
     * returns YES or no,
     * if the FTP is used in any of the projects.
     */
    public function get_isftpinuse() {
        $id = Input::get('id');
        $branch = new Model_Branch();
        $deploy = new Model_Deploy();
        $branches = $branch->get_by_ftp_id($id);

        if (count($branches) !== 0) {
            $deploy_data = $deploy->get($branches[0]['deploy_id']);
            $deploy_name = $deploy_data[0]['name'];
            $branches[0]['project_name'] = $deploy_name;
        }

        $this->response(array(
            'status'  => (count($branches) == 0) ? FALSE : TRUE,
            'used_in' => (count($branches) == 0) ? FALSE : $branches,
        ));
    }

    /**
     * Delete a FTP server by ID
     * @param type $id
     * @return type
     */
    public function action_delftp($id) {

        try {
            $ftp = new Model_Ftp();
            $row = $ftp->get($id);

            if (count($row) == 0) {
                throw new Exception('We got confused, please refresh the page and try again.');
            } else {
                $result = $ftp->delete($id);
                $response = array(
                    'status'  => TRUE,
                    'request' => Input::post()
                );
            }
        } catch (Exception $e) {
            $response = array(
                'status'  => FALSE,
                'request' => (Input::method() == 'POST') ? Input::post() : FALSE,
                'reason'  => 'Cound not insert the value'
            );
        }

        $this->response($response);
    }

}
