<div class="multielfinder_<?php echo $name; ?>" style="display:none;"><p>
        <a href="#" data-name="<?php echo $name; ?>" class="choose_file btn btn-success">Выбрать файл</a>
        <input class="choose_value_<?php echo $name; ?>" type="hidden" name="<?php echo $name; ?>[]" value="">
        <a style="display:none;" target="_blank" href="#" class="namefile choose_file_<?php echo $name; ?> btn btn-warning"></a>
        <a href="#" class="deleteblock btn btn-danger">[x]</a>
    </p></div>
<?php
if (isset($value) and is_array($value) and count($value)) {

    foreach ($value as $val) {
        $data = pathinfo($_SERVER['DOCUMENT_ROOT'] . $val['image']);
        ?>
        <p>
            <a href="#" data-name="<?php echo $name; ?>" class="choose_file btn btn-success">Выбрать файл</a>
            <input class="choose_value_<?php echo $name; ?>" type="hidden" name="<?php echo $name; ?>[]" value="<?= $val['image'] ?>">

            <a target="_blank" href="<?php echo $val['image']; ?>" class="namefile choose_file_<?php echo $name; ?> btn btn-warning"><?php echo $data['basename']; ?></a>
            <a href="#" class="deleteblock btn btn-danger">[x]</a>
        </p>
        <?php
        ?>
        <?php
    }
}
?>
<p><a href="#" class="addfile" data-name="<?php echo $name; ?>">Добавить файл</a></p>
