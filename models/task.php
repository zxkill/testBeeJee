<?php

namespace ZxKill\Model;

use ZxKill\Core\Lib\Model;
use ZxKill\Core\Lib\Settings;

/**
 * Class Task
 * @package ZxKill\Model
 */
class Task extends Model
{
    public function getData($offset = 0, $sort = ['sort' => 'id', 'by' => 'desc'])
    {
        global $DB;
        $arData = [];
        $stmt = $DB->prepare(
            'SELECT * FROM `tasks` ORDER BY ' . $sort['sort'] . ' ' . $sort['by'] . ' 
                LIMIT ' . $offset . ',' . Settings::getInstance()->getSiteConfig()['TASK_ON_PAGE']
        );
        $stmt->execute();
        $arData['DATA'] = $stmt->fetchAll();

        $stmt = $DB->prepare('SELECT COUNT(*) FROM `tasks`');
        $stmt->execute();
        $arData['COUNT_ROW'] = $stmt->fetch();

        return $arData;
    }

    public static function add($arFields)
    {
        global $DB;
        $stmt = $DB->prepare("INSERT INTO `tasks` (username, email, description) VALUES (?,?,?)");
        return $stmt->execute([$arFields['username'], $arFields['email'], $arFields['description']]);
    }

    public static function update($id, $arFields)
    {
        global $DB;
        $stmt = $DB->prepare(
            "UPDATE `tasks` SET
                description = '{$arFields['description']}', status = '{$arFields['status']}', admin_edit = '{$arFields['admin_edit']}'
                WHERE id = '{$id}'"
        );
        return $stmt->execute();
    }

    public static function getByID($id)
    {
        global $DB;
        $stmt = $DB->prepare("SELECT * FROM `tasks` WHERE id = '{$id}'");
        $stmt->execute();
        return $stmt->fetch();
    }
}
