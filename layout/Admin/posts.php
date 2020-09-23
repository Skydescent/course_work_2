<div class="row row mx-lg-5">
    <div class="col">
        <h3><?= $data['title'] ?></h3>
    </div>
</div>
<table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Дата создания</th>
        <th scope="col">Картинка</th>
        <th scope="col">Заголовок</th>
        <th scope="col">Автор</th>
        <th scope="col">Количество комментариев</th>
        <th scope="col">Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data['posts'] as $post) : ?>
        <tr>
            <th scope="row"><?= $post->id; ?></th>
            <td><?= $post->created_at; ?></td>
            <td>
                <div class="container-sm">
                    <img src="<?= $post->img; ?>" class="card-text" height="100">
                </div>
            </td>
            <td>
                <a href="/post/<?=$post->id?>"><?= $post->title; ?></a>
            </td>
            <td><?= $post->author; ?></td>
            <td><?= isset($data['comments'][$post->id]) ? $data['comments'][$post->id] : 0; ?></td>
            <td>
                <form action="/admin/posts?page=<?= $data['pagination']->currentPage?>" method="post">
                    <?php if ($post->is_active == '1') :?>
                        <button type="submit" name="active" value="<?= $post->id ?>_0" class="btn btn-outline-danger">Архивировать</button>
                    <?php else : ?>
                        <button type="submit" name="active" value="<?= $post->id ?>_1" class="btn btn-outline-success">Разархивировать</button>
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
