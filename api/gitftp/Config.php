<?php


class Config {

    private $configFile = 'gitftp-config.json';

    private static $instance;
    public static function instance(){
        if(!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function __construct() {

    }

    private $currentConfigs = [];

    public function load() {
        $configs = @file_get_contents(__DIR__ . '/../' . $this->configFile);
        if (!$configs) {
            $configs = '{}';
        }
        $this->currentConfigs = @json_decode($configs, true);

        if (!$this->currentConfigs) {
            return [];
        }
        return $this;
    }

    public function save() {
        @file_put_contents(__DIR__ . '/../' . $this->configFile, json_encode($this->currentConfigs));
        return $this;
    }

    public function set($key, $value) {
        Arr::set($this->currentConfigs, $key, $value);
        return $this;
    }

    public function remove($key){
        Arr::delete($this->currentConfigs, $key);
        return $this;
    }

    public function get($key, $default = false){
       return Arr::get($this->currentConfigs, $key, $default);
    }
}
