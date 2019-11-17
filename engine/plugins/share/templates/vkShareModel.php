<?php

namespace share\templates;

use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use \VK\OAuth\Scopes\VKOAuthUserScope;
use \VK\OAuth\VKOAuthResponseType;

class vkShareModel {

    static function update($row, $key) {

        $oauth = new VKOAuth();

        $client_id = (int) $row['params']['client_id'];
        $client_secret = $row['params']['secret_key'];

        $redirect_uri = route('backend/share/fastupdate', $key);

        $code = request()->get('code');

        $token = $oauth->getAccessToken($client_id, $client_secret, $redirect_uri, $code);

        if (is_string($token)) {
            return array('token' => $token);
        } else {
            return null;
        }
    }

    static function publish($template, $text, $images, $link) {

        $images_result = array();
        $vk = new \VK\Client\VKApiClient();
        $request = new \VK\Client\VKApiRequest("5.73", null, "https://api.vk.com/method");
        if (is_array($images) and count($images)) {
            foreach ($images as $img) {

                $file = parse_url($img, PHP_URL_PATH);

                $address = $vk->photos()->getWallUploadServer($template['params']['token'], array('group_id' => (int) $template['params']['group_id']));
                if (isset($address['upload_url'])) {
                    $photo = $request->upload($address['upload_url'], 'photo', public_path($file));
                    if (isset($photo['server']) and isset($photo['photo']) and isset($photo['hash'])) {
                        $response_save_photo = $vk->photos()->saveWallPhoto($template['params']['token'], array(
                            'group_id' => $template['params']['group_id'],
                            'server' => $photo['server'],
                            'photo' => $photo['photo'],
                            'hash' => $photo['hash'],
                        ));
                        if (isset($response_save_photo[0]) and isset($response_save_photo[0]['id'])) {
                            $newid = "photo" . $response_save_photo[0]['owner_id'] . "_" . $response_save_photo[0]['id'];
                            $images_result[] = $newid;
                        }
                    }
                }
            }
        }
        $text = strip_tags($text);



        $params['owner_id'] = "-" . $template['params']['group_id'];
        $params['from_group'] = 1;
        $params['friends_only'] = 0;

        $params['message'] = $text;
        $params['attachments'] = $images_result;


        $vk->wall()->post($template['params']['token'], $params);
    }

    static function isEnable($row, $key) {
        if (isset($row['params']['token'])) {
            return true;
        } else {
            return false;
        }
    }

    static function getLink($row, $key) {


        $oauth = new VKOAuth();
        $client_id = (int) $row['params']['client_id'];

        $redirect_uri = route('backend/share/fastupdate', $key);
        $display = VKOAuthDisplay::PAGE;
        $scope = array(VKOAuthUserScope::WALL, VKOAuthUserScope::PHOTOS, VKOAuthUserScope::GROUPS, VKOAuthUserScope::OFFLINE);
        $state = 'secret_state_code';
        $groups_ids = array($row['params']['group_id'],);

        $browser_url = $oauth->getAuthorizeUrl(VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state);
        return $browser_url;
    }

}
