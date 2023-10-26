<?php
namespace Gf\Exception;

use Gf\Auth\Auth;
use Gf\Settings;

class Log {
    /**
     * Manually log details of the current state
     *
     * @param       $message
     * @param array $dump_data
     * @return bool
     */
    public static function log($message, Array $dump_data = null) {
        if (is_null($dump_data))
            $dump_data = [];
        $exception = new AppException($message, $dump_data);
        $file = $exception->getFile();
        $file = substr($file, strpos($file, 'fuel'));
        $headers = \Input::headers();
        $url = \Uri::current();
        $user = Auth::instance();
        $env = [
            'is_mode'  => is_mode,
            'protocol' => protocol,
            'is_debug' => is_debug,
        ];
        $params = [
            'method'    => \Input::method(),
            'get'       => \Input::get(),
            'post'      => \Input::post(),
            'delete'    => \Input::delete(),
            'json'      => \Input::json(),
            'extension' => \Input::extension(),
        ];

        $dump_data = $exception->getDumpData();
        $backtrace = $exception->getBacktrace();

        try {
            Logger::insert([
                'code'      => $exception->getCode(),
                'message'   => $exception->getMessage(),
                'file'      => $file,
                'line'      => $exception->getLine(),
                'backtrace' => serialize($backtrace),
                'headers'   => serialize($headers),
                'user'      => ($user->user_id) ? serialize($user) : serialize([]),
                'env'       => serialize($env),
                'params'    => serialize($params),
                'dump'      => serialize($dump_data),
                'url'       => $url,
            ]);

            return true;
        } catch (\Exception $ex) {
            // serializing Closures is not allowed, that might come up in $backtrace.
            logger(\Fuel::L_ERROR, $ex->getMessage(), __METHOD__);

            return false;
        }
    }
}