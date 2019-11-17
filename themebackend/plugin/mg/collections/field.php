<tr class="field_ajax_nid ajax_field_added">
    <td ><?php echo __("backend/mg.field_type") ?>  - <?php echo $title; ?></td>
    <td><a href="#" data-id="nid" class="btn btn-danger removefieldajax"><i class="fa fa-remove"></i></a></td>
</tr>
<tr class="field_ajax_nid ajax_field_added">
    <td><?php echo __("backend/mg.field_name") ?></td>
    <td>
        <input type="hidden" name="<?php echo $newname; ?>[nid][type]" value="<?php echo $name; ?>">
        <input type="text" name="<?php echo $newname; ?>[nid][name]" class="form-control">
    </td>
</tr>
<tr class="field_ajax_nid ajax_field_added">
    <td><?php echo __("backend/mg.field_title") ?></td>
    <td>
        <input type="text" name="<?php echo $newname; ?>[nid][title]" class="form-control">
    </td>
</tr>
<tr class="field_ajax_nid ajax_field_added" style="display:none;">
    <td>Порядок</td>
    <td>
        <input type="checkbox" name="<?php echo $newname; ?>[nid][order]" class="form-control" value="1">
    </td>
</tr>
<?php
if (\languages\models\LanguageHelp::is("frontend")) {
    ?>
    <tr class="field_ajax_nid ajax_field_added">
        <td><?php echo __("backend/mg.field_is_multilanguage") ?></td>
        <td>
            <input type="checkbox" name="<?php echo $newname; ?>[nid][language]"  class="form-control" value="1">
        </td>
    </tr>
    <?php
}
?>
<tr class="field_ajax_nid ajax_field_added">
    <td><?php echo __("backend/mg.field_show_in_list") ?></td>
    <td>
        <input type="checkbox" name="<?php echo $newname; ?>[nid][showinlist]" class="form-control" value="1">
    </td>
</tr>
<tr class="field_ajax_nid ajax_field_added">
    <td><?php echo __("backend/mg.field_in_search") ?></td>
    <td>
        <input type="checkbox" name="<?php echo $newname; ?>[nid][showsearch]" class="form-control" value="1">
    </td>
</tr>
<tr class="field_ajax_nid ajax_field_added">
    <td><?php echo __("backend/mg.field_required") ?></td>
    <td>
        <input type="checkbox" name="<?php echo $newname; ?>[nid][required]" class="form-control" value="1">
    </td>
</tr>
<tr class="field_ajax_nid ajax_field_added">
    <td><?php echo __("backend/mg.field_unique") ?></td>
    <td>
        <input type="checkbox" name="<?php echo $newname; ?>[nid][unique]" class="form-control" value="1">
    </td>
</tr>
<?php
if (count($config)) {
    ?>
    <tr class="field_ajax_nid ajax_field_added">
        <td colspan="2"><?php echo __("backend/mg.field_params_for", array('name' => $title)) ?></td>
    </tr>
    <?php
    foreach ($config as $key => $config) {
        ?>
        <tr class="field_ajax_nid ajax_field_added">
            <td><?php echo $config['title']; ?></td>   
            <td> 
                <?php
                if ($config['type'] == "text") {
                    ?>
                    <input name="<?php echo $newname; ?>[nid][options][<?php echo $key; ?>]" type="text"  class="form-control" value="">
                    <?php
                } else if ($config['type'] == "int") {
                    ?>
                    <input name="<?php echo $newname; ?>[nid][options][<?php echo $key; ?>]" type="number"  class="form-control" >
                    <?php
                } else if ($config['type'] == "bool") {
                    ?>
                    <input name="<?php echo $newname; ?>[nid][options][<?php echo $key; ?>]" type="checkbox"  class="form-control" value="1">
                    <?php
                } else if ($config['type'] == "select") {
                    ?>
                    <select name="<?php echo $newname; ?>[nid][options][<?php echo $key; ?>]" class="form-control">
                        <?php
                        foreach ($config['options'] as $row) {
                            ?>
                            <option value="<?php echo $row['value']; ?>"><?php echo $row['title']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <?php
                }
                ?>

            </td> </tr>
        <?php
    }
    ?>
    <?php
}
?>


