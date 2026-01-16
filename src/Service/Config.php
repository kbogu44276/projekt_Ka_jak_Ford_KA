<?php
namespace App\Service;

use App\Exception\FrameworkException;

class Config
{
    private static ?array $config = null;
    private static $database = null;

    private static function init(): void
    {
        $configFile = __DIR__ . '/../../config/config.php';

        if (!file_exists($configFile)) {
            throw new FrameworkException("Invalid configuration file name '$configFile'");
        }

        self::$config = require $configFile;
    }

    public static function get(string $key)
    {
        if (self::$config === null) {
            self::init();
        }

        return self::$config[$key] ?? null;
    }

    public static function getDatabase()
    {
        if (self::$database === null) {
            $databaseFile = __DIR__ . '/../../Database.php';

            if (file_exists($databaseFile)) {
                require_once $databaseFile;
                self::$database = new \Database();
            } else {
                throw new FrameworkException("Database class not found at '$databaseFile'");
            }
        }

        return self::$database;
    }
}