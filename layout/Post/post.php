<?php
    $post = $data['post'];
    $comments = $data['comments'];
?>
<div class="container px-lg-5">
    <div class="row row mx-lg-5">
        <div class="col">
            <h1><?= $post->title; ?></h1>
        </div>
    </div>
    <div class="row mx-lg-5">
        <div class="col py-3">
            <div class="container-sm">
                <img src="<?= $post->img; ?>" class="card-text" alt="<?= $post->title; ?>" height="400">
            </div>
            <p class="card-text"><small class="text-muted"><?= \helpers\mainPostDateFormat($post->created_at); ?></small></p>
            <p><?= $post->text; ?></p>
        </div>
    </div>
    <?php foreach ($comments as $comment) : ?>
        <?php if ($comment['is_applied'] == '1' || (isset($_SESSION['auth_subsystem']) && ($_SESSION['auth_subsystem']['id'] == $comment['author_id'] || $_SESSION['auth_subsystem']['role'] == 'admin' || $_SESSION['auth_subsystem']['role'] == 'manager'))) : ?>
            <div class="card bg-light mx-lg-5">
                <div class="row no-gutters">
                    <div class="col-2 py-3">
                        <img src="<?=$comment['img']?>" class="card-img" alt="...">
                        <p class="card-text text-center" "><?= $comment['login']; ?></p>
                    </div>
                    <div class="col-10">
                        <div class="card-body">
                            <p class="card-text"><?= $comment->text; ?></p>
                            <p class="card-text"><small class="text-muted"><?= \helpers\mainPostDateFormat($comment['created_at']); ?></small></p>
                        </div>
                    </div>
                    <div class="card-footer alert <?= $comment['is_applied'] == '0' ? 'alert-warning' : 'alert-success'; ?>">
                        <small class="text-muted"><?= $comment['is_applied'] == '0' ? 'комментарий не утверждён' : 'прошёл модерацию'; ?></small>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <div class="row mx-lg-5">
        <div class="col py-3">
            <form action="/post/<?= $post->id; ?>" method="post">
                <div class="form-group">
                    <label for="commentInput">Комментарий</label>
                    <input type="text"  name="text" class="form-control" id="commentInput" aria-describedby="emailHelp">
                </div>
                <button type="submit" class="btn btn-secondary">Оставить</button>
            </form>
        </div>
    </div>
</div>
