<ol class="breadcrumb">


    <li class="active"><?php echo __("backend/logs.logs"); ?></li>
</ol>
<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">

                <a target="_blank" href="<?php echo route('backend/logs/see'); ?>" class="btn btn-danger"><?php echo __("backend/logs.see_logs"); ?></a>

                <a href="<?php echo $admin_url; ?>logs/add/index" class="btn btn-danger"><i class="fa fa-plus"></i><?php echo __("backend/logs.add"); ?></a>

            </div>
        </div>
        <h2><?php echo __("backend/logs.logs"); ?></h2>

    </div>
    <!-- END Example Title -->


    <!-- Example Content -->
    <table class="table">
        <thead>
            <tr>



                <th><?php echo __("backend/logs.status"); ?></th>
                <th><?php echo __("backend/logs.chanel"); ?></th>
                <th><?php echo __("backend/logs.level"); ?></th>

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


                        <td>
                            <?php
                            if (isset($row->status) and $row->status == "enable") {
                                ?>
                                <i class="fa fa-eye"></i>
                                <?php
                            } else {
                                ?>
                                <i class="fa fa-eye-slash"></i>   
                                <?php
                            }
                            ?>
                        </td>


                        <td><?php echo $row->channel; ?></td>
                        <td><?php echo $row->level; ?></td>
                        <td><a class="btn btn-primary" href="<?php echo $admin_url; ?>logs/update/<?= $row->id; ?>"><i class="fa fa-pencil-square-o"></i><?php echo __("backend/logs.edit_btn"); ?></a></td>
                        <td>

                            <a class="deleteerror btn btn-primary" data-msg="<?php echo __("backend/logs.want_delete"); ?>" href="<?php echo $admin_url; ?>logs/delete/<?= $row->id; ?>"><i class="fa fa-remove"></i></a>

                        </td>

                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>


</div>
