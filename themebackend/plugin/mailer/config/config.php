<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo __("backend/mailer.send_title"); ?></h2>

    </div>


    <!-- END Example Title -->

    <form action="{pathadmin}mailer/config/save" method="POST">
        <table class="table">
            <tr>
                <td><?php echo __("backend/mailer.type"); ?></td>
                <td>
                    <select class="form-control" name="type" required>
                        <option <?php
                        if (isset($config['MAIL_DRIVER']) and $config['MAIL_DRIVER'] == "sendmail") {
                            echo 'selected';
                        }
                        ?> value="sendmail">sendmail</option>
                        <option  <?php
                        if (isset($config['MAIL_DRIVER']) and $config['MAIL_DRIVER'] == "smtp") {
                            echo 'selected';
                        }
                        ?>  value="smtp">smtp</option>
                    </select></td>
            </tr>
            <tr>
                <td><?php echo __("backend/mailer.host"); ?></td>
                <td>
                    <input type="text" class="form-control" value="<?php
                    if (isset($config['MAIL_HOST'])) {
                        echo $config['MAIL_HOST'];
                    }
                    ?>" name="host" required>
                </td>
            </tr>
            <tr>
                <td><?php echo __("backend/mailer.enc"); ?></td>
                <td>
                    <select class="form-control" required name="encryption">
                        <option value="null"><?php echo __("backend/mailer.enc_null"); ?></option>
                        <option <?php
                        if (isset($config['MAIL_ENCRYPTION']) and $config['MAIL_ENCRYPTION'] == "ssl") {
                            echo 'selected';
                        }
                        ?> value="ssl">ssl</option>
                        <option <?php
                        if (isset($config['MAIL_ENCRYPTION']) and $config['MAIL_ENCRYPTION'] == "tls") {
                            echo 'selected';
                        }
                        ?> value="tls">tls</option>
                    </select></td>
            </tr>
            <tr>
                <td><?php echo __("backend/mailer.port"); ?></td>
                <td><input type="number" name="port" class="form-control"  value="<?php
                    if (isset($config['MAIL_PORT'])) {
                        echo $config['MAIL_PORT'];
                    }
                    ?>" required></td>
            </tr>
            <tr>
                <td><?php echo __("backend/mailer.email"); ?></td>
                <td><input type="email" name='email' class="form-control" value="<?php
                    if (isset($config['MAIL_USERNAME'])) {
                        echo $config['MAIL_USERNAME'];
                    }
                    ?>" required></td>
            </tr>
            <tr>
                <td><?php echo __("backend/mailer.password"); ?></td>
                <td><input type="text" name='password' value="<?php
                    if (isset($config['MAIL_PASSWORD'])) {
                        echo $config['MAIL_PASSWORD'];
                    }
                    ?>" class="form-control" required></td>
            </tr>

            <tr>
                <td>
                    <?php
                    echo csrf_field();
                    ?>

                </td>
                <td>
                    <button type="submit" class="btn btn-submit"><?php echo __("backend/mailer.save"); ?></button>
                </td>
            </tr>
        </table>
    </form>

</div>
