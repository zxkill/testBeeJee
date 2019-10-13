<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="/asset/css/style.css">
    <script src="/asset/js/jquery-3.4.1.min.js"></script>
    <script src="/asset/js/bootstrap.min.js"></script>
    <title><?= $data['TITLE']?></title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand" href="/">Список дел</a>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item<?= ($data['PAGE'] != 'login') ? ' active' : ''?>">
                    <a class="nav-link" href="/">Главная</a>
                </li>
                <li class="nav-item<?= ($data['PAGE'] == 'login') ? ' active' : ''?>">
                    <a class="nav-link" href="/login/">Авторизация</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <?php
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/view/' . $content . '.php')
            && is_file($_SERVER['DOCUMENT_ROOT'] . '/view/' . $content . '.php')) {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/' . $content . '.php';
        } else {
            echo 'Страница не найдена';
        }
        ?>
    </div>
    <footer class="py-3 bg-light">
        <div class="container text-right">
            &copy; 2019 ZxKill
        </div>
    </footer>
</body>
</html>
