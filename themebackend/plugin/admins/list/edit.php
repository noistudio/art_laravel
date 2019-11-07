<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">
                <ol class="breadcrumb">
                    <li><a href="<?php echo route("backend/index"); ?>"><i class="fa fa-home"></i></a></li>
                    <li><a href="<?php echo route("backend/admins/list/index"); ?>"><?php echo __("backend/admins.admins"); ?></a></li>
                    <li><a href="#"><?php echo __("backend/admins.edit"); ?></a></li>
                </ol>

            </div>
        </div>
        <h2><?php echo __("backend/admins.manage_admins"); ?></h2>
        <form action="{pathadmin}admins/list/doedit/<?php echo $key_admin; ?>" method="POST">
            <table class="table">
                <tr>
                    <td><?php echo __("backend/admins.login"); ?></td>
                    <td><input type="text" value="<?php echo $admin['login']; ?>" name="login" required  class="form-control" required></td>
                </tr>
                <tr>
                    <td><?php echo __("backend/admins.password"); ?> </td>
                    <td><input type="text" value="" name="password"     class="form-control" ></td>
                </tr>

                <?php
                if (count($access)) {
                    foreach ($access as $acc) {
                        $checked = "";
                        if (in_array($acc['name'], $admin['access'])) {
                            $checked = "checked";
                        }
                        ?>
                        <tr>
                            <td><?php echo $acc['title']; ?></td>
                            <td><input <?php echo $checked; ?> type="checkbox" name="access[]" value="<?php echo $acc['name']; ?>"></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td><button type="submit" class="btn btn-primary"><?php echo __("backend/admins.editing"); ?></button></td>
                        <?php echo csrf_field(); ?>
                </tr>
            </table>
        </form>
    </div>
    <!-- END Example Title -->

    <!-- Example Content -->


</div>
