<div class="multielfinder_<?php echo $name; ?>" style="display:none;"><p>
        <a href="#" data-name="<?php echo $name; ?>" class="choose_file btn btn-success">Выбрать файл</a>
        <input class="choose_value_<?php echo $name; ?>" type="hidden" name="<?php echo $name; ?>[]" value="">
        <a style="display:none;" target="_blank" href="#" class="namefile choose_file_<?php echo $name; ?> btn btn-warning"></a>
        <a href="#" class="deleteblock btn btn-danger">[x]</a>
    </p></div>
<?php
if (count($all)) {
    foreach ($all as $val) {
        ?>
        <p>
            <a href="#" data-name="<?php echo $name; ?>" class="choose_file btn btn-success">Выбрать файл</a>
            <input class="choose_value_<?php echo $name; ?>" type="hidden" name="<?php echo $name; ?>[]" value="<?= $val['file'] ?>">

            <a target="_blank" href="<?php echo $val['file']; ?>" class="namefile choose_file_<?php echo $name; ?> btn btn-warning"><?php echo $val['namefile']; ?></a>
            <a href="#" class="deleteblock btn btn-danger">[x]</a>
        </p>
        <?php
        ?>
        <?php
    }
}
?>
<p><a href="#" class="addfile" data-name="<?php echo $name; ?>">Добавить файл</a></p>
