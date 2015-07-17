<?php

class Controller_Api_Ftp extends Controller_Apilogincheck {

    public function action_index() {

    }

    /**
     * List one or more FTP.
     * @param type $id
     * @return type
     */
    public function action_get($id = NULL) {

        $ftp = new Model_Ftp();
        $data = $ftp->get($id);

        $data = utils::strip_passwords($data);

        echo json_encode(array(
            'status' => TRUE,
            'data'   => $data
        ));

    }

    public function post_testftp($a = NULL, $return = FALSE) {
        $i = Input::post();
        try {

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
                 * Tkae the password that is stored with us.
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
            if (utils::test_ftp($ftp_url)) {
                if (!$return) {
                    echo json_encode(array(
                        'status' => TRUE
                    ));
                }
            } else {
                throw new Exception('Could not connect');
            }

        } catch (Exception $e) {
            if (!$return) {
                echo json_encode([
                    'status' => FALSE,
                    'reason' => $e->getMessage()
                ]);
            }

            if ($return) return $e->getMessage();
        }

        if ($return) return TRUE;
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
        try {

            $ftp = new Model_Ftp();

            $stripformatch = $data;
            if(isset($data['name']))
                unset($stripformatch['name']);

            $existing = $ftp->match($stripformatch);

            if (count($existing) > 0) {
                $response = json_encode(array(
                    'status'  => FALSE,
                    'request' => Input::post(),
                    'reason'  => 'Sorry, A FTP account "'.$existing[0]['name'].'" with the same configuration already exist in your account.'
                ));
            } else {
                $a = $ftp->insert($data);
                if ($a) {
                    $response = json_encode(array(
                        'status'  => TRUE,
                        'request' => Input::post()
                    ));
                }
            }

        } catch (Exception $e) {
            $response = json_encode([
                'status'  => FALSE,
                'reason'  => $e->getMessage(),
                'request' => (Input::method() == 'POST') ? Input::post() : ''
            ]);
        }

        echo $response;

    }

    /**
     * editing a FTP server.
     * @return boolean
     */
    public function post_editftp($id) {

        try {
            $ftp = new Model_Ftp();
            $data = Input::post();
            $a = $ftp->set($id, $data);

            if ($a || FALSE) {
                $response = json_encode(array(
                    'status'  => TRUE,
                    'request' => Input::post(),
                ));
            } else {
                $response = json_encode(array(
                    'status' => FALSE,
                    'reason' => 'Cannot update with the same values.',
                    'asd'    => $a
                ));
            }

        } catch (Exception $e) {
            $response = json_encode(array(
                'status'  => FALSE,
                'reason'  => $e->getMessage(),
                'request' => $id
            ));
        }
        echo $response;
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
        echo json_encode([
            'status'  => (count($branches) == 0) ? FALSE : TRUE,
            'used_in' => (count($branches) == 0) ? FALSE : $branches,
        ]);
    }

    /**
     * Delete a FTP server by ID
     * @param type $id
     * @return type
     */
    public function action_delftp($id) {

        $ftp = new Model_Ftp();
        $row = $ftp->get($id);

        if (count($row) == 0) {
            echo json_encode(array(
                'status'  => FALSE,
                'request' => Input::post(),
                'reason'  => 'We got confused, please refresh the page and try again.'
            ));
        } else {

            $result = $ftp->delete($id);

            if ($result) {
                echo json_encode(array(
                    'status'  => TRUE,
                    'request' => Input::post()
                ));
            } else {
                echo json_encode(array(
                    'status'  => FALSE,
                    'request' => Input::post(),
                    'reason'  => 'Cound not insert the value'
                ));
            }
        }
    }

}
