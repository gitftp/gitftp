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
    public function post_testwasted($a = NULL, $return = FALSE) {
        return FALSE;
        $i = Input::post();

        try {
            if (!isset($i['host']) || !isset($i['scheme'])) {
                throw new \Craftpip\Exception('Please enter necessary details to connect to your Server.');
            } elseif (trim($i['host']) == '' || trim($i['scheme']) == '') {
                throw new \Craftpip\Exception('Please enter necessary details to connect to your Server.');
            }

            function error_handler($errno, $errstr, $errfile, $errline) {
//                echo $errstr;
                $response = array(
                    'status' => FALSE,
                    'reason' => $errstr,
                );
            }

//            $old_error_handler = set_error_handler('error_handler');
            if (!isset($i['pass']) && isset($i['id'])) {
                /*
                 * Take the password that is stored with us.
                 */
                $ftp_id = $i['id'];
                $ftp_model = new Model_Ftp();
                $ftp_data = $ftp_model->get($ftp_id);
                if (count($ftp_data) !== 1) {
                    throw new \Craftpip\Exception('Ftp does not exist, or has been removed.');
                }
                $ftp_data = $ftp_data[0];
                if (!empty($ftp_data['pass'])) {
                    $i['pass'] = $ftp_data['pass'];
                }
            }

            $options = [
                'host'     => $i['host'],
                'username' => $i['username'],
                'password' => (isset($i['pass'])) ? $i['pass'] : '',
                'port'     => $i['port'],
                'timeout'  => 20,
            ];

            if ($i['scheme'] == 'ftp') {
                $options['ssl'] = FALSE;
                $options['passive'] = TRUE;
                $adapter = new \League\Flysystem\Adapter\Ftp($options);
            } elseif ($i['scheme'] == 'ftps') {
                $options['ssl'] = TRUE;
                $options['passive'] = TRUE;
                $adapter = new \League\Flysystem\Adapter\Ftp($options);
            } elseif ($i['scheme'] == 'sftp') {
//                $options['privateKey'] = 'path/to/privatekey';
                $adapter = new \League\Flysystem\Sftp\SftpAdapter($options);
            }

            $fs = new \League\Flysystem\Filesystem($adapter);
            $message = '';
            if (!$fs->has($i['path'])) {
                $fs->createDir($i['path']);
            } else {
                $files = $fs->listContents($i['path'], TRUE);
                print_r($files);
            }

            $response = array(
                'status'  => TRUE,
                'message' => $message,
            );
        } catch (\Fuel\Core\PhpErrorException $e) {
            echo $e;
            throw $e;
            $response = array(
                'status' => FALSE,
                'reason' => $e->getMessage(),
            );
        }

        $this->response($response);
    }

    /**
     * test connection to a ftp server.
     *
     * @param null $a
     * @param bool $return
     */
    public function post_test($a = NULL, $return = FALSE) {
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
//                'path'   => $i['path'],
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
            $conn = new \Banago\Bridge\Bridge($ftp_url, [
                'timeout' => 20
            ]);

            $message = 'Connected successfully.';
            if (!$conn->exists($i['path'])) {
                try {
                    $conn->mkdir($i['path']);
                    $message .= '<br>Created directory ' . $i['path'];
                } catch (Exception $e) {
                    $message .= '<br><i class="fa fa-warning orange"></i> Failed to create directory: ' . $i['path'] . ', please check for permissions or manually create the directory.';
                }
            } else {
//                $conn->cd($i['path']);
//                $files = $conn->ls();
//                if (count($files)) {
//                    $message .= '<br><i class="fa fa-info"></i> The Target path is not empty.';
//                }
            }

            $response = array(
                'status'  => TRUE,
                'message' => $message
            );

        } catch (\Exception $e) {
            $e = new \Craftpip\Exception($e->getMessage(), $e->getCode());
            $response = array(
                'status' => FALSE,
                'reason' => $e->getMessage(),
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

//            if ($a || FALSE) {
                $response = array(
                    'status'  => TRUE,
                    'request' => Input::post(),
                );
//            } else {
//                throw new Exception('No changes were saved.');
//            }

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
