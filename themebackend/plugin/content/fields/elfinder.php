
<a href="#" data-name="<?php echo $name; ?>" class="choose_file btn btn-success">Выбрать файл</a>
<input class="choose_value_<?php echo $name; ?>" type="hidden" name="<?php echo $name; ?>" value="<?= $value ?>">
<?php
if (isset($option['result'])) {
    ?>
    <a target="_blank" href="<?php echo $option['result']['url']; ?>" class="namefile choose_file_<?php echo $name; ?> btn btn-warning"><?php echo $option['result']['namefile']; ?></a>
    <?php
} else {
    ?>
    <a style="display:none;" target="_blank" href="#" class="namefile choose_file_<?php echo $name; ?> btn btn-warning"></a>
    <?php
}
?>
