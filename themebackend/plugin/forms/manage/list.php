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


        <div class="form-group">
            <label class="col-md-3 control-label" for="example-hf-email"><?php ?><input name="conditions[]" <?php
                if (isset($get_vars['conditions']) and is_array($get_vars['conditions']) and in_array("date", $get_vars['conditions']) === true) {
                    echo 'checked';
                }
                ?> value="date" type="checkbox"  ><?php echo __("backend/forms.date"); ?></label>
            <div class="col-md-2">  <select class="form-control" name="type_date">
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
                </select></div>
            <div class="col-md-7">
                <input type='date' name='date' class='form-control' value='<?php
                if (isset($get_vars['date'])) {
                    echo $get_vars['date'];
                }
                ?>'>
            </div>
        </div>
        <table class="table">


            <?php
            if (count($fields_search)) {
                foreach ($fields_search as $field_name => $field) {

                    if ($field['showsearch'] == 1) {
                        ?>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="example-hf-email"><?php ?><input name="conditions[]" <?php
                                if (isset($get_vars['conditions']) and is_array($get_vars['conditions']) and in_array($field_name, $get_vars['conditions']) === true) {
                                    echo 'checked';
                                }
                                ?> value="<?php echo $field_name; ?>" type="checkbox"  ><?php echo $field['title']; ?></label>
                            <div class="col-md-2"> <select class="form-control" name="type_<?php echo $field_name; ?>">
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
                                </select></div>
                            <div class="col-md-7">
                                <?php echo $field['input']; ?>
                            </div>
                        </div>


                        <?php
                    }
                }
            }
            ?>



            <p class='text-center'><button class='btn btn-danger' type='submit' ><?php echo __("backend/forms.op_LIKE"); ?></button></p>
    </form>


    <form action="{pathadmin}forms/manage/ops/<?php echo $form->id; ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-md-2">
                <input type="checkbox" class="allcheckbox" >

            </div>
            <div class="col-md-5">
                <button class="btn btn-danger" type="submit" name="op" value="delete"><i class="fa fa-remove"></i> Удалить</button>
            </div>
        </div>


        <?php
        if (count($rows)) {
            foreach ($rows as $row) {
                ?>

                <div class="block ">
                    <div class="block-title">
                        <?php
                        if (count($fields)) {
                            foreach ($fields as $field) {
                                $prefix = "_val";
                                if ($form->type == "mongodb") {
                                    $prefix = "";
                                }
                                ?>
                                <p >&nbsp;<strong><?php echo $field['title']; ?>:</strong><?php echo $row[$field['name'] . $prefix]; ?></p>


                                <?php
                            }
                        }
                        ?>



                    </div>
                    <div class="row">
                        <div class="col-xs-1">
                            <input type="checkbox" name="ids[]" value="<?php echo $row['last_id']; ?>">

                        </div>
                        <div class="col-xs-2">
                            <?php echo $row['date_create']; ?>
                        </div>
                        <div class="col-xs-offset-1 col-xs-4 ">
                            <a class="btn btn-primary" href="{pathadmin}forms/manage/show/<?= $form->id; ?>/<?= $row['last_id']; ?>"><?php echo __("backend/forms.look"); ?></a>
                        </div>
                        <div class="col-xs-3 pull-right">                    <a class="deleteerror btn btn-danger" data-msg="<?php echo __("backend/forms.want_delete"); ?>" href="{pathadmin}forms/manage/delete/<?= $form->id; ?>/<?= $row['last_id']; ?>"><i class="fa fa-remove"></i></a>
                        </div>
                    </div>

                </div>

                <?php
            }
        }
        ?>

    </form>
    <?php echo $pages; ?>
</div>