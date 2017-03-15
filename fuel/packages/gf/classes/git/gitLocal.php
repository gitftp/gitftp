<?php
namespace Gf\Git;

use GitWrapper\GitWorkingCopy;
use GitWrapper\GitWrapper;

/**
 * A wrapper to the git wrapper class
 * wrapper inception
 * Class Git
 *
 * @package Gf
 */
class GitLocal {

    /**
     * @var GitLocal[]
     */
    public static $instance;

    /**
     * @var \GitWrapper\GitWorkingCopy
     */
    public $git;

    /**
     * @var GitWrapper
     */
    public $wrapper;

    /**
     * @param $pathToRepo
     *
     * @return GitLocal
     */
    public static function instance ($pathToRepo) {
        if (!isset(static::$instance[$pathToRepo]) or null == static::$instance[$pathToRepo]) {
            static::$instance[$pathToRepo] = new static($pathToRepo);
        }

        return self::$instance[$pathToRepo];
    }

    public function __construct ($pathToRepo) {
        $this->wrapper = new GitWrapper();
        $this->git = $this->wrapper->workingCopy($pathToRepo);
    }

    public function pull ($owner_id, $provider, $clone_uri) {
        $gitApi = GitApi::instance($owner_id, $provider);
        $clone_url = $gitApi->createAuthCloneUrl($clone_uri, $provider);
        $this->setRemoteOriginUrl($clone_url);
        $this->git->clearOutput();
        $this->git->checkout('master');
        $op = $this->git->pull();

        return $op->getOutput();
    }

    public function setRemoteOriginUrl ($url) {
        $this->git->run([
            'remote',
            'set-url',
            'origin',
            $url,
        ]);
    }

    /**
     * @param $clone_url
     *
     * @return bool|string
     */
    public function clone ($clone_url) {
        if (!$this->git->isCloned()) {
            $this->git = $this->git->cloneRepository($clone_url);
            $this->git->setCloned(true);

            return $this->git->getOutput();
        }

        return false;
    }


    /**
     * @todo: work required
     *
     * @param $hash
     *
     * @return mixed
     */
    public function verifyhash ($hash) {

        $process = $this->getProcessBuilder()
            ->add('rev-parse')
            ->add('--verify')
            ->add($hash)
            ->getProcess();

        $a = $this->run($process);

        return $a;
    }

    /**
     * @todo: work required
     * Get commits between to hash
     *
     * @param $from
     * @param $to
     */
    public function logBetween ($from, $to) {
        $process = $this->getProcessBuilder()
            ->add('log')
            ->add($from . '...')
            ->add('' . $to)
            ->add('--format=%H||%aN||%aE||%aD||%s')
            ->getProcess();

        $a = $this->run($process);
        $lines = $this->split($a);

        $commits = [];

        foreach ($lines as $line) {
            list($hash, $name, $email, $date, $title) = preg_split('/\|\|/', $line, -1, PREG_SPLIT_NO_EMPTY);
            $commits[] = [
                'hash'  => $hash,
                'name'  => $name,
                'email' => $email,
                'date'  => $date,
                'title' => $title,
            ];
        }

        $b = $this->log($from, null, ['limit' => 1]);
        $commits = array_merge($commits, $b);
        print_r($commits);
    }

    /**
     * @todo: work required
     * Split string by new line or null(\0)
     *
     * @param string $input   The string to split
     * @param bool   $useNull True to split by new line, otherwise null
     *
     * @return array
     */
    public function split ($input, $useNull = false) {
        if ($useNull) {
            $pattern = '/\0/';
        } else {
            $pattern = '/\r?\n/';
        }

        return preg_split($pattern, rtrim($input), -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Diff changes in files from $from to $to.
     *
     * @param $from
     * @param $to
     */
    public function diff ($from, $to) {
        $op = $this->git->diff($from, $to);
        print_r($op->getOutput());


//        $result = [
//            'added'    => [],
//            'deleted'  => [],
//            'modified' => [],
//        ];
//
//        $a = explode("\n", $a);
//
//        foreach ($a as $line) {
//            $mod = substr($line, 0, 1);
//            if ($mod === 'A' or $mod === 'C') {
//                $result['added'][] = trim(substr($line, 1));
//            } elseif ($mod === 'M' or $mod === 'T') {
//                $result['modified'][] = trim(substr($line, 1));
//            } elseif ($mod == 'D' or $mod === 'T') {
//                $result['deleted'][] = trim(substr($line, 1));
//            } else {
//            }
//        }
//        print_r($result);
    }

    /**
     * returns true if the hash is child of a branch.
     *
     * @param $hash
     * @param $branch
     *
     * @return bool
     * @throws \PHPGit\Exception\GitException
     */
    public function commitExistInBranch ($hash, $branch) {
        $process = $this->getProcessBuilder()
            ->add('branch')
            ->add('-a')
            ->add('--contains')
            ->add($hash)
            ->getProcess();

        $a = $this->run($process);
        $b = strpos($a, $branch);
        if (empty($b)) {
            return false;
        } else {
            return true;
        }
    }
}
