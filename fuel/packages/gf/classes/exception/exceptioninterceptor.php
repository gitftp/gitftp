<?php

namespace Gf\Exception;

use Gf\Auth\Auth;
use Gf\Settings;

/**
 * Class ExceptionInterceptor
 * intercepts the exceptions to bypass only what is necessary.
 * Synopsis:
 *  When using API's all kinds of exceptions are thrown
 *  like user friendly exceptions that are to be shown to the user,
 *  program errors that are not to be shown to the user etc.
 *  This function logs the exceptions that happen for developer review.
 * .
 * ! This class does not extend Exception
 *
 * @package Nb
 */
class ExceptionInterceptor {
    protected $code;
    protected $message;

    /**
     * ExceptionInterceptor constructor.
     *
     * @param \Exception $e
     *
     * @return \Exception
     */
    public static function intercept (\Exception $e) {
        // if debug is set to true, all the exceptions will be passed on and not be logged.
        $debug = Settings::get('nb_exception_debug');
        $should_log = Settings::get('nb_exception_logger', false);

        // what message to use if this exception is not to be bypassed.
        $error_message = Settings::get('nb_exception_message');

        if ($e instanceof UserException) {
            return $e;
        } else {
            $file = $e->getFile();
            $file = substr($file, strpos($file, 'fuel'));

            if ($should_log) {
                // using debug backtrace instead of $e->getTrace();
                $backtrace = [];
                $headers = \Input::headers();
                $url = \Uri::current();
                $user = Auth::instance();
                $env = [
//                    'is_mode'  => is_mode,
//                    'protocol' => protocol,
//                    'is_debug' => is_debug,
                ];
                $params = [
                    'method'    => \Input::method(),
                    'get'       => \Input::get(),
                    'post'      => \Input::post(),
                    'delete'    => \Input::delete(),
                    'json'      => \Input::json(),
                    'extension' => \Input::extension(),
                ];

                $dump_data = [];
                if ($e instanceof AppException) {
                    $dump_data = $e->getDumpData();
                    $backtrace = $e->getBacktrace();
                } else {
                    $backtrace = debug_backtrace();
                }

                try {
                    Logger::insert([
                        'code'      => $e->getCode(),
                        'message'   => $e->getMessage(),
                        'file'      => $file,
                        'line'      => $e->getLine(),
                        'backtrace' => serialize($backtrace),
                        'headers'   => serialize($headers),
                        //                        'included_files' => serialize($included_files),
                        'user'      => ($user->user_id) ? serialize($user) : serialize([]),
                        'env'       => serialize($env),
                        'params'    => serialize($params),
                        'dump'      => serialize($dump_data),
                        'url'       => $url,
                    ]);
                } catch (\Exception $ex) {
                    // serializing Closures is not allowed, that might come up in $backtrace.
                    logger(\Fuel::L_ERROR, $ex->getMessage(), __METHOD__);
                }
            }

            $message = "Exception " . $e->getCode() . ": " . $e->getMessage() . " file: $file @ " . $e->getLine();

            return new \Exception($message, $e->getCode(), $e);
        }
    }

}