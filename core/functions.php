<?php

if(!function_exists('config')) {
    function config(string $env): mixed
    {
        $configs = require BASE_PATH . 'core/config.php';

        if(!array_key_exists($env, $configs)) {
            throw new \InvalidArgumentException("There is no '$env' key in config file!");
        }
        
        return $configs[$env];
    }
}

if(!function_exists('dd')) {
    function dd(mixed $var): void
    {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';

        die();
    }
}

if(!function_exists('dump')) {
    function dump(mixed $var): void
    {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }   
}
