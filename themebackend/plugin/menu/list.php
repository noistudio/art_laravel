<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">
                <?php
                if (\admins\models\AdminAuth::have("menu_create")) {
                    ?>
                    <a href="{pathadmin}menu/add" class="btn btn-danger"><i class="fa fa-plus"></i>Добавить меню</a>
                    <?php
                }
                ?>
            </div>
        </div>
        <h2><?php echo __("backend/menu.list"); ?></h2>

    </div>
    <!-- END Example Title -->

    <!-- Example Content -->
    <table class="table">
        <thead>
            <tr>


                <th><?php echo __("backend/menu.menu_title"); ?></th>
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

                        <td><?php echo $row->title; ?></td>

                        <td><a class="btn btn-primary" href="{pathadmin}menu/update/<?= $row->id; ?>"><i class="fa fa-pencil-square-o"></i><?php echo __("backend/menu.edit"); ?></a></td>
                        <td>
                            <?php
                            if (\admins\models\AdminAuth::have("menu_delete")) {
                                ?>
                                <a class="deleteerror btn btn-primary" data-msg="<?php echo __("backend/menu.want_delete"); ?>" href="{pathadmin}menu/delete/<?= $row->id; ?>"><i class="fa fa-remove"></i></a>
                                    <?php
                                }
                                ?>
                        </td>

                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>

</div>
