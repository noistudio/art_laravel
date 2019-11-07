
<ol class="breadcrumb">
    <li><a href="{pathadmin}content/tables/index"><?php echo __("backend/content.all_tables") ?></a></li>

    <li class="active"><?php echo $table->title; ?></li>
</ol>

<div class="well">
    <p><?php echo __("backend/content.pages_template_for", array('name' => $table->title)) ?>:  <a class="btn btn-warning" href="{pathadmin}content/template/list/<?php echo $table->name; ?>"><?php echo __("backend/content.list_documents") ?></a> <?php echo __("backend/content.or") ?>  <a class="btn btn-warning" href="{pathadmin}content/template/one/<?php echo $table->name; ?>"><?php echo __("backend/content.one_document") ?></a> <?php echo __("backend/content.or") ?> <a class="btn btn-warning" href="{pathadmin}content/template/rss/<?php echo $table->name; ?>"><?php echo __("backend/content.rss_feed") ?></a></p>

</div>
<?php
if ($needroute) {
    ?>
    <div class="block_need_url" data-url="/content/<?php echo $table->name; ?>/index"></div>
    <?php
}
?>
<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">

                <a href="{pathadmin}content/manage/add/<?php echo $table->name; ?>" class="btn btn-danger"><i class="fa fa-plus"></i><?php echo __("backend/content.add") ?></a>

            </div>
        </div>
        <div class="  pull-left">
            <?php
            if (\admins\models\AdminAuth::isRoot()) {
                ?>
                <a href="{pathadmin}content/tables/edit/<?php echo $table->name; ?>" class="btn   btn-danger"><i class="fa fa-cogs"></i><?php echo __("backend/content.table_config") ?> </a>

                <?php
            }
            ?>
        </div>
        <h2><?php echo $table->title; ?></h2>
    </div>

    <h4><?php echo __("backend/content.setup_select") ?></h4>
    <?php
    ?>
    <form action='' method='GET'>
        <table class="table">
            <?php
            if (\languages\models\LanguageHelp::is()) {
                ?>
                <tr>

                    <td><?php echo __("backend/content.language") ?></td>
                    <td>
                        <?php echo __("backend/content.op_=") ?>
                    </td>
                    <td>  <select class="form-control" name="_lng">
                            <option value='null'></option>
                            <?php
                            $languages = \languages\models\LanguageHelp::getAll();
                            if (count($languages)) {
                                foreach ($languages as $language) {
                                    $selected = "";
                                    if (isset($_GET['_lng']) and is_string($_GET['_lng']) and ( $_GET['_lng'] == $language)) {
                                        $selected = "selected";
                                    }
                                    ?>
                                    <option <?php echo $selected; ?> value="<?php echo $language; ?>"><?php echo $language; ?></option>
                                    <?php
                                }
                            }
                            ?>

                        </select></td>
                </tr> 
                <?php
            }
            ?>
            <tr>

                <td><?php echo __("backend/content.status") ?></td>
                <td>
                    <?php echo __("backend/content.op_=") ?>
                </td>
                <td>  <select class="form-control" name="enable">
                        <option value='null'></option>
                        <option <?php
                        if (isset($_GET['enable']) and $_GET['enable'] == "on") {
                            echo 'selected';
                        }
                        ?> value='on'><?php echo __("backend/content.status_on") ?></option>
                        <option <?php
                        if (isset($_GET['enable']) and $_GET['enable'] == "off") {
                            echo 'selected';
                        }
                        ?>  value='off'><?php echo __("backend/content.status_off") ?></option>
                    </select></td>
            </tr> 
            <?php
            if (count($fields_search)) {
                foreach ($fields_search as $field_name => $field) {
                    if ($field['showsearch'] == 1) {
                        ?>
                        <tr>

                            <td><?php echo $field['title']; ?></td>
                            <td>
                                <select class="form-control" name="type_<?php echo $field['name']; ?>">
                                    <option <?php
                                    if (isset($_GET['type_' . $field['name']]) and $_GET['type_' . $field['name']] == "=") {
                                        echo 'selected';
                                    }
                                    ?> value='='><?php echo __("backend/content.op_=") ?></option>
                                    <option <?php
                                    if (isset($_GET['type_' . $field['name']]) and $_GET['type_' . $field['name']] == "LIKE") {
                                        echo 'selected';
                                    }
                                    ?> value='LIKE'><?php echo __("backend/content.op_like") ?></option>
                                    <option <?php
                                    if (isset($_GET['type_' . $field['name']]) and $_GET['type_' . $field['name']] == ">=") {
                                        echo 'selected';
                                    }
                                    ?> value='>='><?php echo __("backend/content.op_>=") ?></option>
                                    <option <?php
                                    if (isset($_GET['type_' . $field['name']]) and $_GET['type_' . $field['name']] == "<=") {
                                        echo 'selected';
                                    }
                                    ?> value='<='><?php echo __("backend/content.op_<=") ?></option>
                                    <option <?php
                                    if (isset($_GET['type_' . $field['name']]) and $_GET['type_' . $field['name']] == "!=") {
                                        echo 'selected';
                                    }
                                    ?> value='!='><?php echo __("backend/content.op_!=") ?></option>
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
        <p class='text-center'><button class='btn btn-danger' type='submit'    ><?php echo __("backend/content.op_like") ?></button></p>
    </form>

    <!-- END Example Title -->
    <form action="{pathadmin}content/manage/ops/<?php echo $table->name; ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-md-3">
                <button class="btn btn-primary" type="submit" name="op" value="enable"><i class="fa fa-eye"></i> <?php echo __("backend/content.enable") ?></button>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary" type="submit" name="op" value="disable"><i class="fa fa-eye-slash"></i> <?php echo __("backend/content.disable") ?></button>
            </div>
            <div class="col-md-3">
                <button class="btn btn-danger" type="submit" name="op" value="delete"><i class="fa fa-remove"></i> <?php echo __("backend/content.delete") ?></button>
            </div>
        </div>
        <!-- Example Content -->
        <table class="table">
            <thead>
                <tr>
                    <th><input type="checkbox" class="allcheckbox" ></th>
                    <th></th>
                    <?php
                    if (\languages\models\LanguageHelp::is()) {
                        ?>
                        <th><?php echo __("backend/content.language") ?></th>
                        <?php
                    }
                    ?>
                    <th><?php echo __("backend/content.status") ?></th>
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
                            <?php
                            if ($table->sort_field == "arrow_sort") {
                                ?>
                                <td>
                                    <?php
                                    if ($table->sort_type == "ASC") {
                                        ?>


                                        <a href="{pathadmin}content/arrows/up/<?php echo $table->name; ?>/<?php echo $row["last_id"]; ?>?<?php echo $get_vars_string; ?>"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>

                                        <p><input type="number" class="form-control position" value="<?php echo $row['sort']; ?>"><button type="button" data-link="{pathadmin}content/arrows/move/<?php echo $table->name; ?>/<?php echo $row["last_id"]; ?>/" class="movebtn btn btn-danger"><?php echo __("backend/content.move") ?></button></p>
                                        <a href="{pathadmin}content/arrows/down/<?php echo $table->name; ?>/<?php echo $row["last_id"]; ?>?<?php echo $get_vars_string; ?>"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="{pathadmin}content/arrows/down/<?php echo $table->name; ?>/<?php echo $row["last_id"]; ?>?<?php echo $get_vars_string; ?>"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
                                        <p><input type="number" class="form-control position" value="<?php echo $row['sort']; ?>"><button type="button" data-link="{pathadmin}content/arrows/move/<?php echo $table->name; ?>/<?php echo $row["last_id"]; ?>/" class="movebtn btn btn-danger"><?php echo __("backend/content.move") ?></button></p>
                                        <a href="{pathadmin}content/arrows/up/<?php echo $table->name; ?>/<?php echo $row["last_id"]; ?>?<?php echo $get_vars_string; ?>"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <?php
                            } else {
                                ?>
                                <td><?php echo $row['last_id']; ?></td>
                                <?php
                            }
                            ?>
                            <?php
                            if (\languages\models\LanguageHelp::is()) {
                                ?>
                                <td><?php
                                    if (!is_null($row['_lng'])) {
                                        echo $row['_lng'];
                                    }
                                    ?></td>
                                <?php
                            }
                            ?>
                            <td>
                                <a href="{pathadmin}content/manage/enable/<?php echo $table->name; ?>/<?php echo $row['last_id']; ?>">
                                    <?php
                                    if ((int) $row['enable'] == 1) {
                                        ?>
                                        <i class="fa fa-eye"></i>
                                        <?php
                                    } else {
                                        ?>
                                        <i class="fa fa-eye-slash"></i>   
                                        <?php
                                    }
                                    ?>
                                </a>    
                            </td>
                            <?php
                            if (count($fields)) {
                                foreach ($fields as $field) {
                                    $val = "";
                                    if (isset($row[$field['name'] . "_val"])) {
                                        $val = $row[$field['name'] . "_val"];
                                    }

                                    $field['obj']->_set($val);
                                    ?>
                                    <td><?php echo $field['obj']->renderValue(); ?></td>
                                    <?php
                                }
                            }
                            ?>
                            <td><a class="btn btn-primary" href="{pathadmin}content/manage/update/<?= $table->name; ?>/<?= $row['last_id']; ?>"><i class="fa fa-pencil-square-o"></i><?php echo __("backend/content.editing") ?></a></td>
                            <td><a class="deleteerror btn btn-danger" data-msg="<?php echo __("backend/content.want_delete") ?>" href="{pathadmin}content/manage/delete/<?= $table->name; ?>/<?= $row['last_id']; ?>"><i class="fa fa-remove"></i><?php echo __("backend/content.delete") ?></a></td>

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
