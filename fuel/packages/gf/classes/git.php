<?php
namespace Gf;

/**
 * Class Git
 * wait!!
 *
 * @package Gf
 */
class Git extends \PHPGit\Git {

    public function __construct() {
        parent::__construct();
    }

    public function verifyhash($hash){
        $process = $this->getProcessBuilder()
            ->add('rev-parse')
            ->add('--verify')
            ->add($hash)
            ->getProcess();

        $a = $this->run($process);
        return $a;
    }

    /**
     * Get commits between to hash
     *
     * @param $from
     * @param $to
     * @throws \PHPGit\Exception\GitException
     */
    public function logBetween($from, $to) {
        $process = $this->getProcessBuilder()
            ->add('log')
            ->add($from . '...')
            ->add('' . $to)
            ->add('--format=%H||%aN||%aE||%aD||%s')
            ->getProcess();

        $a = $this->run($process);
        $lines = $this->split($a);

        $commits = array();

        foreach ($lines as $line) {
            list($hash, $name, $email, $date, $title) = preg_split('/\|\|/', $line, -1, PREG_SPLIT_NO_EMPTY);
            $commits[] = array(
                'hash'  => $hash,
                'name'  => $name,
                'email' => $email,
                'date'  => $date,
                'title' => $title
            );
        }

        $b = $this->log($from, NULL, array('limit' => 1));
        $commits = array_merge($commits, $b);
        print_r($commits);
    }

    /**
     * Split string by new line or null(\0)
     *
     * @param string $input The string to split
     * @param bool $useNull True to split by new line, otherwise null
     *
     * @return array
     */
    public function split($input, $useNull = FALSE) {
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
     * @throws \PHPGit\Exception\GitException
     */
    public function diff($from, $to) {
        $process = $this->getProcessBuilder()
            ->add('-c')
            ->add('core.quotepath=false')
            ->add('diff')
            ->add('--name-status')
            ->add($from)
            ->add($to)
            ->getProcess();

        $a = $this->run($process);

        $result = array(
            'added'    => [],
            'deleted'  => [],
            'modified' => [],
        );

        $a = explode("\n", $a);

        foreach ($a as $line) {
            $mod = substr($line, 0, 1);
            if ($mod === 'A' or $mod === 'C') {
                $result['added'][] = trim(substr($line, 1));
            } elseif ($mod === 'M' or $mod === 'T') {
                $result['modified'][] = trim(substr($line, 1));
            } elseif ($mod == 'D' or $mod === 'T') {
                $result['deleted'][] = trim(substr($line, 1));
            } else {
                // Something unknown.
            }
        }
        print_r($result);
    }

    /**
     * returns true if the hash is child of a branch.
     *
     * @param $hash
     * @param $branch
     * @return bool
     * @throws \PHPGit\Exception\GitException
     */
    public function commitExistInBranch($hash, $branch) {
        $process = $this->getProcessBuilder()
            ->add('branch')
            ->add('-a')
            ->add('--contains')
            ->add($hash)
            ->getProcess();

        $a = $this->run($process);
        $b = strpos($a, $branch);
        if (empty($b)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
