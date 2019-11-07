<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo __("backend/mailer.text"); ?></h2>

    </div>


    <!-- END Example Title -->

    <form action="{pathadmin}mailer/test/send" method="POST">
        <table class="table">


            <tr>
                <td><?php echo __("backend/mailer.to"); ?></td>
                <td><input type="email" name='to' class="form-control" value="" required></td>
            </tr>

            <tr>
                <td><?php echo __("backend/mailer.subject"); ?></td>
                <td><input type="text" name='subject' class="form-control" value="" required></td>
            </tr>
            <tr>
                <td><?php echo __("backend/mailer.message"); ?></td>
                <td><textarea   name='content' class="form-control" required></textarea></td>
            </tr>
            <tr>
                <td>
                    <?php
                    echo csrf_field();
                    ?>

                </td>
                <td>
                    <button type="submit" class="btn btn-submit"><?php echo __("backend/mailer.dosend"); ?></button>
                </td>
            </tr>
        </table>
    </form>

</div>
