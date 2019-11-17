<?php

namespace share\templates;

use DG\Twitter\Twitter;

class twitterShareModel {

    static function update($row, $key) {
        return null;
    }

    static function publish($template, $text, $images, $link) {
        $row = $template;
        if (isset($row['params']['consumerkey']) and isset($row['params']['consumersecret'])
                and isset($row['params']['token']) and isset($row['params']['tokensecret'])
        ) {
            $text = strip_tags($text);
            $consumerKey = $template['params']['consumerkey'];
            $consumerSecret = $template['params']['consumersecret'];
            $accessToken = $template['params']['token'];
            $accessTokenSecret = $template['params']['tokensecret'];


            $twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
            $result = $twitter->send($text);

            var_dump($result);
            exit;
        }
    }

    static function isEnable($row, $key) {
        if (isset($row['params']['consumerkey']) and isset($row['params']['consumersecret'])
                and isset($row['params']['token']) and isset($row['params']['tokensecret'])
        ) {
            return true;
        } else {
            return false;
        }
    }

}
