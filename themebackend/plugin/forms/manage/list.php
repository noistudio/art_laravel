<div class="block">
    <div class="block-title">
        <div class="block-options pull-right">

        </div>
        <h2><?php echo $form->title; ?></h2>
    </div>

    <ul class="nav nav-tabs">
        <li class="active"><a href="{pathadmin}forms/manage/<?php echo $form->id; ?>"><i class="fa fa-envelope"></i> <?php echo __("backend/forms.messages"); ?></a></li>



        <li><a href="{pathadmin}forms/manage/setup/<?php echo $form->id; ?>"><i class="fa fa-cog"></i> <?php echo __("backend/forms.setup"); ?></a></li>
        <li><a href="{pathadmin}forms/manage/template/<?php echo $form->id; ?>"><i class="fa fa-html"></i> <?php echo __("backend/forms.template"); ?></a></li>
        <li ><a href="{pathadmin}forms/manage/templateemail/<?php echo $form->id; ?>"><i class="fa fa-html"></i> <?php echo __("backend/forms.template_email"); ?></a></li>

    </ul>
    <h4><?php echo __("backend/forms.setup_select"); ?></h4>
    <?php
    ?>
    <form action='' method='GET'>
        <table class="table">

            <tr>
                <td><?php ?><input name="conditions[]" <?php
                    if (isset($get_vars['conditions']) and is_array($get_vars['conditions']) and in_array("date", $get_vars['conditions']) === true) {
                        echo 'checked';
                    }
                    ?> value="date" type="checkbox"  ></td>
                <td><?php echo __("backend/forms.date"); ?></td>
                <td>
                    <select class="form-control" name="type_date">
                        <option <?php
                        if (isset($get_vars['type_date']) and $get_vars['type_date'] == "=") {
                            echo 'selected';
                        }
                        ?> value='='><?php echo __("backend/forms.op_="); ?></option>
                        <option <?php
                        if (isset($get_vars['type_date']) and $get_vars['type_date'] == "LIKE") {
                            echo 'selected';
                        }
                        ?> value='LIKE'><?php echo __("backend/forms.op_LIKE"); ?></option>
                        <option <?php
                        if (isset($get_vars['type_date']) and $get_vars['type_date'] == ">=") {
                            echo 'selected';
                        }
                        ?> value='>='><?php echo __("backend/forms.op_>="); ?></option>
                        <option <?php
                        if (isset($get_vars['type_date']) and $get_vars['type_date'] == "<=") {
                            echo 'selected';
                        }
                        ?> value='<='><?php echo __("backend/forms.op_<="); ?></option>
                        <option <?php
                        if (isset($get_vars['type_date']) and $get_vars['type_date'] == "!=") {
                            echo 'selected';
                        }
                        ?> value='!='><?php echo __("backend/forms.op_!="); ?></option>
                    </select>
                </td>
                <td> <input type='date' name='date' class='form-control' value='<?php
                    if (isset($get_vars['date'])) {
                        echo $get_vars['date'];
                    }
                    ?>'</td>
            </tr> 
            <?php
            if (count($fields_search)) {
                foreach ($fields_search as $field_name => $field) {

                    if ($field['showsearch'] == 1) {
                        ?>
                        <tr>
                            <td><?php ?><input name="conditions[]" <?php
                                if (isset($get_vars['conditions']) and is_array($get_vars['conditions']) and in_array($field_name, $get_vars['conditions']) === true) {
                                    echo 'checked';
                                }
                                ?> value="<?php echo $field_name; ?>" type="checkbox"  ></td>
                            <td><?php echo $field['title']; ?></td>
                            <td>
                                <select class="form-control" name="type_<?php echo $field_name; ?>">
                                    <option <?php
                                    if (isset($get_vars['type_' . $field_name]) and $get_vars['type_' . $field_name] == "=") {
                                        echo 'selected';
                                    }
                                    ?> value='='><?php echo __("backend/forms.op_="); ?></option>
                                    <option <?php
                                    if (isset($get_vars['type_' . $field_name]) and $get_vars['type_' . $field_name] == "LIKE") {
                                        echo 'selected';
                                    }
                                    ?> value='LIKE'><?php echo __("backend/forms.op_LIKE"); ?></option>
                                    <option <?php
                                    if (isset($get_vars['type_' . $field_name]) and $get_vars['type_' . $field_name] == ">=") {
                                        echo 'selected';
                                    }
                                    ?> value='>='><?php echo __("backend/forms.op_>="); ?></option>
                                    <option <?php
                                    if (isset($get_vars['type_' . $field_name]) and $get_vars['type_' . $field_name] == "<=") {
                                        echo 'selected';
                                    }
                                    ?> value='<='><?php echo __("backend/forms.op_<="); ?></option>
                                    <option <?php
                                    if (isset($get_vars['type_' . $field_name]) and $get_vars['type_' . $field_name] == "!=") {
                                        echo 'selected';
                                    }
                                    ?> value='!='><?php echo __("backend/forms.op_!="); ?></option>
                                </select>
                            </td>
                            <td><?php echo $field['input']; ?></td>
                        </tr>   
                        <?php
                    }
                }
            }
            ?>

        </table>

        <p class='text-center'><button class='btn btn-danger' type='submit' ><?php echo __("backend/forms.op_LIKE"); ?></button></p>
    </form>


    <form action="{pathadmin}forms/manage/ops/<?php echo $form->id; ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="row">

            <div class="col-md-5">
                <button class="btn btn-danger" type="submit" name="op" value="delete"><i class="fa fa-remove"></i> Удалить</button>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th><input type="checkbox" class="allcheckbox" ></th>
                    <th><?php echo __("backend/forms.date"); ?></th>

                    <?php
                    if (count($fields)) {
                        foreach ($fields as $field) {
                            ?>
                            <th><?php echo $field['title']; ?></th>
                            <?php
                        }
                    }
                    ?>

                    <th></th>
                    <th></th>


                </tr>
            </thead>
            <tbody>
                <?php
                if (count($rows)) {
                    foreach ($rows as $row) {
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="ids[]" value="<?php echo $row['last_id']; ?>">
                            </td>
                            <td><?php echo $row['date_create']; ?></td>
                            <?php
                            if (count($fields)) {
                                foreach ($fields as $field) {
                                    $prefix = "_val";
                                    if ($form->type == "mongodb") {
                                        $prefix = "";
                                    }
                                    ?>
                                    <td><?php echo $row[$field['name'] . $prefix]; ?></td>
                                    <?php
                                }
                            }
                            ?>
                            <td><a class="btn btn-primary" href="{pathadmin}forms/manage/show/<?= $form->id; ?>/<?= $row['last_id']; ?>"><?php echo __("backend/forms.look"); ?></a></td>
                            <td><a class="deleteerror btn btn-danger" data-msg="<?php echo __("backend/forms.want_delete"); ?>" href="{pathadmin}forms/manage/delete/<?= $form->id; ?>/<?= $row['last_id']; ?>"><i class="fa fa-remove"></i><?php echo __("backend/forms.delete"); ?></a></td>

                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </form>
    <?php echo $pages; ?>
</div>