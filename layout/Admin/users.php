<div class="row row mx-lg-5">
    <div class="col">
        <h1><?= $data['title'] ?></h1>
    </div>
</div>
<table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Картинка</th>
        <th scope="col">Логин</th>
        <th scope="col">Email</th>
        <th scope="col">Роль</th>
        <th scope="col">Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data['users'] as $user) : ?>
        <tr>
            <th scope="row"><?= $user->id; ?></th>
            <td>
                <div class="container-sm">
                    <img src="<?= $user->img; ?>" class="card-text" height="100">
                </div>
            </td>
            <td><?= $user->login; ?></td>
            <td><?= $user->email; ?></td>
            <?php if ($user->id == $_SESSION['auth_subsystem']['id']) : ?>
                <td><?= $user->role; ?></td>
                <td>Не доступны</td>
            <?php else : ?>
                <td>
                    <form class="form-inline" action="/admin/users?page=<?= $data['pagination']->currentPage?>" method="post">
                        <select class="custom-select my-1 mr-sm-2" name="role">
                            <?php foreach ($data['roles'] as $role) : ?>
                                <?php $value = $role->name === $user->role ? 'selected' :  'value=' . $user->id . '_' . $role->name ?>
                                <option  <?= $value?>><?= $role->name ?></option>
                            <?php endforeach;?>
                        </select>
                        <button type="submit" class="btn btn-primary my-1 btn-outline-primary">Изменить</button>
                    </form>
                </td>
                <td>
                    <button type="button" class="btn btn-outline-danger">Деактивировать</button>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>
<div class="row justify-content-md-center">
    <div class="text-center">
        <?php if ($data['pagination']->countPages > 1) : ?>
            <?= $data['pagination']?>
        <?php endif;?>
    </div>
</div>

