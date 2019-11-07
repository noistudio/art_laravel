<ol class="breadcrumb">


    <li class="active"><?php echo __("backend/mg.all_collections"); ?></li>
</ol>

<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">
                <?php
                if (\admins\models\AdminAuth::isRoot()) {
                    ?>
                    <a href="{pathadmin}mg/collections/add" class="btn btn-success"><?php echo __("backend/mg.add_col"); ?></a>
                    <?php
                }
                ?>

            </div>
        </div>
        <h2><?php echo __("backend/mg.all_collections"); ?> </h2>
    </div>
    <!-- END Example Title -->

    <!-- Example Content -->
    <table class="table">
        <thead>
            <tr>
                <th><?php echo __("backend/mg.collection_title"); ?></th>



                <th></th>
                <th></th>


            </tr>
        </thead>
        <tbody>
            <?php
            if (count($collections)) {
                foreach ($collections as $row) {
                    ?>
                    <tr>
                        <td><a class="btn btn-primary" href="{pathadmin}mg/manage/index/<?php echo $row->name; ?>"><?php echo $row->title; ?></a></td>

                        <th>
                            <?php
                            if (\admins\models\AdminAuth::isRoot()) {
                                ?>
                                <a href="{pathadmin}mg/collections/edit/<?php echo $row->name; ?>" ><i class="fa fa-pencil"></i> <?php echo __("backend/mg.manage_fields"); ?></a>
                                <?php
                            }
                            ?>
                        </th>
                        <th>
                            <?php
                            if (\admins\models\AdminAuth::isRoot()) {
                                ?>
                                <a href="{pathadmin}mg/collections/delete/<?php echo $row->name; ?>" data-msg="<?php echo __("backend/mg.want_del_col", array('name' => $row->name)); ?>" class="deleteerror btn btn-danger"><?php echo __("backend/mg.delete"); ?></a>
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
