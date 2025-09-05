<?php
class Config {
    public static function getConfig($key) {
        static $config;
        if (!$config) {
            $config = require __DIR__ . '/../env.php';
        }
        return $config[$key] ?? null;
    }
}