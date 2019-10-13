<?php
use ZxKill\Model\User;
?>
<div class="login">
<?php
if (User::isAuth()) { ?>
    Вы авторизованы. <a class="btn btn-primary" href="/login/logout/" role="button">Выйти</a>
<?php } else {
    ?><?php
if ($data['INVALID_LOGIN']) { ?>
    <div class="alert alert-warning" role="alert">
        Пользователь не найден
    </div>
<?php } ?>
            <form action="/login/login/" class="needs-validation" method="post" novalidate>
                <div class="form-group">
                    <label for="login">Логин</label>
                    <div class="input-group">
                        <input type="text" name="login" class="form-control" id="login" placeholder="Логин"
                               aria-describedby="inputGroupPrepend" required>
                        <div class="invalid-feedback">
                            Введите логин
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Пароль"
                               required>
                        <div class="invalid-feedback">
                            Введите пароль
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Войти</button>
            </form>
        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function () {
                'use strict';
                window.addEventListener('load', function () {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function (form) {
                        form.addEventListener('submit', function (event) {
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
}
?>
</div>