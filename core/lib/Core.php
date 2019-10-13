<?php

namespace ZxKill\Core\Lib;

/**
 * Class Core
 * @package ZxKill\Core\Lib
 */
class Core
{
    private static $controllerName;
    private static $actionName;

    public static function run()
    {
        session_start();
        global $DB;
        $DB = new DB(Settings::getInstance()->getDBConfig());

        self::routes();

        // создаем контроллер
        $controllerName = 'ZxKill\Controllers\\' . ucfirst(self::$controllerName);
        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            $action     = 'action_' . static::$actionName;
            if (method_exists($controller, $action)) {
                // вызываем действие контроллера
                $controller->$action();
            } else {
                $controller->action_index();
            }
        } else {
            self::errorPage404();
        }

        $DB->disconnect();
    }

    /**
     * Роутинг... получаем из урла текущий контроллер и экшн
     */
    private static function routes()
    {
        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if (!empty($routes[1])) {
            static::$controllerName = $routes[1];
        } else {
            static::$controllerName = 'task';
        }

        if (!empty($routes[2])) {
            static::$actionName = $routes[2];
        } else {
            static::$actionName = 'index';
        }
    }

    /**
     * Метод для установки статуса страницы 404
     */
    public static function errorPage404()
    {
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
    }

    public static function addGetParam($arField)
    {
        return http_build_query(array_merge($_GET, $arField), '', '&');
    }
}
