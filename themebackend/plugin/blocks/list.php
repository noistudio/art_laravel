<ol class="breadcrumb">


    <li class="active"><?php echo __("backend/blocks.all_blocks"); ?></li>
</ol>
<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">
                <?php
                if (\admins\models\AdminAuth::have("block_create")) {
                    ?>
                    <a href="{pathadmin}blocks/add/index" class="btn btn-danger"><i class="fa fa-plus"></i><?php echo __("backend/blocks.add_block"); ?></a>
                    <?php
                }
                ?>
            </div>
        </div>
        <h2><?php echo __("backend/blocks.blocks"); ?></h2>

    </div>
    <!-- END Example Title -->
    <form action="{pathadmin}blocks/ops" method="POST">
        <?php echo csrf_field(); ?>
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
        <!-- Example Content -->
        <table class="table">
            <thead>
                <tr>
                    <th><input type="checkbox" class="allcheckbox" ></th>
                    <th><?php echo __("backend/blocks.status"); ?></th>
                    <th><?php echo __("backend/blocks.title"); ?></th>
                    <th></th>
                    <th></th>
                    <th></th>


                </tr>
            </thead>
            <tbody>
                <?php
                if (count($rows)) {
                    foreach ($rows as $row) {
                        $text = '[block' . $row->id . ']';
                        $text = htmlspecialchars($text);
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="ids[]" value="<?php echo $row->id; ?>">
                            </td>
                            <td>
                                <a href="{pathadmin}blocks/enable/<?php echo $row->id; ?>">
                                    <?php
                                    if ((int) $row->status == 1) {
                                        ?>
                                        <i class="fa fa-eye"></i>
                                        <?php
                                    } else {
                                        ?>
                                        <i class="fa fa-eye-slash"></i>   
                                        <?php
                                    }
                                    ?>
                                </a>    
                            </td>
                            <td><?= $row->title; ?></td>

                            <td><input type="text" class="form-control" readonly value="<?php echo $text; ?>"></td>
                            <td><a class="btn btn-primary" href="{pathadmin}blocks/update/<?= $row->id; ?>"><i class="fa fa-pencil-square-o"></i><?php echo __("backend/blocks.edit_btn"); ?></a></td>
                            <td>
                                <?php
                                if (\admins\models\AdminAuth::have("block_delete")) {
                                    ?>
                                    <a class="deleteerror btn btn-primary" data-msg="<?php echo __("backend/blocks.want_delete"); ?>" href="{pathadmin}blocks/delete/<?= $row->id; ?>"><i class="fa fa-remove"></i></a>
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
    </form>

</div>
