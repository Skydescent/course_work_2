<div class="row row mx-lg-5">
    <div class="col">
        <h3><?= $data['title'] ?></h3>
</div>
</div>
<table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Пользователь</th>
        <th scope="col">E-mail</th>
        <th scope="col">Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data['subscriptions'] as $subscription) : ?>
        <tr>
            <th scope="row"><?= $subscription->id; ?></th>
            <td><?= is_null($subscription->login) ? 'не зарегистрирован' : $subscription->login; ?></td>
            <td><?= $subscription->email; ?></td>
            <td>
                <form action="/admin/subscriptions?page=<?= $data['pagination']->currentPage?>" method="post">
                    <?php if ($subscription->is_active == '1') :?>
                        <button type="submit" name="active" value="<?= $subscription->id ?>_0" class="btn btn-outline-danger">Запретить рассылку</button>
                    <?php else : ?>
                        <button type="submit" name="active" value="<?= $subscription->id ?>_1" class="btn btn-outline-success">Разрешить рассылку</button>
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