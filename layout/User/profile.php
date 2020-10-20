<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col">
                <h3>Ваш профиль</h3>
                <?php if($_SESSION['auth_subsystem']['img'] !== '') :?>
                    <img src="<?=$_SESSION['auth_subsystem']['img']?>" alt="profile_picture" class="img-thumbnail rounded float-right">
                <? endif; ?>
            </div>
            <div class="col">

            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <form method="post" action="/user/profile" class="w-100"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="login">Логин</label>
                        <input name="login" type="text" class="form-control" id="login" value="<?= $_SESSION['form_data']['login'] ?>" >
                        <?php if (isset($_SESSION['error']['login'])) : ?>
                            <div class="p-1 mt-2 alert alert-danger">
                                <?= $_SESSION['error']['login']; unset($_SESSION['error']['login']);?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input name="email" type="text" class="form-control" id="email" value="<?= $_SESSION['form_data']['email']; ?>">
                        <?php if (isset($_SESSION['error']['email'])) : ?>
                            <div class="p-1 mt-2 alert alert-danger">
                                <?= $_SESSION['error']['email']; unset($_SESSION['error']['email']);?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="img">Загрузить аватар</label>
                        <input name="img" type="file" class="form-control-file" id="img">
                        <?php if (isset($_SESSION['error']['img'])) : ?>
                            <div class="p-1 mt-2 alert alert-danger">
                                <?= $_SESSION['error']['img']; unset($_SESSION['error']['img']);?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="about">О себе</label>
                        <textarea name="about" class="form-control" id="about" rows="3"><?=$_SESSION['form_data']['about']?></textarea>
                        <?php if (isset($_SESSION['error']['about'])) : ?>
                            <div class="p-1 mt-2 alert alert-danger">
                                <?= $_SESSION['error']['about']; unset($_SESSION['error']['about']);?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input name="is_subscribed" class="form-check-input" type="checkbox" id="is_subscribed">
                            <label  class="form-check-label" for="is_subscribed">
                                <?= $_SESSION['form_data']['is_subscribed'] == 'yes' ? 'Отписаться от рассылки' : 'Подписаться на рассылку'?> Блога?
                            </label>
                        </div>
                    </div>
                    <p>
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Сменить пароль
                        </button>
                    </p>
                    <div class="collapse <?= (isset($_SESSION['error']['password']) || isset($_SESSION['error']['password_new'])) ? 'show' : ''?>" id="collapseExample">
                        <div class="form-group">
                            <label for="password">Старый пароль</label>
                            <input name="password" type="password" class="form-control" id="password" value="">
                            <?php if (isset($_SESSION['error']['password'])) : ?>
                                <div class="p-1 mt-2 alert alert-danger">
                                    <?= $_SESSION['error']['password']; unset($_SESSION['error']['password']);?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="password_new">Новый пароль</label>
                            <input name="password_new" type="password" class="form-control" id="password_new" value="">
                            <?php if (isset($_SESSION['error']['password_new'])) : ?>
                                <div class="p-1 mt-2 alert alert-danger">
                                    <?= $_SESSION['error']['password_new']; unset($_SESSION['error']['password_new']);?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-secondary w-100">Изменить</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
