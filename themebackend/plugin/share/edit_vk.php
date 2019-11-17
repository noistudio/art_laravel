<tr>
    <td>client_id</td>   
    <td><input type="text" name="params[client_id]" value="<?php
        if (isset($params['client_id'])) {
            echo $params['client_id'];
        }
        ?>" class="form-control"></td>
</tr>
<tr>
    <td>secret_key</td>   
    <td><input type="text" name="params[secret_key]" value="<?php
        if (isset($params['secret_key'])) {
            echo $params['secret_key'];
        }
        ?>" class="form-control"></td>
</tr>
<tr>
    <td><?php echo __("backend/share.vk_group_id"); ?></td>   
    <td><input type="number" name="params[group_id]" value="<?php
        if (isset($params['group_id'])) {
            echo $params['group_id'];
        }
        ?>" class="form-control"></td>
</tr>


<?php
if (isset($params['group_id']) and isset($params['secret_key']) and isset($params['client_id'])) {
    $url = 'https://api.vk.com/oauth/authorize?client_id=' . $params['client_id'] . '&scope=offline,wall,groups,photos&redirect_uri=https://vk.com&response_type=code';
    ?>
    <tr>
        <td><?php echo __("backend/share.vk_token_d"); ?></td>
        <td></td>
    </tr>
    <tr>
        <td><?php echo __("backend/share.step1"); ?></td>
        <td><?php echo __("backend/share.vk_step1"); ?></td>
    </tr>
    <tr>
        <td></td>
        <td><a href="<?php echo $url; ?>" target="_blank"><?php echo $url; ?></a></td>
    </tr>
    <tr>
        <td><?php echo __("backend/share.step2"); ?></td>
        <td><?php echo __("backend/share.vk_step2"); ?></td>
    </tr>
    <tr>
        <td colspan="2">
            <textarea style="width:100%" class="form-control">https://oauth.vk.com/access_token?client_id=<?php echo $params['client_id']; ?>&client_secret=<?php echo $params['secret_key']; ?>&redirect_uri=https://vk.com&code={code}</textarea>
        </td>
    </tr>
    <tr>
        <td><?php echo __("backend/share.step3"); ?></td>
        <td><?php echo __("backend/share.vk_step3"); ?></td>
    </tr>

    <tr>
        <td><?php echo __("backend/share.vk_forever_t"); ?></td>
        <td><input type="text" name="params[token]" value="<?php
            if (isset($params['token'])) {
                echo $params['token'];
            }
            ?>" class="form-control"></td>
    </tr>

    <?php
}
?>


