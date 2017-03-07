<?php

namespace Gf;

use Fuel\Core\Arr;
use Fuel\Core\File;

class Config {

    private $configs;
    public $isOpen;
    private static $instance;

    /**
     * @return Config
     */
    public static function instance () {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    protected function __construct () {
        iF (GF_CONFIG_FILE_EXISTS) {
            $file = File::read(GF_CONFIG_FILE, true);
        } else {
            $file = File::read(GF_CONFIG_FILE_NEW, true);
        }

        $this->configs = json_decode($file, true);
    }

    /**
     * Get the config data.
     *
     * @param      $key
     * @param null $default
     *
     * @return mixed
     */
    public function get ($key, $default = null) {
        return Arr::get($this->configs, $key, $default);
    }

    public function set (Array $dataSet) {
        foreach ($dataSet as $k => $data) {
            Arr::set($this->configs, $k, $data);
        }

        return $this;
    }

    /**
     * Remove a key from config
     * use with caution
     *
     * @param $key
     *
     * @return $this
     */
    public function remove ($key) {
        Arr::delete($this->configs, $key);

        return $this;
    }

    public function save () {
        $file_data = json_encode($this->configs, JSON_PRETTY_PRINT);
        $doc_root = DOCROOT;
        $file_name = GF_CONFIG_FILE;

        if (File::exists($doc_root . $file_name))
            File::update($doc_root, $file_name, (string)$file_data);
        else
            File::create($doc_root, $file_name, (string)$file_data);
    }
}