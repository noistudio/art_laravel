<?php

namespace share\templates;

use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use \VK\OAuth\Scopes\VKOAuthUserScope;
use \VK\OAuth\VKOAuthResponseType;

class fbShareModel {

    static function update($row, $key) {
        return null;
    }

    static function publish($template, $text, $images, $link) {
        $text = strip_tags($text);

        $fb = new \Facebook\Facebook([
            'app_id' => $template['params']['app_id'],
            'app_secret' => $template['params']['app_secret'],
            'default_graph_version' => 'v2.10',
        ]);



        $linkData = [
            'link' => $link,
            'message' => $text,
        ];
        if (count($images) > 0) {
            $linkData['images'] = $images[0];
        }


        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->post('/' . $template['params']['group_id'] . '/feed', $linkData, $template['params']['token']);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // echo 'Graph returned an error: ' . $e->getMessage();
            // exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            //echo 'Facebook SDK returned an error: ' . $e->getMessage();
            // exit;
        }
    }

    static function isEnable($row, $key) {
        if (isset($row['params']['token'])) {
            return true;
        } else {
            return false;
        }
    }

}
