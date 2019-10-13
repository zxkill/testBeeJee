<?php

namespace ZxKill\Core\Lib;

/**
 * Class DB
 * @package ZxKill\Core\Lib
 */
class DB extends \PDO
{
    private $settings = [];

    private $dsn;

    public function __construct($config)
    {
        $this->settings = $config;

        $this->dsn = 'mysql:host=' . $this->settings['HOST'] . ';dbname=' . $this->settings['DBNAME'];
        parent::__construct($this->dsn, $this->settings['USER'], $this->settings['PASSWORD']);
    }

    public function disconnect()
    {
        $this->dsn = null;
    }
}
