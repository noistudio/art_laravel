<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <?php echo __("backend/main.backup_create"); ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="<?php echo route('backend/backup/create') ?>"><?php echo __("backend/main.full_backup"); ?></a></li>
                        <li><a href="<?php echo route('backend/backup/createonlydb') ?>"><?php echo __("backend/main.only_db"); ?></a></li>

                    </ul>
                </div>



            </div>
        </div>
        <h2><?php echo __("backend/main.backups"); ?></h2>

    </div>
    <?php
    if (\core\ManagerConf::isMongodb()) {
        ?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <?php echo __("backend/main.backup_faq1"); ?>
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <?php echo __("backend/main.backup_faq2"); ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <?php echo __("backend/main.backup_faq3"); ?>
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <?php echo __("backend/main.backup_faq4"); ?>
                    </div>
                </div>
            </div>

        </div>
        <?php
    }
    ?>
    <!-- END Example Title -->

    <table class="table">
        <thead>
            <tr>
                <th><?php echo __("backend/main.backup_name"); ?></th>
                <th><?php echo __("backend/main.backup_date"); ?> </th>
                <th><?php echo __("backend/main.backup_size"); ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($backups)) {
                foreach ($backups as $backup) {
                    ?>
                    <tr>
                        <td><?php echo $backup['file_name']; ?></td>
                        <td><?php echo date('d.m.Y H:i', $backup['last_modified']); ?></td>
                        <td><?php echo $backup['file_size']; ?> MB</td>
                        <td><a class="btn btn-danger" href="<?php echo route('backend/backup/delete', $backup['file_name']); ?>"><?php echo __("backend/main.backup_delete"); ?></a></td>
                        <td><a target="_blank" class="btn btn-primary" href="<?php echo route('backend/backup/download', $backup['file_name']); ?>"><?php echo __("backend/main.backup_download"); ?></a></td>
                    </tr>

                    <?php
                }
            }
            ?>
        </tbody>
    </table>

</div>
