<tr>
    <td>app_id</td>   
    <td><input type="text" name="params[app_id]" value="<?php
        if (isset($params['app_id'])) {
            echo $params['app_id'];
        }
        ?>" class="form-control"></td>
</tr>
<tr>
    <td>app_secret</td>   
    <td><input type="text" name="params[app_secret]" value="<?php
        if (isset($params['app_secret'])) {
            echo $params['app_secret'];
        }
        ?>" class="form-control"></td>
</tr>
<tr>
    <td><?php echo __("backend/share.fb_group_id"); ?></td>   
    <td><input type="text" name="params[group_id]" value="<?php
        if (isset($params['group_id'])) {
            echo $params['group_id'];
        }
        ?>" class="form-control"></td>
</tr>

<tr>
    <td>access_token <a href="http://snipp.ru/view/7" target="_blank"><i class="fa fa-question-circle"></i></a></td>   
    <td><input type="text" name="params[token]" value="<?php
        if (isset($params['token'])) {
            echo $params['token'];
        }
        ?>" class="form-control"></td>
</tr>

