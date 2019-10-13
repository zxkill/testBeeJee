<?php

namespace ZxKill\Controllers;

use ZxKill\Core\Lib\Controllers;
use ZxKill\Core\Lib\View;
use ZxKill\Model\User;

/**
 * Class Task
 * @package ZxKill\Controllers
 */
class Login extends Controllers
{
    public function __construct()
    {
        $this->model = new User();
        $this->view = new View();
    }

    public function action_index()
    {
        $this->setTitle('Авторизация');
        $this->data['PAGE'] = 'login';
        $this->data['INVALID_LOGIN'] = false;

        if (isset($_SESSION['invalid_login']) && $_SESSION['invalid_login']) {
            $this->data['INVALID_LOGIN'] = true;
        }
        $this->view->generate('login', $this->data);
    }

    public function action_login()
    {
        $name = htmlspecialchars(trim($_REQUEST['login']));
        $password = md5(trim($_REQUEST['password']));
        if ($this->model::getUser(['name' => $name, 'password' => $password])) {
            $_SESSION['admin'] = $password;
        } else {
            $_SESSION['invalid_login'] = true;
        }
        header('Location: /login/');
    }

    public function action_logout()
    {
        session_destroy();
        header('Location: /login/');
    }
}
