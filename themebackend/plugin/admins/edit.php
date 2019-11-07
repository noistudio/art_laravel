<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo __("backend/admins.edit_password"); ?></h2>
        <form action="{pathadmin}admins/doedit" method="POST">
            <table class="table">

                <tr>
                    <td><?php echo __("backend/admins.new_password"); ?> </td>
                    <td><input type="password" value="" name="edit_password"     class="form-control" required ></td>
                </tr>
                <tr>
                    <td><?php echo __("backend/admins.new_password"); ?> </td>
                    <td><input type="password" value="" name="edit_password_2"     class="form-control" required  ></td>
                </tr>
                <tr>
                    <td><button type="submit" class="btn btn-primary"><?php echo __("backend/admins.change_password"); ?></button></td>
                        <?php echo csrf_field(); ?>
                </tr>
            </table>
        </form>
    </div></div>
