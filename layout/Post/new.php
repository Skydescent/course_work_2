<form action="/post/new" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Заголовок статьи</label>
            <input name="title" type="text" class="form-control" id="title"  value="<?= isset($_SESSION['form_data']['title']) ?$_SESSION['form_data']['title'] : '';?>">
            <?php if (isset($_SESSION['error']['title'])) : ?>
                <div class="p-1 mt-2 alert alert-danger">
                    <?= $_SESSION['error']['title']; unset($_SESSION['error']['title']);?>
                </div>
            <?php endif; ?>
        </div>

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
            <textarea name="text" class="form-control" rows="3" id="text"><?=  isset($_SESSION['form_data']['text']) ?$_SESSION['form_data']['text'] : '';?></textarea>
            <?php if (isset($_SESSION['error']['text'])) : ?>
                <div class="p-1 mt-2 alert alert-danger">
                    <?= $_SESSION['error']['text']; unset($_SESSION['error']['text']);?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <button type="submit" name="add_post" value="" class="btn btn-primary">Добавить cтатью</button>
        </div>
</form>
