<tr>
    <td>api key</td>   
    <td><input type="text" name="params[api_key]" value="<?php
        if (isset($params['api_key'])) {
            echo $params['api_key'];
        }
        ?>" class="form-control"></td>
</tr>
<tr>
    <td>bot username</td>   
    <td><input type="text" name="params[username]" value="<?php
        if (isset($params['username'])) {
            echo $params['username'];
        }
        ?>" class="form-control"></td>
</tr>
<tr>
    <td><?php echo __("backend/share.tg_channel"); ?></td>   
    <td><input type="text" name="params[channel]" value="<?php
        if (isset($params['channel'])) {
            echo $params['channel'];
        }
        ?>" class="form-control"></td>
</tr>
<?php
if (isset($params['channel']) and isset($params['username']) and isset($params['api_key'])) {
    ?>
    <tr>
        <td><?php echo __("backend/share.step1"); ?></td>
        <td><a href="/share/telegram/hook/<?php echo $key; ?>" target="_blank"><?php echo __("backend/share.tg_link_auth"); ?></a></td>
    </tr>

    <?php
}
?>



