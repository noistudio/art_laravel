<?php

namespace share\models;

class VkPostWall {

    static function post($template, $text, $images, $link) {

        $token = $template['params']['token'];
        $group_id = $template['params']['group_id'];

        $v = '5.62'; //версия vk api
        $attachs = "";
        if (count($images)) {
            $attachs = implode(",", $images);
        }
        $query = file_get_contents("https://api.vk.com/method/wall.post?v=" . $v . "&owner_id=-" . $group_id . "&from_group=1&attachments=" . $attachs . "&message=" . urlencode($text) . "&access_token=" . $token);

        echo $query;
        exit;
    }

}
