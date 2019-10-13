<?php

namespace ZxKill\Core\Lib;

/**
 * Класс для работы с настройками
 * @package ZxKill\Core\Lib
 */
class Settings
{
    /**  @var array */
    private $settings = [];

    protected static $instance;

    public function __construct()
    {
        $this->getAllConfig();
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Settings();
        }

        return self::$instance;
    }

    private function getAllConfig()
    {
        $this->settings = require_once $_SERVER['DOCUMENT_ROOT'] . '/core/config.php';
    }

    public function getDBConfig()
    {
        return $this->settings['DB'];
    }

    public function getSiteConfig()
    {
        return $this->settings['SITE'];
    }
}
