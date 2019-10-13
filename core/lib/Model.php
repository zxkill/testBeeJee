<?php

namespace ZxKill\Core\Lib;

abstract class Model
{
    abstract public function getData($offset = 0, $sort = 'id');
}
