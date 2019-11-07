<?php

namespace mailer\controllers\cron;

use mailer\models\SmtpModel;
use plugsystem\models\NotifyModel;

class Mailer extends \plugsystem\core\FrontendController
{
    public function actionIndex($id_message)
    {
        // $config=MongoDocument::get("phpmailer_config", 0);
        // $email=MongoQuery::get("need_to_send_messages", array('last_id'=>(int)$id_message));
        // if (is_array($email)) {
        //     if (isset($config['type']) and $config['type']=="sendmail") {
        //         mail($email['to'], $email['subject'], $email['message']);
        //     } elseif (isset($config['type']) and  $config['type']=="smtp") {
        //         $smtp=new SmtpModel;
        //         $smtp->send($email['to'], $email['subject'], $email['message']);
        //     }
        //     MongoQuery::delete("need_to_send_messages", array('last_id'=>(int)$id_message));
        // }
    }
}
