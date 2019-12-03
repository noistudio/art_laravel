<ol class="breadcrumb">


    <li class="active"><?php echo __("backend/content.all_tables") ?></li>
</ol>

<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">
                <?php
                if (\admins\models\AdminAuth::isRoot()) {
                    ?>
                    <a href="{pathadmin}content/tables/add" class="btn btn-success"><?php echo __("backend/content.table_add") ?></a>

                    <?php
                }
                ?>

            </div>
        </div>
        <h2><?php echo __("backend/content.all_tables") ?> </h2>
    </div>
    <!-- END Example Title -->


    <?php
    if (count($tables)) {
        foreach ($tables as $row) {
            ?>
            <div class="block ">
                <div class="block-title">
                    <h2><a class="btn btn-primary" href="{pathadmin}content/manage/index/<?php echo $row->name; ?>"><?php echo $row->title; ?></a></h2> <input type="text" class="form-control" readonly value="<?php echo $row->name; ?>">
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <?php
                        if (\admins\models\AdminAuth::isRoot()) {
                            ?>
                            <a href="{pathadmin}content/tables/edit/<?php echo $row->name; ?>" ><i class="fa fa-pencil"></i> <?php echo __("backend/content.manage_fields") ?></a>
                            <?php
                        }
                        ?>

                    </div>
                    <div class="col-xs-3">
                        <?php
                        if (\admins\models\AdminAuth::isRoot()) {
                            ?>
                            <form action="{pathadmin}content/tables/delete/" method="POST">
                                <input type="hidden" name="table" value="<?php echo $row->name; ?>">
                                <?php echo csrf_field(); ?>
                                <button    data-msg="<?php echo __("backend/content.want_delete_table", array('name' => $row->name)); ?> " class="deleteerror btn btn-danger"><i class="fa fa-remove"></i></button>  
                            </form>

                            <?php
                        }
                        ?>

                    </div>

                </div>
            </div>


            <?php
        }
    }
    ?>





    <!-- Example Content -->


</div>
