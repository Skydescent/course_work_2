<div class="row row mx-lg-5">
    <div class="col">
        <h3><?= $data['title'] ?></h3>
    </div>
</div>
<table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Дата</th>
        <th scope="col">Текст</th>
        <th scope="col">Пост</th>
        <th scope="col">Автор</th>
        <th scope="col">Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data['comments'] as $comment) : ?>
        <tr>
            <th scope="row"><?= $comment->id; ?></th>
            <td><?= $comment->created_at; ?></td>
            <td><?= $comment->text; ?></td>
            <td>
                <a href="/post/<?=$comment->post_id?>"><?= $comment->post_title; ?></a>
            </td>
            <td><?= $comment->author; ?></td>
            <td>
                <form action="/admin/comments?page=<?= $data['pagination']->currentPage?>" method="post">
                    <?php if ($comment->is_applied == '1') :?>
                        <button type="submit" name="active" value="<?= $comment->id ?>_0" class="btn btn-outline-danger">Отвергнуть</button>
                    <?php else : ?>
                        <button type="submit" name="active" value="<?= $comment->id ?>_1" class="btn btn-outline-success">Утвердить</button>
                    <?php endif; ?>

                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<div class="row justify-content-md-center">
    <div class="text-center">
        <?= $data['pagination']?>
    </div>
</div>