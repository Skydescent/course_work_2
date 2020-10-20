<?php
    $post = $_SESSION['form_data'] ?? $data['post'];
?>
<form action="<?= '/post/edit/' . $data['post']['id']; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Заголовок статьи</label>
            <input name="title" type="text" class="form-control" id="title"  value="<?= $post['title'];?>">
            <?php if (isset($_SESSION['error']['title'])) : ?>
                <div class="p-1 mt-2 alert alert-danger">
                    <?= $_SESSION['error']['title']; unset($_SESSION['error']['title']);?>
                </div>
            <?php endif; ?>
        </div>
        <?php if ($data['post']['img']!== ''):?>
            <div class="container-sm">
                <img src="<?= $data['post']['img']; ?>" class="card-text" height="200">
            </div>
        <?php endif;?>
        <div class="form-group">
            <label for="img">Картинка статьи</label>
            <input name="img" type="file" class="form-control-file" id="img">
            <?php if (isset($_SESSION['error']['img'])) : ?>
                <div class="p-1 mt-2 alert alert-danger">
                    <?= $_SESSION['error']['img']; unset($_SESSION['error']['img']);?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="text">Текст</label>
            <textarea name="text" class="form-control" rows="3" id="text"><?=  $post['text'];?></textarea>
            <?php if (isset($_SESSION['error']['text'])) : ?>
                <div class="p-1 mt-2 alert alert-danger">
                    <?= $_SESSION['error']['text']; unset($_SESSION['error']['text']);?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <button type="submit" name="edit_post" value="" class="btn btn-primary">Обновить cтатью</button>
        </div>
</form>
