<ol class="breadcrumb">
    <li><a href="{pathadmin}mg/collections/index"><?php echo __("backend/mg.all_collections"); ?></a></li>

    <li class="active"><?php echo $collection->title; ?></li>
</ol>

<div class="well">
    <p><?php echo __("backend/mg.pages_templates_for"); ?> <strong><?php echo $collection->title; ?></strong>:  <a class="btn btn-warning" href="{pathadmin}mg/template/list/<?php echo $collection->name; ?>"><?php echo __("backend/mg.t_list"); ?></a> <?php echo __("backend/mg.or"); ?>  <a class="btn btn-warning" href="{pathadmin}mg/template/one/<?php echo $collection->name; ?>"><?php echo __("backend/mg.t_one"); ?></a> <?php echo __("backend/mg.or"); ?> <a class="btn btn-warning" href="{pathadmin}mg/template/rss/<?php echo $collection->name; ?>"><?php echo __("backend/mg.t_rss"); ?></a></p>

</div>


<div class="block_need_url" data-url="<?php echo route("frontend/mg/" . $collection->name . "/list", array(), false); ?>"></div>
<?php
if (\languages\models\LanguageHelp::is("frontend")) {
    $languages = \languages\models\LanguageHelp::getAll("frontend");
    ?>
    <div class="well">
        <p><strong><?php echo __("backend/mg.choose_lng"); ?>:</strong>
            <a class="btn btn-primary <?php
            if ($lang == "null") {
                echo 'active';
            }
            ?>" href="{pathadmin}mg/manage/<?php echo $collection->name; ?>/null"><?php echo __("backend/mg.for_all"); ?></a>    
               <?php
               foreach ($languages as $language) {
                   ?>
                <a class="btn btn-primary <?php
                if ($lang == $language) {
                    echo 'active';
                }
                ?>" href="{pathadmin}mg/manage/<?php echo $collection->name; ?>/<?php echo $lang; ?>"><?php echo $lang; ?></a> 
                   <?php
               }
               ?></p>  
    </div>
    <?php
}
?>

<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">

                <a href="{pathadmin}mg/manage/add/<?php echo $collection->name; ?>" class="btn btn-danger"><i class="fa fa-plus"></i><?php echo __("backend/mg.add_list_btn"); ?></a>
            </div>
        </div>
        <h2><?php echo $collection->title; ?></h2>
    </div>

    <h4><?php echo __("backend/mg.setup_select"); ?></h4>
    <?php ?>
    <form action='' method='GET'>
        <table class="table">

            <tr>
                <td><?php ?><input name="conditions[]" <?php
                    if (isset($_GET['conditions']) and is_array($_GET['conditions']) and in_array("enable", $_GET['conditions']) === true) {
                        echo 'checked';
                    }
                    ?> value="enable" type="checkbox"  ></td>
                <td><?php echo __("backend/mg.status"); ?></td>
                <td>
                    <?php echo __("backend/mg.op_="); ?>
                </td>
                <td>  <select class="form-control" name="enable">
                        <option value='null'></option>
                        <option <?php
                        if (isset($_GET['enable']) and $_GET['enable'] == "on") {
                            echo 'selected';
                        }
                        ?> value='on'><?php echo __("backend/mg.s_enable"); ?></option>
                        <option <?php
                        if (isset($_GET['enable']) and $_GET['enable'] == "off") {
                            echo 'selected';
                        }
                        ?>  value='off'><?php echo __("backend/mg.s_disable"); ?></option>
                    </select></td>
            </tr> 
            <?php
            if (count($fields_search)) {
                foreach ($fields_search as $field_name => $field) {
                    if ($field['showsearch'] == 1) {
                        ?>
                        <tr>
                            <td><?php ?><input name="conditions[]" <?php
                                if (isset($_GET['conditions']) and is_array($_GET['conditions']) and in_array($field['name'], $_GET['conditions']) === true) {
                                    echo 'checked';
                                }
                                ?> value="<?php echo $field['name']; ?>" type="checkbox"  ></td>
                            <td><?php echo $field['title']; ?></td>
                            <td>
                                <select class="form-control" name="type_<?php echo $field['name']; ?>">
                                    <option <?php
                                    if (isset($_GET['type_' . $field['name']]) and $_GET['type_' . $field['name']] == "=") {
                                        echo 'selected';
                                    }
                                    ?> value='='><?php echo __("backend/mg.op_="); ?></option>
                                    <option <?php
                                    if (isset($_GET['type_' . $field['name']]) and $_GET['type_' . $field['name']] == "LIKE") {
                                        echo 'selected';
                                    }
                                    ?> value='LIKE'><?php echo __("backend/mg.op_LIKE"); ?></option>
                                    <option <?php
                                    if (isset($_GET['type_' . $field['name']]) and $_GET['type_' . $field['name']] == ">=") {
                                        echo 'selected';
                                    }
                                    ?> value='>='><?php echo __("backend/mg.op_>="); ?></option>
                                    <option <?php
                                    if (isset($_GET['type_' . $field['name']]) and $_GET['type_' . $field['name']] == "<=") {
                                        echo 'selected';
                                    }
                                    ?> value='<='><?php echo __("backend/mg.op_<="); ?></option>
                                    <option <?php
                                    if (isset($_GET['type_' . $field['name']]) and $_GET['type_' . $field['name']] == "!=") {
                                        echo 'selected';
                                    }
                                    ?> value='!='><?php echo __("backend/mg.op_!="); ?></option>
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
        <p class='text-center'><button class='btn btn-danger' type='submit'  ><?php echo __("backend/mg.search"); ?></button></p>
    </form>

    <!-- END Example Title -->
    <form action="{pathadmin}mg/manage/ops/<?php echo $collection->name; ?>" method="POST">
        <?php
        echo csrf_field();
        ?>
        <div class="row">
            <div class="col-md-3">
                <button class="btn btn-primary" type="submit" name="op" value="enable"><i class="fa fa-eye"></i> <?php echo __("backend/mg.btn_enable"); ?></button>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary" type="submit" name="op" value="disable"><i class="fa fa-eye-slash"></i>  <?php echo __("backend/mg.btn_disable"); ?></button>
            </div>
            <div class="col-md-3">
                <button class="btn btn-danger" type="submit" name="op" value="delete"><i class="fa fa-remove"></i>  <?php echo __("backend/mg.btn_delete"); ?></button>
            </div>
        </div>
        <!-- Example Content -->
        <p><input type="checkbox" class="allcheckbox" ></p>


        <?php
        if (count($rows)) {
            foreach ($rows as $row) {
                ?>
                <div class="row"> 
                    <hr style="height:1px;width:100%;color:black;border-top: 1px solid #ccc;;">

                    <div class="col-md-2">
                        <input name="ids[]"   value="<?php echo $row['last_id']; ?>" type="checkbox"  >
                        <br>
                        <?php
                        if ($collection->sort_field == "order_last_id") {
                            ?>
                            <p>
                                <a href="{pathadmin}mg/arrows/up/<?php echo $collection->name; ?>/<?php echo $row["last_id"]; ?>?<?php echo http_build_query($_GET); ?>"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
                                <?php echo $row['order_last_id']; ?>
                                <a href="{pathadmin}mg/arrows/down/<?php echo $collection->name; ?>/<?php echo $row["last_id"]; ?>?<?php echo http_build_query($_GET); ?>"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                            </p>
                            <?php
                        } else {
                            ?>
                            <p><?php echo $row['last_id']; ?></p>
                            <?php
                        }
                        ?>  
                    </div> 
                    <div class="col-md-1">
                        <a href="{pathadmin}mg/manage/enable/<?php echo $collection->name; ?>/<?php echo $row['last_id']; ?>">
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
                    </div>
                    <div class="col-md-6">
                        <?php
                        if (count($fields)) {
                            foreach ($fields as $field) {
                                ?>
                                <p><b><?php echo $field['title']; ?>:</b><?php echo $row[$field['name']]; ?></p>
                                <?php
                            }
                        }
                        ?> 
                    </div>
                    <div class="col-md-3">

                        <p><a class="btn btn-primary" href="{pathadmin}mg/manage/update/<?= $collection->name; ?>/<?= $row['last_id']; ?>/<?php echo $lang; ?>"><i class="fa fa-pencil-square-o"></i> <?php echo __("backend/mg.btn_edit"); ?></a></p>
                        <p><a class="deleteerror btn btn-danger" data-msg="<?php echo __("backend/mg.want_del_row"); ?>" href="{pathadmin}mg/manage/delete/<?= $collection->name; ?>/<?= $row['last_id']; ?>"><i class="fa fa-remove"></i> <?php echo __("backend/mg.btn_delete"); ?></a></p>
                        <p><a class=" btn btn-danger"  href="{pathadmin}mg/manage/clone/<?= $collection->name; ?>/<?= $row['last_id']; ?>"> <?php echo __("backend/mg.btn_clone"); ?></a></p>

                    </div>
                    <hr style="height:1px;width:100%;color:black;border-top: 1px solid #ccc;;">
                </div>

                <?php
            }
        }
        ?>

    </form>
    <?php echo $pages; ?>
</div>
