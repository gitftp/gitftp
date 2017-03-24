<?php

class Controller_Api_Ftp extends Controller_Api_Apilogincheck {

    public function get_unused () {
        try {
            $ftp = new \Model_Ftp();
            $unusedftp = $ftp->getUnused();

            $response = [
                'status' => true,
                'data'   => $unusedftp,
            ];
        } catch (Exception $e) {
            $e = new \Craftpip\Exception($e->getMessage(), $e->getCode());
            $response = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }
        $this->response($response);
    }

    /**
     * List one or more FTP.
     *
     * @param type $id
     *
     * @return type
     */
    public function action_get ($id = null) {
        try {
            $ftp = new \Model_Ftp();
            $data = $ftp->get($id);
            $data = \Utils::strip_passwords($data);

            if (!is_null($id)) {
                foreach ($data as $d => $a) {
                    if (empty($a['pub']) || empty($a['priv'])) continue;

                    $public = $ftp->getKeyContents($a['fspath'], $a['pub']);
                    $data[$d]['command'] = "echo -e '$public' >> ~/.ssh/authorized_keys <br>chmod 0600 ~/.ssh/authorized_keys";;
                }
            }

            $response = [
                'status' => true,
                'data'   => $data,
            ];
        } catch (Exception $e) {
            $e = new \Craftpip\Exception($e->getMessage(), $e->getCode());
            $response = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }

        $this->response($response);
    }

    public function get_authkey ($id = null) {
        try {
            if (is_null($id)) {
                $id = \Str::random('numeric', 8);
                $key = \Utils::get_new_openssh_public_private_pair();
                $life = \Gf\Settings::get('ftp_temp_key_cache_life');
                \Cache::set('key.' . $id, serialize($key), (int)$life);
                $public = $key['publickey'];
            } else {
                $key = \Cache::get('key.' . $id);
                $key = unserialize($key);
                $public = $key['publickey'];
            }
            $command = "echo -e '$public' >> ~/.ssh/authorized_keys <br>chmod 0600 ~/.ssh/authorized_keys";
            $response = [
                'status' => true,
                'data'   => [
                    'id'      => $id,
                    'command' => $command,
                ],
            ];

        } catch (Exception $e) {
            $e = new \Craftpip\Exception($e->getMessage(), $e->getCode());
            $response = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }
        $this->response($response);
    }

    /**
     * test connection to a ftp server.
     * todo: delete this
     *
     * @param null $a
     * @param bool $return
     */
    public function post_testwasted ($a = null, $return = false) {
        return false;
        $i = Input::post();

        try {
            if (!isset($i['host']) || !isset($i['scheme'])) {
                throw new \Craftpip\Exception('Please enter necessary details to connect to your Server.');
            } elseif (trim($i['host']) == '' || trim($i['scheme']) == '') {
                throw new \Craftpip\Exception('Please enter necessary details to connect to your Server.');
            }

            function error_handler ($errno, $errstr, $errfile, $errline) {
//                echo $errstr;
                $response = [
                    'status' => false,
                    'reason' => $errstr,
                ];
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
                $options['ssl'] = false;
                $options['passive'] = true;
                $adapter = new \League\Flysystem\Adapter\Ftp($options);
            } elseif ($i['scheme'] == 'ftps') {
                $options['ssl'] = true;
                $options['passive'] = true;
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
                $files = $fs->listContents($i['path'], true);
                print_r($files);
            }

            $response = [
                'status'  => true,
                'message' => $message,
            ];
        } catch (\Fuel\Core\PhpErrorException $e) {
            echo $e;
            throw $e;
            $response = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }

        $this->response($response);
    }

    /**
     * test connection to a ftp server.
     *
     * @param null $a
     * @param bool $return
     */
    public function post_test ($a = null, $return = false) {
        $i = Input::post();

        try {
            $message = '';
            $scheme = \Input::post('scheme', false);
            $host = \Input::post('host', false);
            $key_id = \Input::post('ssh-k', false);
            $id = \Input::post('id', false);
            $username = \Input::post('username', '');
            $is_pass = isset($i['pass']);
            $pass = \Input::post('pass', '');
            $port = \Input::post('port', 21); // default to 21.
            $is_key = \Input::post('publickey', false);
            $path = \Input::post('path', false);
            $to_removeTempKey = false;
            $ftp = new \Model_Ftp();

            $options = [
                'user'   => $username,
                'host'   => $host,
                'pass'   => $pass,
                'scheme' => $scheme,
                'port'   => $port,
            ];

            $configs = [
                'timeout' => 20,
            ];

            if ($id) {
                $ftp_data = $ftp->get($id);
                if (!count($ftp_data)) throw new \Craftpip\Exception('Something is not right, we could not find the FTP configuration. Please refresh the page try again.');

                $ftp_data = $ftp_data[0];
            }

            if (!$scheme or !$host or !$path) {
                throw new \Craftpip\Exception('Please enter necessary details to connect to your Server.');
            } else if (trim($scheme) == '' or trim($host) == '') {
                throw new \Craftpip\Exception('Please enter necessary details to connect to your Server.');
            }

            if (!$is_pass && $id) {
                // password not provided. get the password from database.
                if (!empty($ftp_data['pass'])) $options['pass'] = $ftp_data['pass'];
            }

            if ($is_key && $scheme == 'sftp') {
                // add key authentication to configuration.
                $auth = new \Craftpip\OAuth\Auth();
                $options['pass'] = null;

                if (empty($key_id) && $id) {
                    // key file not avail coz its already saved.
                    if (empty($ftp_data['fspath'])) $pathId = \Gf\Settings::get('ftp_key_create_path_id'); else
                        $pathId = $ftp_data['fspath'];
                    $pathStore = \Gf\Path::get($pathId);
                    $pathStore .= '/';

                    if (empty($ftp_data['priv']) or empty($ftp_data['pub'])) {
                        logger(600, "User $auth->user_id FTP $id Error 20007", __METHOD__);
                        throw new \Craftpip\Exception('Error 20007: Something is not right, please contact support.');
                    }

                    $privateKey = $pathStore . $auth->user_id . '/' . $ftp_data['priv'];
                    $publicKey = $pathStore . $auth->user_id . '/' . $ftp_data['pub'];
                } elseif ($key_id) {
                    $tmpPath = \Gf\Settings::get('ftp_key_temp_path');
                    $tmpPath .= '/';

                    $pubKey = \Str::random('num');
                    $privKey = \Str::random('num');

                    try {
                        $keys = \Cache::get("key.$key_id", null);
                    } catch (\Exception $e) {
                        throw new \Craftpip\Exception('The SSH key pair has expired, please reload your browser & try again.');
                    }

                    if (!\Str::is_serialized($keys)) throw new \Craftpip\Exception('The SSH key pair has expired, please reload your browser & try again.');
                    $keys = unserialize($keys);
                    \File::create($tmpPath, $pubKey, $keys['publickey']);
                    \File::create($tmpPath, $privKey, $keys['privatekey']);

                    $privateKey = $tmpPath . '/' . $privKey;
                    $publicKey = $tmpPath . '/' . $pubKey;
                    $to_removeTempKey = 1;
                }

                $configs['pubkey']['privkeyfile'] = $privateKey;
                $configs['pubkey']['pubkeyfile'] = $publicKey;
                $configs['pubkey']['user'] = $username;
                $configs['pubkey']['passphrase'] = false;
            }

            $ftp_url = http_build_url($options);
            try {
                $conn = new \Banago\Bridge\Bridge($ftp_url, $configs);
            } catch (Exception $e) {
                $m = $e->getMessage();
//                list(, $m) = explode(':', $m);
                $m = \Str::sub($m, strrpos($m, ':') + 1, strlen($m));
                throw new \Craftpip\Exception('We tried hard connecting: ' . $m);
            }

            $message .= '<i class="fa ti-check fa-fw green"></i> Connected successfully.';

            if (!\Str::starts_with($path, '/')) $path = '/' . $path;

            if (!$conn->exists($path)) {
                try {
                    $conn->mkdir($path);
                    $message .= '<br><i class="fa fa-fw ti-check green"></i> Created directory ' . $path;
                } catch (Exception $e) {
                    throw new \Craftpip\Exception('Failed to create directory: ' . $path . ', please check for permissions or manually create the directory.');
                }
            }

            try {
                $conn->cd($path);
                $listing = $conn->ls();
                if (count($listing)) {
                    $message .= '<br><i class="fa fa-fw ti-info-alt blue"></i> The remote directory is not empty.';
                }
            } catch (Exception $e) {
                throw new \Craftpip\Exception('Could not access remote path');
            }
            if (!\Str::ends_with($path, '/')) $path .= '/';
            $testFileName = 'gitftp-test-' . \Str::random('num', 4);
            try {
                $conn->cd('/');
                $conn->put('This file was used by Gitftp to test connection to this server, its safe to delete this file.', $path . $testFileName);
                $message .= '<br><i class="fa fa-fw ti-check green"></i> Created a test file: ' . $testFileName;
            } catch (Exception $e) {
                throw new \Craftpip\Exception('User "' . $username . '" does not have write permission to the directory: ' . $path);
            }

            try {
                $conn->rm($path . $testFileName);
                $message .= '<br><i class="fa fa-fw ti-check green"></i> Removed test file';
            } catch (Exception $e) {
                throw new \Craftpip\Exception('Could not remove test file: ' . $e->getMessage());
            }


            $response = [
                'status'  => true,
                'message' => $message,
            ];
        } catch (\Exception $e) {
            $e = new \Craftpip\Exception($e->getMessage(), $e->getCode());
            if ($message != '') $message .= '<br>';
            $message .= '<i class="fa ti-alert red fa-fw"></i> ' . $e->getMessage();
            $response = [
                'status'  => false,
                'message' => $message,
            ];
        }
        if ($to_removeTempKey) {
            \File::delete($privateKey);
            \File::delete($publicKey);
        }
        $this->response($response);
    }

    /**
     * adding a FTP server.
     *
     * @return boolean
     */
    public function post_add () {
        /**
         * test ftp before adding,
         */

        try {
            $data = \Utils::escapeHtmlChars(\Input::post());
            $ftp = new Model_Ftp();
            $pathId = \Gf\Settings::get('ftp_key_create_path_id');
            $path = \Gf\Path::get($pathId);
            $path .= '/'; //append to path.
            $pubKey = '';
            $privKey = '';
            $key_id = false;

            if (\Input::post('scheme') == 'sftp' && \Input::post('publickey', false)) {
                $data['pass'] = '';
                $auth = new \Craftpip\OAuth\Auth();
                $pubKey = \Str::random('num');
                $privKey = \Str::random('num');
                if (!is_dir($path . $auth->user_id)) {
                    \File::create_dir($path, $auth->user_id, 0777);
                }
                $key_id = \Input::post('ssh-k', '');
                if (empty($key_id)) {
                    throw new \Craftpip\Exception('Something is not right, please reload your browser & try again.');
                }
                try {
                    $keys = \Cache::get("key.$key_id", null);
                } catch (\Exception $e) {
                    throw new \Craftpip\Exception('The SSH key pair has expired, please reload your browser & try again.');
                }
                if (!\Str::is_serialized($keys)) throw new \Craftpip\Exception('The SSH key pair has expired, please reload your browser & try again.');
                $keys = unserialize($keys);
                \File::create($path . $auth->user_id, $pubKey, $keys['publickey']);
                \File::create($path . $auth->user_id, $privKey, $keys['privatekey']);
                // create the key files.
            }
            $set = [
                'name'     => $data['name'],
                'username' => $data['username'],
                'port'     => $data['port'],
                'scheme'   => $data['scheme'],
                'path'     => $data['path'],
                'host'     => $data['host'],
                'pass'     => $data['pass'],
                'fspath'   => $pathId,
                'pub'      => $pubKey,
                'priv'     => $privKey,
            ];

            $a = $ftp->insert($set);
            if ($a) {

                try {
                    if ($key_id) \Cache::delete("key.$key_id");
                } catch (Exception $e) {
                }

                $response = [
                    'status'  => true,
                    'request' => Input::post(),
                ];
            }
        } catch (Exception $e) {
            $e = new \Craftpip\Exception($e->getMessage(), $e->getCode());
            $response = [
                'status'  => false,
                'reason'  => $e->getMessage(),
                'request' => (Input::method() == 'POST') ? Input::post() : '',
            ];
        }
        $this->response($response);
    }

    /**
     * editing a FTP server by id.
     *
     * @return boolean
     */
    public function post_edit ($id) {

        try {
            $ftp = new \Model_Ftp();
            $data = \Utils::escapeHtmlChars(\Input::post());
            $ftp_data = $ftp->get($id);
            if (!count($ftp_data)) throw new \Craftpip\Exception('Could not find the Server Configuration');
            $ftp_data = $ftp_data[0];
            $pubKey = $ftp_data['pub'];
            $privKey = $ftp_data['priv'];
            $toDeleteKey = 0;
            $toClearCache = 0;

            if (empty($ftp_data['fspath'])) $pathId = \Gf\Settings::get('ftp_key_create_path_id'); else
                $pathId = $ftp_data['fspath'];

            if (isset($_POST['pass'])) $data['pass'] = \Input::post('pass');

            $path = \Gf\Path::get($pathId);
            $path .= '/';
            $auth = new \Craftpip\OAuth\Auth();

            if (\Input::post('scheme') == 'ftps' || \Input::post('scheme') == 'ftp') {
                if (!empty($privKey) || !empty($pubKey)) $toDeleteKey = 1;
                $privKey = '';
                $pubKey = '';
                $toDeleteKey = 1;
            } elseif (\Input::post('scheme') == 'sftp' && \Input::post('publickey', false)) {
                $data['pass'] = null;

                $key_id = \Input::post('ssh-k', '');
                if (empty($key_id)) {
                    // the key is already created. nothing to do.
                } else {
                    // the key is not created, the user has just switched to SSH
                    $pubKey = \Str::random('num');
                    $privKey = \Str::random('num');
                    if (!is_dir($path . $auth->user_id)) {
                        \File::create_dir($path, $auth->user_id, 0777);
                    }
                    try {
                        $keys = \Cache::get("key.$key_id", null);
                    } catch (\Exception $e) {
                        throw new \Craftpip\Exception('The SSH key pair has expired, please reload your browser & try again.');
                    }
                    if (!\Str::is_serialized($keys)) throw new \Craftpip\Exception('The SSH key pair has expired, please reload your browser & try again.');
                    $keys = unserialize($keys);
                    \File::create($path . $auth->user_id, $pubKey, $keys['publickey']);
                    \File::create($path . $auth->user_id, $privKey, $keys['privatekey']);
                    $toClearCache = 1;
                }
            } elseif (!\Input::post('publickey', false) && !empty($pubKey) && !empty($privKey)) {
                $pubKey = '';
                $privKey = '';
                $toDeleteKey = 1;
            }

            $set = [
                'name'     => $data['name'],
                'username' => $data['username'],
                'port'     => $data['port'],
                'scheme'   => $data['scheme'],
                'path'     => $data['path'],
                'host'     => $data['host'],
                'fspath'   => $pathId,
                'pub'      => $pubKey,
                'priv'     => $privKey,
            ];

            if (isset($data['pass'])) $set['pass'] = $data['pass'];

            $a = $ftp->set($id, $set);

            try {
                if ($toClearCache) \Cache::delete("key.$key_id");
                if ($toDeleteKey) {
                    \File::delete($path . $auth->user_id . '/' . $ftp_data['pub']);
                    \File::delete($path . $auth->user_id . '/' . $ftp_data['priv']);
                }
            } catch (Exception $e) {
            }

            $response = [
                'status'  => true,
                'request' => Input::post(),
            ];

        } catch (Exception $e) {
            $e = new \Craftpip\Exception($e->getMessage(), $e->getCode());
            $response = [
                'status'  => false,
                'reason'  => $e->getMessage(),
                'request' => $id,
            ];
        }
        $this->response($response);
    }

    /**
     * as the name explains,
     * returns YES or no,
     * if the FTP is used in any of the projects.
     */
    public function get_isftpinuse () {
        $id = Input::get('id');
        $branch = new Model_Branch();
        $deploy = new Model_Deploy();
        $branches = $branch->get_by_ftp_id($id);

        if (count($branches) !== 0) {
            $deploy_data = $deploy->get($branches[0]['deploy_id']);
            $deploy_name = $deploy_data[0]['name'];
            $branches[0]['project_name'] = $deploy_name;
        }

        $this->response([
            'status'  => (count($branches) == 0) ? false : true,
            'used_in' => (count($branches) == 0) ? false : $branches,
        ]);
    }

    /**
     * Delete a FTP server by ID
     *
     * @param type $id
     *
     * @return type
     */
    public function action_delftp ($id) {

        try {
            $ftp = new Model_Ftp();
            $ftp_data = $ftp->get($id);

            if (count($ftp_data) == 0) {
                throw new \Craftpip\Exception('We got confused, please refresh the page and try again.');
            } else {
                $ftp_data = $ftp_data[0];
                $result = $ftp->delete($id);
                if ($result) {
                    $auth = new \Craftpip\OAuth\Auth();
                    $path = \Gf\Path::get($ftp_data['fspath']);
                    $path .= '/';
                    if (!empty($ftp_data['pub'])) \File::delete($path . $auth->user_id . '/' . $ftp_data['pub']);
                    if (!empty($ftp_data['priv'])) \File::delete($path . $auth->user_id . '/' . $ftp_data['priv']);
                    $response = [
                        'status'  => true,
                        'request' => Input::post(),
                    ];
                }
            }
        } catch (Exception $e) {
            $e = new \Craftpip\Exception($e->getMessage(), $e->getCode());
            $response = [
                'status'  => false,
                'request' => (Input::method() == 'POST') ? Input::post() : false,
                'reason'  => $e->getMessage(),
            ];
        }

        $this->response($response);
    }

}
