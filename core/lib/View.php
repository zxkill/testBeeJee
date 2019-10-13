<?php

namespace ZxKill\Core\Lib;

class View
{
    /**
     * метод для генерации html страницы
     *
     * @param $content
     * @param $data
     *
     * @return string
     */
    public function generate($content, $data = null)
    {
        if (empty($data['TITLE'])) {
            $data['TITLE'] = Settings::getInstance()->getSiteConfig()['TITLE'];
        }

        ob_start();
        @require_once $_SERVER['DOCUMENT_ROOT'] . '/view/template.php'; //общий файл шаблона
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
        return true;
    }
}
