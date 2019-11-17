<ol class="breadcrumb">
    <li><a href="{pathadmin}mg/collections/index"><?php echo __("backend/mg.all_collections"); ?></a></li>
    <li><a href="{pathadmin}mg/manage/<?php echo $collection->name; ?>"><?php echo $collection->title; ?></a></li>
    <li class="active"><?php echo __("backend/mg.edit_row"); ?></li>
</ol>
<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo $collection->title; ?></h2>
    </div>
    <!-- END Example Title -->


    <div class="block_need_url" data-url="<?php echo route("frontend/mg/" . $collection->name . "/one", $document['last_id'], false); ?>"></div>


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
                ?>" href="{pathadmin}mg/manage/update/<?php echo $collection->name; ?>/<?php echo $document['last_id']; ?>/null">Для всех</a>    
                   <?php
                   foreach ($languages as $lang) {
                       ?>
                    <a class="btn btn-primary <?php
                    if ($lang == $lang) {
                        echo 'active';
                    }
                    ?>" href="{pathadmin}mg/manage/update/<?php echo $collection->name; ?>/<?php echo $document['last_id']; ?>/<?php echo $lang; ?>"><?php echo $lang; ?></a> 
                       <?php
                   }
                   ?></p>  
        </div>
        <?php
    }
    ?>
    <!-- Example Content -->
    <form enctype="multipart/form-data" class="superjax" data-success="{pathadmin}mg/manage/index/<?php echo $collection->name; ?>/<?php echo $lang; ?>" action='{pathadmin}mg/manage/doupdate/<?php echo $collection->name; ?>/<?php echo $id; ?>/<?php echo $lang; ?>' method="POST">
        <table class="table">
            <tbody>
                <tr>
                    <td><?php echo __("backend/mg.published"); ?></td>
                    <td><input <?php
                        if ((int) $document['enable'] == 1) {
                            echo 'checked';
                        }
                        ?> type="checkbox" name="enable" value="1" class="form-control" ></td>
                </tr>
                <?php
                if (count($row)) {
                    foreach ($row as $field) {
                        ?>
                        <tr>
                            <td><?php echo $field['title']; ?></td>
                            <td><?php echo $field['input']; ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>





                <?php
                if (isset($share_templates) and count($share_templates)) {
                    foreach ($share_templates as $share) {
                        ?>
                        <tr >
                            <td><input type="checkbox" name="shares[]" class="form-control" value="<?php echo $share['id']; ?>"</td>  
                            <td>Опубликовать в <?php echo $share['title']; ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td><button type="submit" name="btnaccept" value="1" class="btn btn-warning"><i class="fa fa-floppy-o"></i> <?php echo __("backend/mg.btn_accept"); ?></button></td>
                    <td><button type="submit" class="btn btn-warning"><i class="fa fa-floppy-o"></i> <?php echo __("backend/mg.btn_save"); ?></button></td>

                </tr>

            </tbody>
        </table>
        <?php echo csrf_field(); ?>
    </form>

</div>
