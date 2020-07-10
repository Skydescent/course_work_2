<div class="row row mx-lg-5">
    <div class="col">
        <h1><?= $data['title'] ?></h1>
    </div>
</div>
<?php foreach ($data['posts'] as $post) : ?>
    <div class="row mx-lg-5">
        <div class="col py-3">
                <div class="card" style="width: 60rem;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $post->title; ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?= \helpers\makeShortAnnotation($post->text); ?></h6>
                        <a href="/post/<?= $post->id; ?>" class="btn btn-link stretched-link">Читать далее -></a>
                        <div class="container-sm">
                            <img src="<?= $post->img; ?>" class="card-text" alt="<?= $post->title; ?>" height="200">
                        </div>
                        <p class="card-text"><small class="text-muted">Дата публикации: <?= \helpers\mainPostDateFormat($post->created_at); ?></small></p>

                    </div>
                </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="row justify-content-md-center">
    <div class="text-center">
        <?php if ($data['pagination']->countPages > 1) : ?>
            <?= $data['pagination']?>
        <?php endif;?>
    </div>
</div>

<div class="row mx-lg-5">
    <div class="col-md-8 py-3">
        <form class="form-inline" method="post" action="<?= $_SERVER['REQUEST_URI']?>">
            <?php if (!isset($_SESSION['auth_subsystem'])) :?>
            <div class="input-group mb-2 mr-sm-2 col">
                <div class="input-group-prepend">
                    <div class="input-group-text">@</div>
                </div>
                <input  name="email" type="text" class="form-control" placeholder="Email">
                <?php if (isset($_SESSION['error']['email'])) : ?>
                    <div class="p-1 mt-2 alert alert-danger">
                        <?= $_SESSION['error']['email']; unset($_SESSION['error']['email']);?>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if ((isset($_SESSION['auth_subsystem']) && $_SESSION['auth_subsystem']['is_subscribed'] == 'no') || !isset($_SESSION['auth_subsystem']) ) : ?>
            <button name= "subscribe" type="submit" class="btn btn-secondary mb-2 col-md-auto ">Подписаться на статьи блога</button>
            <?php endif; ?>
        </form>
    </div>
    <div class="col-md-auto py-3"></div>
    <div class="col col-lg-2"></div>
</div>





