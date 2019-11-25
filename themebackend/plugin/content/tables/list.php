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

    <!-- Example Content -->
    <table class="table">
        <thead>
            <tr>
                <th><?php echo __("backend/content.table_title2") ?></th>



                <th></th>
                <th></th>


            </tr>
        </thead>
        <tbody>
            <?php
            if (count($tables)) {
                foreach ($tables as $row) {
                    ?>
                    <tr>
                        <td><a class="btn btn-primary" href="{pathadmin}content/manage/index/<?php echo $row->name; ?>"><?php echo $row->title; ?></a></td>

                        <th>
                            <?php
                            if (\admins\models\AdminAuth::isRoot()) {
                                ?>
                                <a href="{pathadmin}content/tables/edit/<?php echo $row->name; ?>" ><i class="fa fa-pencil"></i> <?php echo __("backend/content.manage_fields") ?></a>
                                <?php
                            }
                            ?>
                        </th>
                        <th>
                            <?php
                            if (\admins\models\AdminAuth::isRoot()) {
                                ?>
                                <form action="<?php echo route('backend/content/tables/delete'); ?>" method="POST">
                                    <input type="hidden" name="table" value="<?php echo $row->name; ?>">
                                    <?php echo csrf_field(); ?>
                                    <button    data-msg="<?php echo __("backend/content.want_delete_table", array('name' => $row->name)); ?> " class="deleteerror btn btn-danger">Удалить таблицу</button>  
                                </form>

                                <?php
                            }
                            ?>
                        </th>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>

</div>
