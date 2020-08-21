<h3>Регистрация</h3>
<div class="row">
    <div class="col-md-6">
        <form method="post" action="/user/signup">
            <div class="form-group">
                <label for="login">Логин</label>
                <input name="login" type="text" class="form-control" id="login" value="<?= isset($_SESSION['form_data']['login']) ? helpers\h($_SESSION['form_data']['login']) : ''; ?>">
                <?php if (isset($_SESSION['error']['login'])) : ?>
                    <div class="p-1 mt-2 alert alert-danger">
                        <?= $_SESSION['error']['login']; unset($_SESSION['error']['login']);?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input name="email" type="text" class="form-control" id="email" aria-describedby="email" value="<?= isset($_SESSION['form_data']['email']) ? helpers\h($_SESSION['form_data']['email']) : ''; ?>">
                <small id="email" class="form-text text-muted">Ваш E-mail защищён: никакого СПАМа</small>
                <?php if (isset($_SESSION['error']['email'])) : ?>
                    <div class="p-1 mt-2 alert alert-danger">
                        <?= $_SESSION['error']['email']; unset($_SESSION['error']['email']);?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input name="password" type="password" class="form-control" id="password" value="<?= isset($_SESSION['form_data']['password']) ? helpers\h($_SESSION['form_data']['password']) : ''; ?>">
                <?php if (isset($_SESSION['error']['password'])) : ?>
                    <div class="p-1 mt-2 alert alert-danger">
                        <?= $_SESSION['error']['password']; unset($_SESSION['error']['password']);?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="password_conf">Подтвердите пароль</label>
                <input name="password_conf" type="password" class="form-control" id="password_conf" value="<?= isset($_SESSION['form_data']['password_conf']) ? helpers\h($_SESSION['form_data']['password_conf']) : ''; ?>">
                <?php if (isset($_SESSION['error']['password_conf'])) : ?>
                    <div class="p-1 mt-2 alert alert-danger">
                        <?= $_SESSION['error']['password_conf']; unset($_SESSION['error']['password_conf']);?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-check">
                <input name="is_apply_rules" type="checkbox" class="form-check-input" id="is_apply_rules"  <?= isset($_SESSION['form_data']['is_apply_rules']) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="is_apply_rules">Cогласие с <a href="/static/rules">правилами</a> сайта</label>
                <?php if (isset($_SESSION['error']['is_apply_rules'])) : ?>
                    <div class="p-1 mt-2 alert alert-warning">
                        <?= $_SESSION['error']['is_apply_rules']; unset($_SESSION['error']['is_apply_rules']);?>
                    </div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-secondary">Зарегистрировать</button>
        </form>

        <?php if (isset($_SESSION['auth_subsystem'])) unset($_SESSION['auth_subsystem']);?>
        <a href="/user/login">Авторизоваться</a>
    </div>

</div>
