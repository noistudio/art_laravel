<ol class="breadcrumb">


    <li class="active"><?php echo __("backend/share.templates"); ?></li>
</ol>

<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">
                <?php
                if (\admins\models\AdminAuth::isRoot()) {
                    ?>
                    <a href="<?php echo route('backend/share/add'); ?>" class="btn btn-success"><?php echo __("backend/share.add"); ?></a>
                    <?php
                }
                ?>

            </div>
        </div>
        <h2><?php echo __("backend/share.templates"); ?></h2>
    </div>
    <!-- END Example Title -->

    <!-- Example Content -->
    <table class="table">
        <thead>
            <tr>
                <th><?php echo __("backend/share.title"); ?></th>



                <th></th>
                <th></th>


            </tr>
        </thead>
        <tbody>
            <?php
            if (count($rows)) {
                foreach ($rows as $key => $row) {
                    ?>
                    <tr>
                        <td><?php echo $row['title'] ?></td>

                        <th>
                            <?php
                            if (\admins\models\AdminAuth::isRoot()) {
                                ?>
                                <a href="<?php echo route('backend/share/edit', $key); ?>" ><i class="fa fa-pencil"></i> <?php echo __("backend/share.edit"); ?></a>
                                <?php
                            }
                            ?>
                        </th>
                        <th>
                            <?php
                            if (\admins\models\AdminAuth::isRoot()) {
                                ?>
                                <a href="<?php echo route('backend/share/delete', $key); ?>" data-msg="<?php echo __("backend/share.delete_want", array('name' => $row['title'])); ?>  " class="deleteerror btn btn-danger"><?php echo __("backend/share.delete"); ?><</a>
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
