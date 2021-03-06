<ol class="breadcrumb">
    <li><a href="{pathadmin}content/tables/index"><?php echo __("backend/content.all_tables") ?></a></li>
    <li><a href="{pathadmin}content/manage/<?php echo $table->name; ?>"><?php echo $table->title; ?></a></li>
    <li class="active"><?php echo __("backend/content.edit_document") ?></li>
</ol>
<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo $table->title; ?></h2>
    </div>
    <!-- END Example Title -->
    <?php
    if ($needroute) {
        ?>
        <div class="block_need_url" data-url="<?php echo route('frontend/content/' . $table->name . "/one", $document['last_id'], false); ?>"></div>
        <?php
    }
    ?>
    <!-- Example Content -->
    <form enctype="multipart/form-data" class="superjax" data-success="{pathadmin}content/manage/index/<?php echo $table->name; ?>" action='{pathadmin}content/manage/doupdate/<?php echo $table->name; ?>/<?php echo $id; ?>' method="POST">
        <table class="table">
            <tbody>
                <tr>
                    <td><?php echo __("backend/content.publish") ?></td>
                    <td><input <?php
                        if ((int) $document['enable'] == 1) {
                            echo 'checked';
                        }
                        ?> type="checkbox" name="enable" value="1" class="form-control" ></td>
                </tr>
                <?php
                if (count($row)) {
                    foreach ($row as $field) {
                        if ($field['type'] == "Editorjss") {
                            ?>
                            <tr>

                                <td colspan="2" style="width:100%;"><?php echo $field['input']; ?></td>
                            </tr>
                            <?php
                        } else {
                            ?>
                            <tr>
                                <td><?php echo $field['title']; ?></td>
                                <td><?php echo $field['input']; ?></td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>



                <?php
                if (\languages\models\LanguageHelp::is("frontend")) {
                    $languages = \languages\models\LanguageHelp::getAll("frontend");
                    if (count($languages)) {
                        ?>
                        <tr>
                            <td><?php echo __("backend/content.language") ?></td>
                            <td>
                                <select name="_lng" class="form-control">
                                    <option value="all"><?php echo __("backend/content.all_languages") ?></option>
                                    <?php
                                    foreach ($languages as $language) {
                                        $selected = "";
                                        if (isset($document['_lng']) and ! is_null($document['_lng']) and $document['_lng'] == $language) {
                                            $selected = "selected";
                                        }
                                        ?>
                                        <option <?php echo $selected; ?> value="<?php echo $language; ?>"><?php echo $language; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <?php
                if (count($share_templates)) {
                    foreach ($share_templates as $share) {
                        ?>
                        <tr>
                            <td><input type="checkbox" name="shares[]" class="form-control" value="<?php echo $share['id']; ?>"</td>  
                            <td><?php echo __("backend/content.publish_in", array('name' => $share['title'])); ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>

                <tr>
                    <td><button type="submit" name="btnaccept" value="1" class="btn btn-warning"><i class="fa fa-floppy-o"></i> <?php echo __("backend/content.apply") ?></button></td>
                    <td><button type="submit" class="btn btn-warning"><i class="fa fa-floppy-o"></i> <?php echo __("backend/content.save") ?></button></td>

                </tr>

            </tbody>
        </table>
        <?php echo csrf_field(); ?>
    </form>

</div>
