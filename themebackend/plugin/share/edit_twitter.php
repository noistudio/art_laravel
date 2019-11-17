<tr>
    <td>consumerkey</td>   
    <td><input type="text" name="params[consumerkey]" value="<?php
        if (isset($params['consumerkey'])) {
            echo $params['consumerkey'];
        }
        ?>" class="form-control"></td>
</tr>
<tr>
    <td>consumersecret</td>   
    <td><input type="text" name="params[consumersecret]" value="<?php
        if (isset($params['consumersecret'])) {
            echo $params['consumersecret'];
        }
        ?>" class="form-control"></td>
</tr>
<tr>
    <td>accessToken</td>   
    <td><input type="text" name="params[token]" value="<?php
        if (isset($params['token'])) {
            echo $params['token'];
        }
        ?>" class="form-control"></td>
</tr>
<tr>
    <td>accessTokenSecret</td>   
    <td><input type="text" name="params[tokensecret]" value="<?php
        if (isset($params['tokensecret'])) {
            echo $params['tokensecret'];
        }
        ?>" class="form-control"></td>
</tr>
