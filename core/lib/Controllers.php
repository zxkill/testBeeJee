<?php

namespace ZxKill\Core\Lib;

abstract class Controllers
{
    protected $data;
    protected $model;
    protected $view;

    abstract public function action_index();

    protected function setTitle($title)
    {
        $this->data['TITLE'] = $title;
    }
}
