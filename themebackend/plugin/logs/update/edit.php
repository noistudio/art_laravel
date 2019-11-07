<ol class="breadcrumb">

    <li><a href="{pathadmin}logs"><?php echo __("backend/logs.logs"); ?></a></li>
    <li class="active"><?php echo __("backend/logs.log", array('id' => $log->id)); ?></li>
</ol>
<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo __("backend/logs.log", array('id' => $log->id)); ?></h2>

    </div>
    <!-- END Example Title -->
    <form action="{pathadmin}logs/update/ajaxedit/<?php echo $log->id; ?>" class="ajaxsend" method="POST">
        <!-- Example Content -->


        <table class="table">
            <tr>
                <td><?php echo __("backend/logs.status"); ?></td>
                <td><input   type="checkbox" <?php
                    if ($log->status == "enable") {
                        echo 'checked';
                    }
                    ?> name="status" value="1" class="form-control" ></td>
            </tr>
            <tr>
                <td><?php echo __("backend/logs.chanel"); ?></td>
                <td><select class='form-control  typelog' name='channel'>
                        <option value="null"></option>
                        <?php
                        if (count($channels)) {
                            foreach ($channels as $channel) {
                                $selected = "";
                                if ($log->channel == $channel) {
                                    $selected = "selected";
                                }
                                ?>
                                <option <?php echo $selected; ?> value="<?php echo $channel; ?>"><?php echo $channel; ?></option>
                                <?php
                            }
                        }
                        ?>


                    </select></td>
            </tr>

            <tr>
                <td><?php echo __("backend/logs.level"); ?></td>
                <td><select class='form-control  '  required name='level'>
                        <?php
                        if (count($levels)) {
                            foreach ($levels as $level) {
                                $selected = "";
                                if ($log->level == $level) {
                                    $selected = "selected";
                                }
                                ?>
                                <option <?php echo $selected; ?> value="<?php echo $level; ?>"><?php echo $level; ?></option>
                                <?php
                            }
                        }
                        ?>


                    </select></td>
            </tr>

            <tr style="display:none" class="type_stack">

                <td><?php echo __("backend/logs.choose_channels"); ?></td>
                <td><select class='form-control'  multiple  name='params[channels][]'>
                        <?php
                        if (count($channels)) {
                            foreach ($channels as $channel) {
                                $selected = "";
                                if ($channel != "stack") {
                                    if (isset($log->params['channels']) and is_array($log->params['channels']) and in_array($channel, $log->params['channels'])) {
                                        $selected = "selected";
                                    }
                                    ?>
                                    <option value='<?php echo $channel; ?>'><?php echo $channel; ?></option>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </select></td>
            </tr> 

            <tr style="display:none" class="all_types type_single">

                <td><?php echo __("backend/logs.file"); ?></td>
                <td><input type='text' name='params[file_name]' value='<?php
                    if (isset($log->params['file_name'])) {
                        echo $log->params['file_name'];
                    }
                    ?>' class='form-control'></td>
            </tr> 

            <tr style="display:none" class="all_types type_slack">

                <td>Webhook URL</td>
                <td><input type='text' name='params[url]' value='<?php
                    if (isset($log->params['url'])) {
                        echo $log->params['url'];
                    }
                    ?>' class='form-control'></td>
            </tr> 
            <tr style="display:none" class="all_types type_slack">

                <td>username</td>
                <td><input type='text' name='params[username]' value='<?php
                    if (isset($log->params['username'])) {
                        echo $log->params['username'];
                    }
                    ?>' class='form-control'></td>
            </tr> 
            <tr style="display:none" class="all_types type_slack">

                <td>emoji например :boom:</td>
                <td><input type='text' name='params[emoji]' value='<?php
                    if (isset($log->params['emoji'])) {
                        echo $log->params['emoji'];
                    }
                    ?>' class='form-control'></td>
            </tr> 


        </table>

        <table class="table">
            <tr>
                <td><?php echo csrf_field(); ?></td>
                <td><button type="submit"   value="" class="btn btn-primary" ><?php echo __("backend/logs.edit_btn"); ?></button></td>
            </tr>
        </table>
    </form>
</div>
