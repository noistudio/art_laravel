
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
    <div class="block_need_url" data-url="<?php echo route('frontend/content/' . $table->name . "/list", array(), false); ?>"></div>
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

        <?php
        if (\languages\models\LanguageHelp::is("frontend")) {
            ?>



            <div class="form-group">
                <label class="col-md-3 control-label" for="example-hf-email"><?php echo __("backend/content.language") ?></label>
                <div class="col-md-2"> <?php echo __("backend/content.op_=") ?></div>
                <div class="col-md-7">
                    <select class="form-control" name="_lng">
                        <option value='null'></option>
                        <?php
                        $languages = \languages\models\LanguageHelp::getAll("frontend");
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

                    </select>
                </div>
            </div>


            <?php
        }
        ?>

        <div class="form-group">
            <label class="col-md-3 control-label" for="example-hf-email"><?php echo __("backend/content.status") ?></label>
            <div class="col-md-2"> <?php echo __("backend/content.op_=") ?></div>
            <div class="col-md-7">
                <select class="form-control" name="enable">
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
                </select>
            </div>
        </div>

        <?php
        if (count($fields_search)) {
            foreach ($fields_search as $field_name => $field) {
                if ($field['showsearch'] == 1) {
                    ?>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-hf-email"><?php echo $field['title']; ?></label>
                        <div class="col-md-2">   <select class="form-control" name="type_<?php echo $field['name']; ?>">
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


        <p class='text-center'><button class='btn btn-danger' type='submit'    ><?php echo __("backend/content.op_like") ?></button></p>
    </form>

    <!-- END Example Title -->
    <form action="{pathadmin}content/manage/ops/<?php echo $table->name; ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="block ">
            <div class="row">
                <div class="col-md-3">
                    <button class="btn btn-primary" type="submit" name="op" value="enable"><i class="fa fa-eye"></i> <?php echo __("backend/blocks.enable"); ?></button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary" type="submit" name="op" value="disable"><i class="fa fa-eye-slash"></i> <?php echo __("backend/blocks.disable"); ?></button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-danger" type="submit" name="op" value="delete"><i class="fa fa-remove"></i> <?php echo __("backend/blocks.delete"); ?></button>
                </div>
            </div>
        </div>


        <?php
        if (count($rows)) {
            foreach ($rows as $row) {
                ?>
                <div class="block ">
                    <div class="block-title">
                        <div class="row">
                            <div class="col-xs-4"><a href="<?php echo $row['img_val']; ?>" target="_blank"><img src="<?php echo $row['img_val']; ?>" class="img img-thumbnail"></a></div>  
                            <div class="col-xs-8">  <?php echo $row['content_val']; ?></div>
                        </div>




                    </div>
                    <div class="row">
                        <div class="col-xs-1">
                            <input type="checkbox" name="ids[]" value="<?php echo $row['last_id']; ?>">

                        </div>
                        <?php
                        if ($table->sort_field == "arrow_sort") {
                            ?>
                            <div class="col-xs-1">
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
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="col-xs-1"><?php echo $row['last_id']; ?></div>
                            <?php
                        }
                        ?>
                        <div class="col-xs-offset-1 col-xs-4 ">
                            <a class="btn btn-primary" href="{pathadmin}content/manage/update/<?= $table->name; ?>/<?= $row['last_id']; ?>"><i class="fa fa-pencil-square-o"></i><?php echo __("backend/content.editing") ?></a>
                        </div>
                        <div class="col-xs-3 pull-right"><a class="deleteerror btn btn-danger" data-msg="<?php echo __("backend/content.want_delete") ?>" href="{pathadmin}content/manage/delete/<?= $table->name; ?>/<?= $row['last_id']; ?>"><i class="fa fa-remove"></i></a></div>
                    </div>

                </div>



                <?php
            }
        }
        ?>


        <!-- Example Content -->

    </form>
    <?php echo $pages; ?>
</div>
