<h4><?php echo __("backend/content.main_setup_block") ?></h4>
<?php
echo __("backend/editjs.types");
?>

<table class="table">
    <tr>
        <td>HTML</td>
        <td>  <textarea class="form-control"  rows="10" cols="100" name="param[html]" placeholder="Введите шаблон сюда"><?php
                if (isset($params['html'])) {
                    echo $params['html'];
                }
                ?></textarea></td>
    </tr>
</table>




