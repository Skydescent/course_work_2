<div class="row row mx-lg-5">
    <div class="col">
        <h3><?= $data['title'] ?></h3>
</div>
</div>
<form action="/admin/pages?page=<?= $data['pagination']->currentPage?>" method="post">
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Alias</th>
            <th scope="col">Заголовок</th>
            <th scope="col">Текст</th>
            <th scope="col">Действия</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($data['pages'] as $page) : ?>
                <tr>
                    <th scope="row"><?= $page->id; ?></th>
                    <?php if ($page->id == $data['change_id']) : ?>
                        <td>
                            <div class="form-group">
                                <input name="alias" type="text" class="form-control"  value="<?= $page->alias; ?>">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input name="title" type="text" class="form-control"  value="<?= $page->title; ?>">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <textarea name="text" class="form-control" rows="3"><?= $page->text; ?></textarea>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <button type="submit" name="submit_change" value="<?= $page->id ?>" class="btn btn-primary">Применить изменения</button>
                            </div>
                    <?php else:?>
                        <td><?= $page->alias; ?></td>
                        <td><?= $page->title; ?></td>
                        <td><?= \helpers\makeShortAnnotation($page->text); ?></td>
                        <td>
                            <div class="form-group">
                                <button type="submit" name="change" value="<?= $page->id ?>" class="btn btn-outline-info">Изменить</button>
                            </div>
                    <?php endif;?>
                    <?php if ($page->is_active == '1') :?>
                        <button type="submit" name="active" value="<?= $page->id ?>_0" class="btn btn-outline-danger">Архивировать</button>
                    <?php else : ?>
                        <button type="submit" name="active" value="<?= $page->id ?>_1" class="btn btn-outline-success">Разархивировать</button>
                    <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php if (!isset($_POST['add_page'])) :?>
            </table>
            <button type="submit" name="add_page"  class="btn btn-secondary btn-lg btn-block">Добавить новую страницу</button>
        <?php else :?>
            <td>Будет задан автоматически</td>
            <td>
                <div class="form-group">
                    <input name="new_alias" type="text" class="form-control"  value="">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input name="new_title" type="text" class="form-control"  value="">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <textarea name="new_text" class="form-control" rows="3"></textarea>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <button type="submit" name="new_page" value="" class="btn btn-primary">Добавить страницу</button>
                </div>
            </td>
            </table>
        <?php endif;?>
</form>

<div class="row justify-content-md-center">
    <div class="text-center">
        <?= $data['pagination']?>
    </div>
</div>
