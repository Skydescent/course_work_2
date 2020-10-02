<?php helpers\includeView(VIEW_DIR . 'base/header.php');?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/">Deus+Post</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/">Главная <span class="sr-only">(current)</span></a>
            </li>
            <?php if (
                    isset($_SESSION['auth_subsystem']) &&
                    ($_SESSION['auth_subsystem']['role'] == 'admin' || $_SESSION['auth_subsystem']['role'] == 'manager')
            ):
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/posts/">Статьи</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/comments/">Комментарии</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/pages/">Страницы</a>
                </li>
                <?php if ($_SESSION['auth_subsystem']['role'] == 'admin'):?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/users/">Пользователи</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/subscriptions/">Подписки</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/settings/">Доп. настройки</a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>


            <?php if (!isset($_SESSION['auth_subsystem'])):?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">

                        Войти
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                            <a class="dropdown-item" href="/user/login">Авторизация</a>
                            <a class="dropdown-item" href="/user/signup">Регистрация</a>

                    </div>
                </li>
            <?php else: ?>
                <li>
                    <li class="nav-item">
                        <a class="nav-link" href="/user/profile">Личный кабинет</a>
                    </li>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<div class="container-fluid">
    <div class="container px-lg-5">
        <div class="mt-3 row">
            <div class="col-md-6">
                <?php if (isset($_SESSION['success'])) : ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['success']; unset($_SESSION['success']);?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error']['page'])) : ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['error']['page']; unset($_SESSION['error']['page']);?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php \helpers\debug($_SESSION);?>
        <?php \helpers\debug($_REQUEST);?>
        <?php \helpers\debug($_FILES);?>


