<?php

class Controller_Test extends Controller {
    public function before () {
        echo '<pre>';
    }

    public function get_b () {
        $deploy = \Gf\Deploy\Deploy::instance(23);
        $deploy->processProjectQueue(false);
    }

    public function get_la () {

        $gitApi = new \Gf\Git\GitApi(55266, \Gf\Auth\OAuth::provider_github);
        $response = $gitApi->api()->compareCommits('testrepo', 'craftpip', 'aasd', 'HEAD');

        print_r($response);
    }

    public function get_ss () {
//        \Session::set('hey', 'what');
//        $a = \Session::get($id);
//        print_r(unserialize($a));
//        $key = \Session::get($id);
//        $key = unserialize($key);
//        $public = $key['publickey'];
//        echo \Gf\Settings::get('gf_exception_debug');
//        echo \Gf\Path::get(4);
        echo \Session::get('58974400');
    }

    public function get_co () {
//        $url = 'sftp://ubuntu@52.28.221.93/var/www/html';
        $url = 'sftp://ubuntu@192.168.1.9/var/www/html';

        $options = [
            'pubkey' => [
                'pubkeyfile'  => '/var/www/html/pub',
                'privkeyfile' => '/var/www/html/priv',
                'user'        => 'ubuntu',
                'passphrase'  => false,
            ],
        ];

        $conn = new \Banago\Bridge\Bridge($url, $options);
        $a = $conn->ls();
        echo '<pre>';
        print_r($a);
        die;
    }

    public function get_gk () {

        print_r(Utils::get_new_openssh_public_private_pair());

        die;
        $rsa = new phpseclib\Crypt\RSA();
        $rsa->setPublicKeyFormat(6); // CRYPT_RSA_PUBLIC_FORMAT_OPENSSH is 6
        $rsa->comment = 'Something';
        $keys = $rsa->createKey();
        $publickey = $keys['publickey'];
        $privatekey = $keys['privatekey'];
        echo "$publickey\r\n\r\n$privatekey";
    }

    public function get_getKey () {
        $config = [
            "digest_alg"       => "sha512",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ];
        $res = openssl_pkey_new($config);
        // Extract the private key from $res to $privKey
        openssl_pkey_export($res, $privKey);

        // Extract the public key from $res to $pubKey
        $pubKey = openssl_pkey_get_details($res);
        $pubKey = $pubKey["key"];

        echo $pubKey;
        echo '<br>';
        echo $privKey;
    }

    public function get_eve () {
//        echo '<pre>';
//        print_r(\Fuel\Core\Cache::get('p'));
//        die;
//        $a = DB::select()->from('pages')->cached(0)->execute('frontend')->as_array();
//        $a = DB::select()->from('pages')->execute('frontend')->as_array();
//        echo '<pre>';
//        print_r($a);
//        die;
//        asdasdas
    }

    public function get_eva () {
        $process = new \Symfony\Component\Process\Process('ls -la');
        $process->start();
        try {
            $processes = \Fuel\Core\Cache::get('p', false);
        } catch (Exception $e) {
            $processes = [];
        }
        $process->isRunning();
        $processes[] = [
            'pid' => $process->getPid(),
            'did' => 12,
        ];
        \Fuel\Core\Cache::set('p.asd.sa.da', $processes, false);
    }

    public
    function get_r () {
        $id = '18';
        $path = '/var/www/html/fuel/repository/228/test';
        if (file_exists($path)) {
            $process = new \Symfony\Component\Process\Process('rm -rf ' . $path);
            $process->run();
            if ($process->isSuccessful()) {
                print_r($process->getOutput());
            } else {
                print_r($process->getErrorOutput());
            }
        } else {
            echo 'no';
        }
    }

    public
    function get_p () {
//        $gitapi = new \Craftpip\GitApi();
//        $a = $gitapi->auth->getToken('bitbucket');
//
//        print_r($a);
//        echo '<pre>';
//
//        \Database_Connection::instance()->disconnect();
//        \Config::set('db.active','frontend');
//        $a = \DB::select('*')->from('seo')->execute('frontend')->as_array();
//
//        print_r($a);
//        die;
        $mail = new \Craftpip\Mail(229);
        $mail->template_forgotpassword();
        $mail->to('bonifacepereira@gmail.com', 'Boniface pereira');
        $mail->send();
    }

    public
    function get_o () {
        $gitapi = new \Craftpip\GitApi();
//        $repo = $gitapi->loadApi('bitbucket')->getHook('testrepo');
        $repo = $gitapi->loadApi('bitbucket')->updateHook('testrepo', '{3bf36961-ba9d-41b2-8655-3c4c0119f78c}', 'http://craftpip.com');
//        $repo = $gitapi->loadApi('bitbucket')->removeHook('testrepo', '{183c8b91-ec25-47a1-9e90-0a7e04e5b369}');
        print_r($repo);
//        $auth = new \Craftpip\OAuth\OAuth();
//        $token = $auth->getToken('bitbucket');
//        $refresh_token = $token->getrefreshToken();
    }

    public
    function get_q () {
        $a = 'https://ab44005618fb9022aa617cd65e02bb1f754217a6@github.com/craftpip/testrepo.git';
        $b = \Utils::gitGetBranches2($a);
        print_r($b);
        die;
    }

    public
    function action_authtest ($provider) {
        $auth = new \Craftpip\Oauth\Oauth();
        $a = $auth->init($provider);
        print_r($a);
    }

    public
    function action_gtest () {
//        $instance = new \Bitbucket\API\Users();
//        $instance->getClient()->addListener(
//            new \Bitbucket\API\Http\Listener\OAuthListener(array(
//                'oauth_consumer_key'    => 'mVjq4uHZzXpQrEggG3',
//                'oauth_consumer_secret' => '3SuqwYwTPURaGsx54cZeCXxxxvvfLvTQ',
//                'oauth_token'           => 'ST0gyfNOoDpQhSLrSe_tzrbVoVG825x_FUvylTt9sYO-H7PmtX2_AeT7ZmXU78LyLzJEabEDdqouJCCq',
//            ))
//        );
//
//        echo $instance->repositories('craftpip');

        $client = new GuzzleHttp\Client();

//        $client->
        $res = $client->get('https://api.bitbucket.org/2.0/user/emails', [
//            'query' => ['access_token' => 'ST0gyfNOoDpQhSLrSe_tzrbVoVG825x_FUvylTt9sYO-H7PmtX2_AeT7ZmXU78LyLzJEabEDdqouJCCq']
            'headers' => ['Authorization' => 'Bearer iNdx_7fgV_FcyKJW1zhI0Iy7OzozWnEupS0gieLeafhy6b6bjbNb3AZH_cM6FigOPejFlh8MTBf4GSRUXQ=='],
        ]);

//        $res = $client->get('https://api.bitbucket.org/2.0/repositories/craftpip', [
//            'headers' => ['Authorization' => 'Bearer ST0gyfNOoDpQhSLrSe_tzrbVoVG825x_FUvylTt9sYO-H7PmtX2_AeT7ZmXU78LyLzJEabEDdqouJCCq']
//        ]);

//        $res = $client->get('https://api.bitbucket.org/2.0/repositories/craftpip?access_token=ST0gyfNOoDpQhSLrSe_tzrbVoVG825x_FUvylTt9sYO-H7PmtX2_AeT7ZmXU78LyLzJEabEDdqouJCCq');
        echo $res->getStatusCode();
        echo $res->getBody();

//        $headers = ['hey' => 'something'];
//        $request = new GuzzleHttp\Psr7\Request('GET', 'https://api.bitbucket.org/2.0/repositories/craftpip', $headers);
    }

    public
    function get_bb () {
        $provider = new \Stevenmaguire\OAuth2\Client\Provider\Bitbucket([
            'clientId'     => 'ZHqyDjdsukYXpu5DJD',
            'clientSecret' => 'mvGtbMXbJPkesfVJ7Xfg5hzE9uRw32gG',
            'redirectUri'  => 'http://stg.gitftp.com/test/bb',
        ]);

        if (!isset($_GET['code'])) {
            // If we don't have an authorization code then get one
            $authUrl = $provider->getAuthorizationUrl();
            $_SESSION['oauth2state'] = $provider->getState();
//            print_r($provider);
//            die;
            echo $authUrl;
//            die();
            header('Location: ' . $authUrl);
            exit;

            // Check given state against previously stored one to mitigate CSRF attack
//        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

//            unset($_SESSION['oauth2state']);
//            exit('Invalid state');

        } else {

            // Try to get an access token (using the authorization code grant)
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code'],
            ]);

            // Optional: Now you have a token you can look up a users profile data
            try {
                // We got an access token, let's now get the user's details
                $user = $provider->getResourceOwner($token);

                // Use these details to create a new profile
                printf('Hello %s!', $user->getId());

            } catch (Exception $e) {

                // Failed to get user details
                exit('Oh dear...');
            }

            // Use this to interact with an API on the users behalf
            echo $token->getToken();
        }
    }

    public
    function get_ab () {
        $record = new Model_Record();
        $record->insert([
            'deploy_id' => '30',
//            'record_type' => $record->type_service,
//            'branch_id'   => '57',
            'date'      => time(),
            'status'    => $record->in_queue,
            'triggerby' => 'Boniface',
            'hash'      => '',
        ]);

        Gfcore::deploy_in_bg('30');
    }

    public
    function get_test () {
        $a = DB::select()->from('deploy')->execute()->as_array();
        print_r($a);
    }

    public
    function get_test2 () {
        $files = [
            'folder/folder2/',
            'folder/folder2/',
            'asda/asdsada/',
            'asda/',
        ];

        $merged = [];
        foreach ($files as $v) {
            foreach ($merged as $m) {

            }
        }
        print_r($files);
//        echo utils::get_repo_dir(12);
//        die();
//        $a = '/asdsadsa/asd';
//
//        if(substr($a, 0, 1) == '/'){
//            echo substr($a, 1, strlen($a));
//        }

//        -------------------

//        chdir('/var/www/html/fuel/repository/228/39');
//        exec('git branch -r --contains 3071977f63c9aa67e28c98cd95b0dae7b1d1ade0',$a);
//        exec('git branch', $a);
//        print_r($a);
    }

    public
    function get_a () {
        $a = 'ftp_chdir(): CWD failed. "/asdsad": directory not found';
        $b = explode(': ', $a);
        print_r($b[count($b) - 1]);
    }

    public
    function get_purge () {
        $ftp = new Model_Ftp();
        $d = $ftp->get(130);
        $d = $d[0];
        $d['user'] = $d['username'];
        $s = http_build_url($d);
        $conn = new \Banago\Bridge\Bridge($s);
        $purge = ['images'];
//        $this->purge($purge);
        $origin = $conn->pwd();
        foreach ($purge as $dir) {
            $this->delete($dir, $conn, $origin);
        }
    }

    public
    function delete ($dir, $conn, $o) {
        $list = $conn->ls($o . '/' . $dir);
        foreach ($list as $item) {
            echo $item;
        }
    }

    public
    function get_e () {
//        echo strtotime('Tue, 21 Aug 2012 19:50:37 +0900');
        echo strtotime('2015-07-23 20:46:36');
    }

    public
    function get_c () {
//        echo Fuel::$env;
//        echo Crypt::encode('asda', 'randomcode');
//        $response = new Response();
//        $response->set_status(404);
//        echo $response->send();
        throw new Exception('No', 503);
    }

    public
    function get_dbspeed () {
        $deploy = new Model_Deploy();
        $a = $deploy->get(47, null, true);
        print_r($a);
    }

    public
    function get_d () {

//        $a = '{"actor": {"display_name": "boniface pereira", "username": "craftpip", "links": {"self": {"href": "https://api.bitbucket.org/2.0/users/craftpip"}, "avatar": {"href": "https:/' ;
//        echo substr($a, 0, 1);
//        $deploy_id
//        utils::gitGetBranches_local($branch_data['deploy_id'], $hash)

        $a = DB::select()->from('log')->where('id', $_GET['id'])->execute()->as_array();
        $a = unserialize($a[0]['a']);
        print_r($a);

    }

    public
    function get_logs () {
        $a = DB::select()->from('log')->order_by('id', 'desc')->execute()->as_array();
        print_r($a);
    }

    public
    function get_f () {
        $p = 'zombieismyname191993bit';
        echo $nhash = \Crypt::instance()->encode($p);
        echo '<br>';
        echo \Crypt::instance()->decode($nhash);
    }

    public
    function get_email () {
        $email = new \Craftpip\Mail();
        $email = $email->template_signup();
        try {
            $email->send();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public
    function get_g () {
        $a = new \Craftpip\Gitapi();
    }

    public
    function get_h () {
        $b = "\Craftpip\OAuth\OAuth";
        $o = new $b();
        $a = $o->getToken('github');
        print_r($a);
    }

    public
    function get_i () {

        $user = new \Craftpip\OAuth\Auth();
        $providers = $user->getProviders();
        $token = $providers[0]['access_token'];
        $client = new \Github\Client();
        $client->authenticate($token, '', \Github\Client::AUTH_HTTP_TOKEN);
//        $repo = $client->api('repo')->create('my-new-repo', 'This is the description of a repo', 'http://my-repo-homepage.org', true);

        $hooks = $client->api('repo')->hooks()->all($user->getAttr('github'), 'testrepo');

        $hooks = $client->api('repo')->hooks()->create($user->getAttr('github'), 'testrepo', [
            'name'   => 'web',
            'config' => [
                "url"          => dash_url . 'hook/i/' . $user->user_id . '/60/1180ff37e8eb3bee',
                "content_type" => "json",
            ],
            'events' => ['push'],
            'active' => 1,
        ]);

        print_r($hooks);
    }

    public
    function get_j () {
        $gitapi = new \Craftpip\GitApi();
        $a = $gitapi->getAllRepositories();

        print_r($a);
    }

    public
    function get_k () {
        $path = Utils::get_repo_dir(48);
        $git = new \Craftpip\Git();
        $git->setRepository($path);
        print_r($git->logBetween('c657d1c80', '58efdc'));
    }

    public
    function get_login () {
        if (\Auth::instance()->login('boniface', 'asdasd')) {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    public
    function get_checklogin () {
        if (\Auth::instance()->check()) {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    public
    function get_l () {
        $gitapi = new \Craftpip\GitApi();
        $a = $gitapi->getRepositories();
//        $a = $gitapi->loadApi('bitbucket')->getRepositories();
        print_r($a);
    }

    public
    function get_m () {
        $gitapi = new \Craftpip\GitApi();
        $a = $gitapi->loadApi('bitbucket');
//        print_r($a);
//        die();
        $url = $gitapi->buildHookUrl(25, Str::random());
//        $b = $gitapi->api->setHook('testrepo', $url);
        $b = $gitapi->api->getHook('testrepo', '90f41620-7876-45e8-9171-b3f1584ea066');
//        print_r($b);
        $b = $gitapi->api->updateHook('testrepo', '90f41620-7876-45e8-9171-b3a1584ea066', $url);
        print_r($b);
//        $b = $gitapi->api->getHook('testrepo', '5565637');
//        print_r($b);
    }

    public
    function get_n () {
        $gitapi = new \Craftpip\GitApi();
        $a = $gitapi->loadApi('bitbucket')->getRepositories();
        print_r($a);
    }
}
