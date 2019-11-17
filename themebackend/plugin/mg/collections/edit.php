<ol class="breadcrumb">


    <li class="active"><?php echo __("backend/mg.edit_collection") ?></li>
</ol>
<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">

        </div>
        <h2><?php echo __("backend/mg.edit_collection") ?> </h2>
    </div>
    <!-- END Example Title -->

    <!-- Example Content -->
    <form action="{pathadmin}mg/collections/ajaxedit/<?php echo $collection['name']; ?>" class="ajaxsend" method="POST">
        <table class="table">
            <tr>
                <td><?php echo __("backend/mg.collection_name") ?></td>
                <td><?php echo $collection['name']; ?></td>
            </tr>
            <tr>
                <td><?php echo __("backend/mg.collection_title") ?></td>
                <td><input type="text" name="title" class="form-control" value="<?php echo $collection['title']; ?>" required></td>
            </tr>
            <tr>
                <td><?php echo __("backend/mg.collection_count") ?></td>
                <td><input type="number" name="count" min="0" class="form-control" value="<?php echo $collection['count']; ?>" required></td>
            </tr>

            <tr>
                <td><?php echo __("backend/mg.sort_by_field") ?></td>
                <td><select name="sort" class="form-control">
                        <option value="order_last_id"><?php echo __("backend/mg.sort_by_pos") ?></option>
                        <?php
                        if (count($collection['fields'])) {
                            foreach ($collection['fields'] as $field_key => $field) {
                                $selected = "";
                                if ($collection['sort_field'] == $field_key) {
                                    $selected = "selected";
                                }
                                ?>
                                <option <?php echo $selected; ?> value="<?php echo $field_key; ?>"><?php echo __("backend/mg.sort_by") ?> <?php echo $field['title']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td><?php echo __("backend/mg.sort_type") ?></td>
                <td>
                    <select name="sort_type" class="form-control">
                        <option <?php
                        if ($collection['sort_type'] == "ASC") {
                            echo 'selected';
                        }
                        ?> value="ASC">ASC</option>
                        <option <?php
                        if ($collection['sort_type'] == "DESC") {
                            echo 'selected';
                        }
                        ?>  value="DESC">DESC</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td colspan="2"><strong><?php echo __("backend/mg.fields") ?></strong>:</td>
            </tr>
            <?php
            if (count($collection['fields'])) {
                foreach ($collection['fields'] as $key => $field) {
                    ?>

                    <tr class="field_ajax_nid">
                        <td><?php echo __("backend/mg.field_name") ?></td>
                        <td>
                            <?php echo $key; ?>
                            <a class='btn btn-danger' href='{pathadmin}mg/collections/deletefield/<?php echo $collection['name']; ?>/<?php echo $key; ?>'><i><i class='fa fa-remove'></i></i></a>
                        </td>
                    </tr>
                    <tr class="field_ajax_nid">
                        <td><?php echo __("backend/mg.field_show_in_list") ?></td>
                        <td>
                            <input type="checkbox" name="fields[<?php echo $key; ?>][showinlist]" <?php
                            if ((int) $field['showinlist'] == 1) {
                                echo 'checked';
                            }
                            ?> class="form-control" value="1">
                        </td>
                    </tr>
                    <?php
                    if (\languages\models\LanguageHelp::is("frontend")) {
                        ?>
                        <tr class="field_ajax_nid">
                            <td><?php echo __("backend/mg.field_is_multilanguage") ?></td>
                            <td>
                                <input type="checkbox" name="fields[<?php echo $key; ?>][language]" <?php
                                if (isset($field['language']) and (int) $field['language'] == 1) {
                                    echo 'checked';
                                }
                                ?> class="form-control" value="1">
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr class="field_ajax_nid">
                        <td><?php echo __("backend/mg.field_in_search") ?></td>
                        <td>
                            <input type="checkbox" name="fields[<?php echo $key; ?>][showsearch]" <?php
                            if (isset($field['showsearch']) and (int) $field['showsearch'] == 1) {
                                echo 'checked';
                            }
                            ?> class="form-control" value="1">
                        </td>
                    </tr>
                    <tr class="field_ajax_nid">
                        <td><?php echo __("backend/mg.field_title") ?></td>
                        <td>
                            <input type="text" name="fields[<?php echo $key; ?>][title]" class="form-control" value="<?php echo $field['title']; ?>">
                        </td>
                    </tr>
                    <tr class="field_ajax_nid">
                        <td><?php echo __("backend/mg.field_required") ?></td>
                        <td>
                            <input <?php
                            if ($field['required'] == 1) {
                                echo 'checked';
                            }
                            ?> type="checkbox" name="fields[<?php echo $key; ?>][required]" class="form-control" value="1">
                        </td>
                    </tr>
                    <tr class="field_ajax_nid">
                        <td><?php echo __("backend/mg.field_unique") ?></td>
                        <td>
                            <input <?php
                            if ($field['unique'] == 1) {
                                echo 'checked';
                            }
                            ?> type="checkbox" name="fields[<?php echo $key; ?>][unique]" class="form-control" value="1">
                        </td>
                    </tr>
                    <?php
                    $name_field = $key;
                    if (count($field['config'])) {
                        ?>
                        <tr class="field_ajax_nid">
                            <td colspan="2"><?php echo __("backend/mg.field_params_for", array('name' => $key)) ?></td>
                        </tr>
                        <?php
                        foreach ($field['config'] as $key => $config) {
                            $value = "";
                            if (isset($field['options'][$key])) {
                                $value = $field['options'][$key];
                            }
                            ?>
                            <tr class="field_ajax_nid">
                                <td><?php echo $config['title']; ?></td>   
                                <td> 
                                    <?php
                                    if ($config['type'] == "text") {
                                        ?>
                                        <input name="fields[<?php echo $name_field; ?>][options][<?php echo $key; ?>]" type="text"  class="form-control" value="<?php echo $value; ?>">
                                        <?php
                                    } else if ($config['type'] == "int") {
                                        ?>
                                        <input name="fields[<?php echo $name_field; ?>][options][<?php echo $key; ?>]" type="number"  class="form-control" value="<?php echo $value; ?>" >
                                        <?php
                                    } else if ($config['type'] == "bool") {
                                        $checked = "";
                                        if (is_bool($value) and (bool) $value == true) {
                                            $checked = "checked";
                                        }
                                        ?>
                                        <input <?php echo $checked; ?> name="fields[<?php echo $name_field; ?>][options][<?php echo $key; ?>]" type="checkbox"  class="form-control" value="1">
                                        <?php
                                    } else if ($config['type'] == "select") {
                                        ?>
                                        <select name="fields[<?php echo $name_field; ?>][options][<?php echo $key; ?>]" class="form-control">
                                            <?php
                                            foreach ($config['options'] as $row) {
                                                $selected = "";
                                                if ((string) $row['value'] == (string) $value) {
                                                    $selected = "selected";
                                                }
                                                ?>
                                                <option <?php echo $selected; ?> value="<?php echo $row['value']; ?>"><?php echo $row['title']; ?></option>
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
                    <?php
                }
            }
            ?>
            <tr class="tr_add_field">
                <td>
                    <select class="form-control table_field" name="field" >
                        <?php
                        if (count($fields)) {
                            foreach ($fields as $field) {
                                ?>
                                <option value="<?php echo $field['name']; ?>"><?php echo $field['title']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <a href="#" data-link="mg/collections/field/" data-edit='1' data-next="0" class="btn btn-success addfield"><i class="fa fa-plus"></i> <?php echo __("backend/mg.field") ?></a>
                </td>
            </tr>               



            <tr><td><?php echo csrf_field(); ?></td>
                <td><button class="btn btn-danger "   ><?php echo __("backend/mg.edit_collection_btn") ?></button></td>
            </tr>
        </table>
    </form>

</div>
