<?php

namespace ZxKill\Model;

use ZxKill\Core\Lib\Model;

/**
 * Class User
 * @package ZxKill\Model
 */
class User extends Model
{
    public function getData($offset = 0, $sort = ['sort' => 'id', 'by' => 'desc'])
    {
        return true;
    }

    /**
     * @param $arFields
     *
     * @return bool|array
     */
    public static function getUser($arFields)
    {
        global $DB;
        $stmt = $DB->prepare(
            "SELECT * FROM `admins` WHERE name = '{$arFields['name']}' AND password = '{$arFields['password']}' LIMIT 1"
        );
        $stmt->execute();
        if ($user = $stmt->fetch()) {
            return $user;
        }
        return false;
    }

    /**
     * @return bool
     */
    public static function isAuth()
    {
        if (isset($_SESSION['admin'])) {
            global $DB;
            $stmt = $DB->prepare(
                "SELECT `id` FROM `admins` WHERE password = '{$_SESSION['admin']}' LIMIT 1"
            );
            $stmt->execute();
            if ($user = $stmt->fetch()) {
                return true;
            }
        }
        return false;
    }
}
