<?php

namespace mailer\models;

use db\SqlDocument;

class Tomail {

    public static function send($to, $subject, $message) {

//        if ($_SERVER['REMOTE_ADDR'] == "::1") {
//            return true;
//        }

        $config = \core\AppEnv::all();


        if (filter_var($to, FILTER_VALIDATE_EMAIL) and is_string($subject) and is_string($message)) {
            if (isset($config['MAIL_DRIVER']) and $config['MAIL_DRIVER'] == "sendmail") {
//$headers = 'MIME-Version: 1.0' . "\r\n";
//$headers .= 'subject:'.$subject. "\r\n";
//$headers .= 'From: email@site.ru'. "\r\n";
//$headers .= "Content-Type: multipart/alternative;boundary=txTEXTtx\r\n";
//return mail($to, "=?utf-8?B?".base64_encode($subject)."?=", $message,$headers);
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

// Дополнительные заголовки
                $headers .= 'To: ' . $to . "\r\n";
                $headers .= 'From: ' . $config['MAIL_USERNAME'];


// Отправляем
                return mail($to, $subject, $message, $headers);
            } else {


                $from = $config['MAIL_USERNAME'];
                $result = \Mail::send(array(), array(), function ($message_obj) use ($subject, $message, $to, $from) {

                            $message_obj->to($to);
                            $message_obj->subject($subject);
                            $message_obj->from($from);
                            $message_obj->setBody($message, 'text/html');
                        });
            }
        }
    }

}
