<?php

namespace ZxKill\Controllers;

use ZxKill\Core\Lib\Controllers;
use ZxKill\Core\Lib\Settings;
use ZxKill\Core\Lib\View;
use ZxKill\Model\Task as TaskModel;
use ZxKill\Model\User;

/**
 * Class Task
 * @package ZxKill\Controllers
 */
class Task extends Controllers
{
    public function __construct()
    {
        $this->model = new TaskModel();
        $this->view = new View();
    }

    public function action_index()
    {
        $page = 1;
        $sort = ['sort' => 'id', 'by' => 'desc'];
        $countOnPage = Settings::getInstance()->getSiteConfig()['TASK_ON_PAGE'];
        if (isset($_REQUEST['page']) && $_REQUEST['page'] > 0) {
            $page = (int)$_REQUEST['page'];
        }
        $start = $page * $countOnPage - $countOnPage;
        if (isset($_GET['sort'])
            && isset($_GET['by'])
            && (in_array($_GET['sort'], ['username', 'email', 'status']))
            && (in_array($_GET['by'], ['asc', 'desc']))) {
            $sort = [ 'sort' => htmlspecialchars($_GET['sort']), 'by' => htmlspecialchars($_GET['by']) ];
        }
        $arData = $this->model->getData($start, $sort);

        $this->data['TASK'] = $arData['DATA'];
        $this->data['PAGINATION']['COUNT_PAGE'] = ceil($arData['COUNT_ROW'][0] / $countOnPage);
        $this->data['PAGINATION']['CUR_PAGE'] = $page;
        $this->data['PAGE'] = 'task';

        if (isset($_COOKIE['successAdd']) && $_COOKIE['successAdd'] == true) {
            $this->data['SUCCESS_ADD'] = true;
            setcookie("successAdd", false);
        }
        $this->setTitle('Задачи');

        $this->view->generate('task', $this->data);
    }

    public function action_add()
    {
        if (!empty($_REQUEST['username']) && !empty($_REQUEST['email']) && !empty($_REQUEST['description'])) {
            $username    = htmlspecialchars($_REQUEST['username']);
            $email       = htmlspecialchars($_REQUEST['email']);
            $description = htmlspecialchars($_REQUEST['description']);
            if ($this->model::add([ 'username' => $username, 'email' => $email, 'description' => $description ])) {
                setcookie("successAdd", true, time() + 3600, "/");
            }
        }
        header('Location: /');
    }

    public function action_update()
    {
        if (User::isAuth()) {
            if (! empty($_REQUEST['action'])
                && ( $_REQUEST['action'] == 'saveTask' )
                && ! empty((int) $_REQUEST['id'])) {
                $id          = htmlspecialchars($_REQUEST['id']);
                $status      = htmlspecialchars($_REQUEST['status']);
                $description = htmlspecialchars($_REQUEST['description']);
                $task = TaskModel::getByID($id);

                if ($description != $task['description']) {
                    $adminEdit = 1;
                } else {
                    $adminEdit = $task['admin_edit'];
                }
                if ($this->model::update($id, ['description' => $description, 'status' => $status, 'admin_edit' => $adminEdit])) {
                    echo json_encode([ 'result' => 'ok', 'error' => '', 'adminEdit' => $adminEdit]);
                } else {
                    echo json_encode([ 'result' => 'error', 'error' => 'errorUpdate' ]);
                }
            }
        } else {
            echo json_encode(['result' => 'error', 'error' => 'accessDenied']);
        }
        die;
    }
}
