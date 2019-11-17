<?php

namespace share\templates;

use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use \VK\OAuth\Scopes\VKOAuthUserScope;
use \VK\OAuth\VKOAuthResponseType;

class telegramShareModel {

    static function update($row, $key) {
        return null;
    }

    static function setHook($template, $id) {
        $bot_api_key = $template['params']['api_key'];
        $bot_username = $template['params']['username'];
        $hook_url = 'https://' . $_SERVER['HTTP_HOST'] . "/share/telegram/" . $id;

        $api_url = 'https://api.telegram.org/bot' . $bot_api_key . '/setWebhook?url=' . $hook_url;

        echo file_get_contents($api_url);
    }

    static function startBot($template, $id) {
        $bot_api_key = $template['params']['api_key'];
        $bot_username = $template['params']['username'];
        $hook_url = 'https://' . $_SERVER['HTTP_HOST'] . "/share/telegram/" . $id;
        try {
            $bot = new \TelegramBot\Api\Client($bot_api_key);
            // or initialize with botan.io tracker api key
            // $bot = new \TelegramBot\Api\Client('YOUR_BOT_API_TOKEN', 'YOUR_BOTAN_TRACKER_API_KEY');


            $bot->command('start', function ($message) use ($bot) {
                $bot->sendMessage($message->getChat()->getId(), 'pong!');
            });

            $bot->run();
        } catch (\TelegramBot\Api\Exception $e) {
            $e->getMessage();
        }
    }

    static function publish($template, $text, $images, $link) {
        $text = str_replace("<p>", "", $text);
        $text = str_replace("</p>", "\n", $text);
        $text = strip_tags($text, "<b><a><strong><i><em><code><pre>");
        $text = str_replace("&nbsp", "", $text);

        $bot = new \TelegramBot\Api\BotApi($template['params']['api_key']);
        $channels = explode(",", $template['params']['channel']);
        if (count($channels)) {
            foreach ($channels as $channel) {
                $bot->sendMessage($channel, $text);
                if (count($images)) {
                    foreach ($images as $img) {
                        $bot->sendPhoto($channel, $img);
                    }
                }
            }
        }
    }

    static function isEnable($row, $key) {
        if (isset($row['params']['api_key'])) {
            return true;
        } else {
            return false;
        }
    }

}
