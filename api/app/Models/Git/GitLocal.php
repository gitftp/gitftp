<?php

namespace App\Models\Git;

use App\Exceptions\ExceptionInterceptor;
use Gitonomy\Git\Admin;
use Gitonomy\Git\Repository;
use Gitonomy\Git\WorkingCopy;

/**
 * A wrapper to the git wrapper class
 * wrapper inception
 * Class Git
 *
 * @package Gf
 */
class GitLocal {

    /**
     * @var WorkingCopy
     */
    public WorkingCopy $git;

    /**
     * @var Repository
     */
    public Repository $wrapper;

    public function __construct($pathToRepo) {
        if (!defined('STDIN'))
            define('STDIN', fopen('php://stdin', 'r'));
        if (!defined('STDOUT'))
            define('STDOUT', fopen('php://stdout', 'w'));
        if (!defined('STDERR'))
            define('STDERR', fopen('php://stderr', 'w'));

        $this->wrapper = new Repository($pathToRepo);
        $this->git = $this->wrapper->getWorkingCopy();
    }


    public function setListener($listener) {
        $this->wrapper->setLogger($listener);
        //        $this->git->getWrapper()
        //                  ->addLoggerListener($listener);
    }

//
//    /**
//     * @return Repository
//     */
//    public static function cloneRepository($path, $clone_url) {
//        $repo = Admin::cloneRepository($path, $clone_url, [
//            'progress' => true,
//        ], [
//
//        ]);
//
//        return $repo;
//    }

    /**
     * @param $hash
     *
     * @return mixed
     */
    public function verifyHash($hash) {
        try {
            $op = $this->wrapper->run('rev-parse', [
                '--verify',
                $hash,
            ]);

            return trim($op);
        } catch (\Exception $e) {
            ExceptionInterceptor::intercept($e);
            return false;
        }
    }

}
