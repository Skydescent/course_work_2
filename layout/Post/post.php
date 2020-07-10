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
    <div class="row mx-lg-5">
        <div class="col py-3">
            <ul class="list-unstyled">
                <?php foreach ($comments as $comment) : ?>
                   <?php if ($comment['is_applied'] = '1' || (isset($_SESSION['auth_subsystem']) && $_SESSION['auth_subsystem']['id'] == $comment['author_id'])) : ?>
                        <li class="media">
    <!--                        <img src="..." class="mr-3" alt="...">-->
                            <div class="media-body">
                                <p>Аватарка автора</p>
                                <p>ФИО автора</p>
                                <p>Дата коммента</p>
                                <h5 class="mt-0 mb-1">Comment Title</h5>
                                <?= $comment->text; ?>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="row mx-lg-5">
        <div class="col py-3">
            <form>
                <div class="form-group">
                    <label for="commentInput">Комментарий</label>
                    <input type="text" class="form-control" id="commentInput" aria-describedby="emailHelp">
                </div>
                <button type="submit" class="btn btn-secondary">Оставить</button>
            </form>
        </div>
    </div>
</div>
