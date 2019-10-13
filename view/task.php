<?php
use ZxKill\Core\Lib\Core;
use ZxKill\Model\User;
$isAuth = User::isAuth();
?>
<div class="tasks">
    <?php
    if ($data['SUCCESS_ADD']) { ?>
        <div class="alert alert-success" role="alert">
            Задача успешно добавлена
        </div>
    <?php } ?>
    <div class="alert alert-danger" role="alert" id="error" style="display: none"></div>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#taskAdd">Добавить</button>
    <table class="table table-striped">
        <thead class="thead-default">
        <tr>
            <th>
                <a href="/task/?<?= Core::addGetParam(
                    ['sort' => 'username', 'by' => ($_GET['by'] == 'asc') ? 'desc' : 'asc']
                )?>">Имя</a>
            </th>
            <th>
                <a href="/task/?<?= Core::addGetParam(
                    ['sort' => 'email', 'by' => ($_GET['by'] == 'asc') ? 'desc' : 'asc']
                )?>">Email</a>
            </th>
            <th>Текст задачи</th>
            <th>
                <a href="/task/?<?= Core::addGetParam(
                    ['sort' => 'status', 'by' => ($_GET['by'] == 'asc') ? 'desc' : 'asc']
                )?>">Статус задачи</a>
            </th>
            <?= ($isAuth) ? '<th>Редактировать</th>' : ''?>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($data['TASK'] as $item) { ?>
            <tr data-id="<?= $item['id']?>">
                <td><?= $item['username']?></td>
                <td><?= $item['email']?></td>
                <td class="description"><?= $item['description']?></td>
                <td class="status">
                    <?= ($item['status']) ? 'Завершена' : 'В работе'?>
                    <?= ($item['admin_edit']) ? '<span>(отредактировано администратором)</span>' : ''?>
                </td>
                <?= ($isAuth) ? '
                    <td align="center">
                        <img width="20px" src="/img/edit.png" class="editTask" data-id="' . $item['id'] . '">
                    </td>' : ''
                ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <nav aria-label="pagination-task">
        <ul class="pagination pagination-sm">
            <?php
            for ($i = 1; $i <= $data['PAGINATION']['COUNT_PAGE']; $i++) {
                if ($i == $data['PAGINATION']['CUR_PAGE']) { ?>
                    <li class="page-item active" aria-current="page">
                        <span class="page-link">
                            <?=$i?>
                        </span>
                    </li>
                <?php } else { ?>
                    <li class="page-item">
                        <a class="page-link" href="/task/?<?= Core::addGetParam(['page' => $i])?>"><?=$i?></a>
                    </li>
                <?php }
            } ?>
        </ul>
    </nav>
</div>

<!-- Modal -->
<div class="modal fade" id="taskAdd" tabindex="-1" role="dialog" aria-labelledby="taskAddLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskAddLabel">Новая задача</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/task/add/" class="needs-validation" novalidate method="post">
                    <div class="form-group">
                        <label for="username" class="col-form-label">Имя:</label>
                        <div class="input-group">
                            <input type="text" name="username" class="form-control" id="username" required>
                            <div class="invalid-feedback">
                                Введите Имя
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email:</label>
                        <div class="input-group">
                            <input type="email" name="email" class="form-control" id="email" required>
                            <div class="invalid-feedback">
                                Введите корректный Email
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label">Текст задачи:</label>
                        <div class="input-group">
                            <textarea class="form-control" name="description" id="description" required></textarea>
                            <div class="invalid-feedback">
                                Введите текст задачи
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<?php
if ($isAuth) { ?>
    <script>
        $( document ).ready(function() {
            let $tr,
                $description,
                $status,
                $img;
            //редактируем задачу
            $('body').on('click', '.editTask', function() {
                $img = $(this);
                $tr = $('tr[data-id="' + $img.attr('data-id') + '"]');
                $description = $tr.children('.description');
                $status = $tr.children('.status');
                $description.html(
                    '<input type="text" class="form-control" name="description" value="' + $description.text() + '">'
                );
                $status.html(
                    '<select name="status" class="form-control">' +
                        '<option value="0">В работе</option>' +
                        '<option value="1">Завершена</option>' +
                    '</select>'
                );
                $img.attr('src', '/img/save.png');
                $img.removeClass('editTask');
                $img.addClass('saveTask');

                return false;
            });

            //сохраняем задачу
            $('body').on('click', '.saveTask', function() {
                let $status_val,
                    $description_val;
                $tr = $('tr[data-id="' + $(this).attr('data-id') + '"]');
                $description_val = $tr.children().children('input[name="description"]').val();
                $status_val = $tr.children().children('td select[name="status"]').val();
                $.ajax({
                    type: 'POST',
                    url: '/task/update/',
                    dataType: 'json',
                    data: {
                        'action': 'saveTask',
                        'id': $(this).attr('data-id'),
                        'description': $description_val,
                        'status': $status_val
                    },
                    success: function (data) {
                        if (data.result === 'ok') {
                            if ($status_val == 0){
                                $status.html('В работе');
                            } else {
                                $status.html('Завершена');
                            }
                            $description.html($description_val);
                            $img.attr('src', '/img/edit.png');
                            $img.removeClass('saveTask');
                            $img.addClass('editTask');
                            if (data.adminEdit) {
                                $status.html($status.html() + '<span>(отредактировано администратором)</span>');
                            }
                        } else {
                            $('#error').html('Для данной операции необходима авторизация');
                            $('#error').show();
                        }
                    }
                });
                return false;
            });
        });
    </script>
<?php } ?>