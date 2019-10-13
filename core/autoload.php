<?php

try {
    spl_autoload_register('autoLoad');
} catch (Exception $e) {
    throw new MissingException("Невозможно загрузить: $e.");
}

function autoLoad()
{
    $directories = array(
        'core/lib/',
        'controllers/',
        'models/',
    );

    foreach ($directories as $directory) {
        $arFiles = array_slice(scandir($directory), 2); //сканируем папку и убираем . и ..
        if (!empty($arFiles)) {
            foreach ($arFiles as $file) {
                require_once($directory . $file);
            }
        }
    }
}
