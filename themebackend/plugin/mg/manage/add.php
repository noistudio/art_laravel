<ol class="breadcrumb">
    <li><a href="{pathadmin}mg/collections/index"><?php echo __("backend/mg.all_collections"); ?></a></li>
    <li><a href="{pathadmin}mg/manage/<?php echo $collection->name; ?>"><?php echo $collection->title; ?></a></li>
    <li class="active"><?php echo __("backend/mg.add_row"); ?></li>
</ol>
<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo __("backend/mg.add_in", array('name' => $collection->title)); ?></h2>
    </div>
    <!-- END Example Title -->

    <!-- Example Content -->
    <form enctype="multipart/form-data" class="superjax" data-success="{pathadmin}mg/manage/index/<?php echo $collection->name; ?>" action='{pathadmin}mg/manage/doadd/<?php echo $collection->name; ?>' method="POST">
        <table class="table">
            <tbody>
                <tr>
                    <td><?php echo __("backend/mg.published"); ?></td>
                    <td><input type="checkbox" name="enable" value="1" class="form-control" ></td>
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
                if (count($share_templates)) {
                    foreach ($share_templates as $share) {
                        ?>
                        <tr>
                            <td><input type="checkbox" name="shares[]" class="form-control" value="<?php echo $share['id']; ?>"</td>  
                            <td><?php echo __("backend/mg.publish_in", array('name' => $share['title'])); ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>



                <tr>
                    <td><button type="submit" name="btnaccept" value="1" class="btn btn-warning"><i class="fa fa-floppy-o"></i> <?php echo __("backend/mg.btn_accept"); ?></button></td>

                    <td><button type="submit" class="btn btn-warning"><i class="fa fa-floppy-o"></i> <?php echo __("backend/mg.btn_add"); ?></button></td>

                </tr>

            </tbody>
        </table>
        <?php echo csrf_field(); ?>
    </form>

</div>
