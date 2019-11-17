<tr>
    <td>appkey</td>   
    <td><input type="text" name="params[appkey]" value="<?php
        if (isset($params['apikey'])) {
            echo $params['apikey'];
        }
        ?>" class="form-control"></td>
</tr>
<tr>
    <td>appsecret</td>   
    <td><input type="text" name="params[appsecret]" value="<?php
        if (isset($params['appsecret'])) {
            echo $params['appsecret'];
        }
        ?>" class="form-control"></td>
</tr>
<?php
if (isset($params['appkey']) and isset($params['appsecret'])) {
    ?>
    <tr>
        <td></td>
        <td><a href="<?php echo share\templates\instagramShareModel::getLink($row, $key); ?>">Авторизоваться в instagram</a> </td>
    </tr>
    <?php
}
?>
