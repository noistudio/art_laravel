<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo __("backend/admins.rule_title"); ?></h2>

        <div class="alert alert-info">
            <?php echo __("backend/admins.rule_alert"); ?>
        </div>
        <form action="{pathadmin}admins/rules/add" method="POST">
            <table class="table">
                <tr>
                    <td><?php echo __("backend/admins.title_rule"); ?></td>
                    <td><input type="text" name="title" required  class="form-control" required></td>
                </tr>
                <tr>
                    <td><?php echo __("backend/admins.name_rule"); ?> </td>
                    <td><input type="text" name="name" required   class="form-control" required></td>
                </tr>
                <tr><td><?php echo __("backend/admins.accessing_links"); ?></td>
                    <td><input type="text" name="links" class="form-control" required ></td>
                </tr>
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

                <th><?php echo __("backend/admins.title_rule"); ?></th>
                <th><?php echo __("backend/admins.name_rule"); ?></th>
                <th><?php echo __("backend/admins.links"); ?></th>

                <th></th>


            </tr>
        </thead>
        <tbody>
            <?php
            if (count($rules)) {
                foreach ($rules as $key => $row) {
                    ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo implode("<br>", $row['links']); ?></td>
                        <td>
                            <?php
                            if (isset($row['id'])) {
                                ?>
                                <a class="btn btn-primary" href="{pathadmin}admins/rules/delete/<?= $row['id']; ?>"><i class="fa fa-remove"></i></a>
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
