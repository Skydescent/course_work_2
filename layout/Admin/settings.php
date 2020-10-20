<div class="row row mx-lg-5">
    <div class="col">
        <h3><?= $data['title'] ?></h3>
    </div>
</div>
<div class="row mx-lg-5">
    <form action="<?= '/admin/settings'; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="fileSize">Максимальный размер загружаемых изображений:</label>
            <select class="custom-select my-1 mr-sm-2" name="fileSize" id="fileSize">
                <?php foreach ($data['maxSize'] as $key => $size) :?>
                    <?php $value = $key === 'default' ? 'selected value=' . $size :  'value=' . $size ?>
                    <option <?= $value ?>><?= \helpers\humanBytes($size) ?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="form-group">
            <label for="default_pagination">Пагинация по количеству постов на главной странице:</label>
            <select class="custom-select my-1 mr-sm-2" name="select_default" id="default_pagination">
                <?php foreach ($data['paginationSelect'] as $key => $select) :?>
                    <?php $value = $key === 'default' ? 'selected value=' . $select :  'value=' . $select ?>
                    <option <?= $value ?>><?= $select ?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" name="update_settings" value="" class="btn btn-primary">Обновить настройки</button>
        </div>
    </form>
</div>
