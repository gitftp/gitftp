<?php

class utils {


    public static function gitCommand($command, $repoPath = NULL) {
        if (!$repoPath) {
            $repoPath = getcwd();
        }

        $command = 'git --git-dir="' . $repoPath . '/.git" --work-tree="' . $repoPath . '" ' . $command;

        return utils::runCommand($command);
    }

    public static function runCommand($command) {
        // Escape special chars in string with a backslash
        $command = escapeshellcmd($command);
        exec($command, $output);

        return $output;
    }

    /**
     * Executes an Git command and returns the results.
     * if there is no output returns false.
     * $repo,
     * $username,
     * $password,
     *
     * @param type $arg
     */
    public static function gitGetBranches($repo, $username = NULL, $password = NULL) {
        $repo_url = parse_url($repo);

        if (!is_null($username)) {
            $repo_url['user'] = $username;
        }
        if (!is_null($password)) {
            $repo_url['pass'] = $password;
        }
        $repo = http_build_url($repo_url);

        if (trim($repo) == '') {
            return FALSE;
        }
        exec("git ls-remote --heads $repo", $op);
        if (empty($op)) return FALSE;

        foreach ($op as $k => $v) {
            $b = preg_split('/\s+/', $v);
            $b = explode('/', $b[1]);
            $op[$k] = $b[2];
        }

        return $op;
    }

    /**
     * Get avatar of an email address.
     *
     * @param type $email
     * @param type $s
     * @param type $d
     * @param type $r
     * @param type $img
     * @param type $atts
     * @return string
     */
    public static function get_gravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = FALSE, $atts = array()) {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val) $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }

        return $url;
    }

    /**
     * Test a ftp server, and if the path exists.
     *
     * @param $http_url
     * @throws Exception
     * @internal param type $a
     * @return string
     */

    public static function test_ftp($http_url) {
        try {
            $conn = new bridge($http_url);

            return TRUE;
        } catch (Exception $e) {
            $m = $e->getMessage();
            $m = explode(': ', $m);
            throw new Exception($m[count($m) - 1]);
        }
    }

    /**
     * Returns array
     * pushby
     * avatar_url
     * hash
     * post_data
     * commits
     *
     * @param type $input -> payload.
     * @return array
     */
    public static function parsePayload($i) {
        $service = 'none';

        if (isset($i['repository']['links']['self']['href'])) {
            if (preg_match('/bitbucket/i', $i['repository']['links']['self']['href'])) {
                $service = 'bitbucket';
//                utils::log('bitbucket');
            }
        }

        if (isset($i['repository'])) {
            if (isset($i['repository']['url'])) {
                if (preg_match('/github/i', $i['repository']['url'])) {
                    $service = 'github';
//                    utils::log('github');
                }
            }
        }

        if ($service == 'github') {
            $branch = $i['ref'];
            $branch = explode('/', $branch);
            $branch = $branch[count($branch) - 1];

            $commits = array();

            foreach ($i['commits'] as $commit) {
                $commits[] = array(
                    'hash'      => $commit['id'],
                    'message'   => $commit['message'],
                    'timestamp' => $commit['timestamp'],
                    'url'       => $commit['url'],
                    'committer' => $commit['committer'],
                );
            }

            return array(
                'user'       => $i['pusher']['name'],
                'avatar_url' => $i['sender']['avatar_url'],
                'hash'       => $i['after'],
                'post_data'  => serialize($i),
                'commits'    => serialize($commits),
                'branch'     => $branch
            );
        }

        // have to do same for bitbucket also
        if ($service == 'bitbucket') {

            $commits = array();
            $lc = count($i['push']['changes']) - 1;
            foreach ($i['push']['changes'] as $commit) {
                $commits[] = array(
                    'hash'      => $commit['new']['target']['hash'],
                    'message'   => $commit['new']['target']['message'],
                    'timestamp' => $commit['new']['target']['date'],
                    'url'       => $commit['links']['html']['href'],
                    'committer' => $commit['new']['target']['author']['user']['username'],
                );
            }

            $branch = $i['push']['changes'][$lc]['new']['name'];
            $avatar_url = $i['actor']['links']['avatar']['href'];
            $avatar_url = str_replace('32', '20', $avatar_url);

            return array(
                'user'       => $i['actor']['username'],
                'avatar_url' => $avatar_url,
                'hash'       => $i['push']['changes'][$lc]['new']['target']['hash'],
                'post_data'  => serialize($i),
                'commits'    => serialize($commits),
                'branch'     => $branch,
            );
        }
    }
    public static function parseProviderFromRepository($url){
        if(preg_match('/bitbucket/', strtolower($url))){
            return 'Bitbucket';
        }
        if(preg_match('/github/', strtolower($url))){
            return 'Github';
        }
    }
    public static function humanize_data($bytes) {
        $decimals = 2;
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }

    public static function strip_passwords($data) {
        foreach ($data as $k => $v) {
            if (isset($data[$k]['pass'])) {
                if (!empty($data[$k]['pass'])) {
                    $data[$k]['pset'] = TRUE;
                } else {
                    $data[$k]['pset'] = FALSE;
                }
                unset($data[$k]['pass']);
            }
            if (isset($data[$k]['password'])) {
                if (!empty($data[$k]['password'])) {
                    $data[$k]['pset'] = TRUE;
                } else {
                    $data[$k]['pset'] = FALSE;
                }
                unset($data[$k]['password']);
            }
        }

        return $data;
    }

    public static function log($string) {
        DB::insert('log')->set(array('a' => $string,))->execute();
    }

    public static function escapeHtmlChars($string, $except = array()) {

        if (is_array($string)) {
            foreach ($string as $k => $v) {
                if (!is_array($v) && $k !== 'password' && $k !== 'pass' && $k !== 'skip_path') {
                    $string[$k] = trim(htmlspecialchars($v, ENT_QUOTES));
                }
            }
        } else {
            $string = htmlspecialchars($string, ENT_QUOTES);
        }

        return $string;
    }

    public static function get_repo_dir($deploy_id, $user_id = NULL) {
        if (is_null($user_id)) {
            $user_id = Auth::get_user_id()[1];
        }

        return DOCROOT . 'fuel/repository/' . $user_id . '/' . $deploy_id;
    }

    public static function git_verify_hash($deploy_id, $hash) {
        $path = self::get_repo_dir($deploy_id);
        $origin = getcwd();
        chdir($path);
        $results = self::gitCommand('rev-parse --verify ' . $hash);
        chdir($origin);

        return (count($results)) ? $results[0] : FALSE;
    }
}

/* end of file auth.php */
