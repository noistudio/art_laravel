<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">

            </div>
        </div>
        <h2>                <a href="{pathadmin}cache/clear" class="btn btn-warning"><?php echo __("backend/cache.clear_all_cache"); ?></a>
            <?php echo __("backend/cache.setup_cache"); ?></h2>

    </div>
    <!-- END Example Title -->

    <form action="{pathadmin}cache/save" method="POST">
        <table class="table">
            <tr>
                <td><?php echo __("backend/cache.status"); ?></td>
                <td>
                    <select class="form-control" name="status" required>
                        <option <?php
                        if (isset($config['status']) and $config['status'] == "0") {
                            echo 'selected';
                        }
                        ?> value="disable"><?php echo __("backend/cache.disable"); ?></option>
                        <option  <?php
                        if (isset($config['status']) and $config['status'] == "1") {
                            echo 'selected';
                        }
                        ?>  value="enable"><?php echo __("backend/cache.enable"); ?></option>
                    </select></td>
            </tr>

            <tr>
                <td>
                    <?php
                    echo csrf_field();
                    ?>

                </td>
                <td>
                    <button type="submit" class="btn btn-submit"><?php echo __("backend/cache.save"); ?></button>
                </td>
            </tr>
        </table>
    </form>

</div>
