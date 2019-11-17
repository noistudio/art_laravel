<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">
                <?php
                if (\admins\models\AdminAuth::have("routes_see") or \admins\models\AdminAuth::have("routes_all")) {
                    ?>
                    <a href="{pathadmin}routes/add/index" class="btn btn-danger"><i class="fa fa-plus"></i>Добавить ссылку</a>
                    <?php
                }
                ?>
            </div>
        </div>
        <h2><?php echo __("backend/routes.name"); ?></h2>

    </div>
    <p><a href="https://github.com/artesaos/seotools" target="_blank">https://github.com/artesaos/seotools</a></p>
    <!-- END Example Title -->

    <!-- Example Content -->
    <table class="table">
        <thead>
            <tr>


                <th><?php echo __("backend/routes.old_link"); ?></th>
                <th><?php echo __("backend/routes.new_link"); ?></th>
                <th><?php echo __("backend/routes.meta_title"); ?></th>
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

                        <td><?php echo $row->old_url; ?></td>
                        <td><?php echo $row->new_url; ?></td>
                        <td><?php echo $row->title; ?></td>
                        <td><a class="btn btn-primary" href="{pathadmin}routes/update/<?= $row->id; ?>"><i class="fa fa-pencil-square-o"></i></a></td>
                        <td>
                            <?php
                            if ((\admins\models\AdminAuth::have("routes_delete") or \admins\models\AdminAuth::have("routes_all"))) {
                                ?>
                                <a class="btn btn-primary" href="{pathadmin}routes/delete/<?= $row->id; ?>"><i class="fa fa-remove"></i></a>
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
