<?php

if(!function_exists('config')) {

    function config(string $env): mixed
    {
        $configs = require BASE_PATH . 'core/Config.php';

        if(!array_key_exists($env, $configs)) {
            throw new \InvalidArgumentException("There is no '$env' key in config file!");
        }
        
        return $configs[$env];
    }

}
