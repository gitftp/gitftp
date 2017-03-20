<?php

namespace Gf\Deploy\Helper;

use Fuel\Core\Cache;
use Gf\Utils;

/**
 * Class DeployLife
 *
 * @package Gf\Deploy\Helper
 */
class DeployLife {

    public static $key = 'project.';
    public static $timeout = '-10 minutes';

    /**
     * sets that the
     */
    public static function working ($project_id) {
        Cache::set(self::$key . $project_id, [
            'activity' => Utils::timeNow(),
        ]);
    }

    /**
     * Done with it ?
     */
    public static function doneWorking ($project_id) {
        try {
            Cache::delete(self::$key . $project_id);
        } catch (\Exception $e) {
            // cache not found.
        }
    }

    public static function isWorking ($project_id) {
        try {
            $data = Cache::get(self::$key . $project_id);
            $last_activity = $data['activity'];
            if ($last_activity > Utils::timeAlter(self::$timeout)) {
                return true;
            } else {
                Cache::delete(self::$key . $project_id);

                return false;
            }
        } catch (\Exception $e) {
            // no.
            return false;
        }
    }
}