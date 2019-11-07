<div class="block">
    <div class="block-title">
        <div class="block-options pull-right">

        </div>
        <h2><?php echo $form['title']; ?></h2>
    </div>

    <ul class="nav nav-tabs">
        <li ><a href="{pathadmin}forms/manage/<?php echo $form['id']; ?>"><i class="fa fa-envelope"></i> <?php echo __("backend/forms.messages"); ?></a></li>
        <li class="active"><a href="{pathadmin}forms/manage/setup/<?php echo $form['id']; ?>"><i class="fa fa-cog"></i> <?php echo __("backend/forms.setup"); ?></a></li>
        <li><a href="{pathadmin}forms/manage/template/<?php echo $form['id']; ?>"><i class="fa fa-html"></i> <?php echo __("backend/forms.template"); ?></a></li>
        <li ><a href="{pathadmin}forms/manage/templateemail/<?php echo $form['id']; ?>"><i class="fa fa-html"></i> <?php echo __("backend/forms.template_email"); ?></a></li>

    </ul>
    <div class="alert alert-warning">
        <p><?php echo __("backend/forms.class_form"); ?></p>
        <p><?php echo $class_path; ?></p>
        <p><?php echo __("backend/forms.class_form2"); ?> \forms\core\Form</p>
    </div>
    <!-- Example Content -->
    <form action="{pathadmin}forms/manage/ajaxedit/<?php echo $form['id']; ?>" class="ajaxsend" method="POST">
        <table class="table">

            <tr>
                <td><?php echo __("backend/forms.db"); ?></td>
                <td><?php echo $form['type']; ?></td>
            </tr>
            <tr>
                <td><?php echo __("backend/forms.form_title"); ?></td>
                <td><input type="text" name="title" class="form-control" value="<?php echo $form['title']; ?>" required></td>
            </tr>

            <tr>
                <td><?php echo __("backend/forms.form_email"); ?></td>
                <td><input type="email" name="email"  class="form-control" value="<?php echo $form['email']; ?>" required></td>
            </tr>

            <tr>
                <td><?php echo __("backend/forms.form_status"); ?></td>
                <td>
                    <select class="form-control" name="send_on_email_admin">
                        <option <?php
                        if (isset($form['send_on_email_admin']) and $form['send_on_email_admin'] == 0) {
                            echo 'selected';
                        }
                        ?> value="0"><?php echo __("backend/forms.status_disable"); ?></option>
                        <option  <?php
                        if (isset($form['send_on_email_admin']) and $form['send_on_email_admin'] == 1) {
                            echo 'selected';
                        }
                        ?> value="1"><?php echo __("backend/forms.status_enable"); ?></option>
                    </select>
                </td>

            </tr>

            <?php
            if (\admins\models\AdminAuth::isRoot()) {
                ?>
                <tr>
                    <td colspan="2"><strong><?php echo __("backend/forms.fields_in_form"); ?></strong>:</td>
                </tr>
                <?php
                if (count($form['fields'])) {
                    foreach ($form['fields'] as $key => $field) {
                        ?>

                        <tr class="field_ajax_nid">
                            <td><?php echo __("backend/forms.field_name"); ?></td>
                            <td>
                                <?php echo $key; ?>
                                <a class='btn btn-danger' href='{pathadmin}forms/manage/deletefield/<?php echo $form['id']; ?>/<?php echo $key; ?>'><i><i class='fa fa-remove'></i></i></a>
                            </td>
                        </tr>
                        <tr class="field_ajax_nid">
                            <td><?php echo __("backend/forms.field_in_list"); ?></td>
                            <td>
                                <input type="checkbox" name="fields[<?php echo $key; ?>][showinlist]" <?php
                                if ((int) $field['showinlist'] == 1) {
                                    echo 'checked';
                                }
                                ?> class="form-control" value="1">
                            </td>
                        </tr>
                        <tr class="field_ajax_nid">
                            <td><?php echo __("backend/forms.field_in_search"); ?></td>
                            <td>
                                <input type="checkbox" name="fields[<?php echo $key; ?>][showsearch]" <?php
                                if (isset($field['showsearch']) and (int) $field['showsearch'] == 1) {
                                    echo 'checked';
                                }
                                ?> class="form-control" value="1">
                            </td>
                        </tr>
                        <tr class="field_ajax_nid">
                            <td><?php echo __("backend/forms.required"); ?></td>
                            <td>
                                <input type="checkbox" name="fields[<?php echo $key; ?>][required]" <?php
                                if (isset($field['required']) and (int) $field['required'] == 1) {
                                    echo 'checked';
                                }
                                ?> class="form-control" value="1">
                            </td>
                        </tr>
                        <tr class="field_ajax_nid">
                            <td><?php echo __("backend/forms.placeholder"); ?></td>
                            <td>
                                <input type="text" name="fields[<?php echo $key; ?>][placeholder]" class="form-control" value="<?php echo $field['placeholder']; ?>">
                            </td>
                        </tr>
                        <tr class="field_ajax_nid">
                            <td><?php echo __("backend/forms.field_css"); ?></td>
                            <td>
                                <input type="text" name="fields[<?php echo $key; ?>][css_class]" class="form-control" value="<?php echo $field['css_class']; ?>">
                            </td>
                        </tr>
                        <tr class="field_ajax_nid">
                            <td><?php echo __("backend/forms.field_title"); ?></td>
                            <td>
                                <input type="text" name="fields[<?php echo $key; ?>][title]" class="form-control" value="<?php echo $field['title']; ?>">
                            </td>
                        </tr>
                        <?php
                        if (count($field['config'])) {
                            ?>
                            <tr class="field_ajax_nid">
                                <td colspan="2"><?php echo __("backend/forms.field_params", array("name" => $key)); ?></td>
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
                                            <input name="fields[<?php echo $key; ?>][options][<?php echo $key; ?>]" type="text"  class="form-control" value="<?php echo $value; ?>">
                                            <?php
                                        } else if ($config['type'] == "int") {
                                            ?>
                                            <input name="fields[<?php echo $key; ?>[options][<?php echo $key; ?>]" type="number"  class="form-control" value="<?php echo $value; ?>" >
                                            <?php
                                        } else if ($config['type'] == "bool") {
                                            $checked = "";
                                            if (is_bool($value) and (bool) $value == true) {
                                                $checked = "checked";
                                            }
                                            ?>
                                            <input <?php echo $checked; ?> name="fields[<?php echo $key; ?>][options][<?php echo $key; ?>]" type="checkbox"  class="form-control" value="1">
                                            <?php
                                        } else if ($config['type'] == "select") {
                                            ?>
                                            <select name="fields[<?php echo $key; ?>][options][<?php echo $key; ?>]" class="form-control">
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


                        <a href="#" data-edit='1' data-link="<?php if ($form['type'] == "mysql") { ?>content/tables/field/<?php } else { ?>mg/collections/field/<?php } ?>" data-next="0" class="btn btn-success addfield"><i class="fa fa-plus"></i> <?php echo __("backend/forms.field_form"); ?></a>
                    </td>
                </tr>     
                <?php
            }
            ?>
            <tr><td><?php echo csrf_field(); ?></td>
                <td><button class="btn btn-danger "  ><?php echo __("backend/forms.form_edit"); ?></button></td>
            </tr>
        </table>
    </form>
</div>