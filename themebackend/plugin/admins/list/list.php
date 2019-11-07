<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo __("backend/admins.manage_admins"); ?></h2>
        <form action="{pathadmin}admins/list/add" method="POST">
            <table class="table">
                <tr>
                    <td><?php echo __("backend/admins.login"); ?></td>
                    <td><input type="text" name="login" required  class="form-control" required></td>
                </tr>
                <tr>
                    <td><?php echo __("backend/admins.password"); ?> </td>
                    <td><input type="text" name="password" required   class="form-control" required></td>
                </tr>

            </table> 
            <div class="row  " style="width:97%;padding:12px; height:200px !important;overflow-y: scroll;">
                <table class="table"    >
                    <?php
                    if (count($access)) {
                        foreach ($access as $acc) {
                            ?>
                            <tr>
                                <td><?php echo $acc['title']; ?></td>
                                <td><input type="checkbox" name="access[]" value="<?php echo $acc['name']; ?>"></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>    
                </table>  
            </div>
            <table class="table">
                <tr>
                    <td><button type="submit" class="btn btn-primary"><?php echo __("backend/admins.add"); ?></button></td>
                    <?php echo csrf_field(); ?>
                </tr>
            </table>
        </form>
    </div>
    <!-- END Example Title -->

    <!-- Example Content -->
    <table class="table">
        <thead>
            <tr>

                <th><?php echo __("backend/admins.login"); ?></th>


                <th><?php echo __("backend/admins.accessing"); ?></th>
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
                        <td><?php echo $row['login']; ?></td>

                        <td><?php echo implode(",", $row['access']); ?></td>
                        <td><a class="btn btn-primary" href="{pathadmin}admins/list/edit/<?= $key; ?>"><i class="fa fa-pencil"></i></a></td>
                        <td>

                            <a class="deleteerror btn btn-primary" data-msg="<?php echo __("backend/admins.want_delete"); ?>" href="{pathadmin}admins/list/delete/<?= $key; ?>"><i class="fa fa-remove"></i></a>

                        </td>

                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>

</div>
