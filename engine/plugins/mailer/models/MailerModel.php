<?php

namespace mailer\models;

use db\SqlDocument;
use core\Notify;

class MailerModel {

    public static function save() {
        $post = request()->post();
        $type_available = array('smtp', 'sendmail');
        $run_type_available = array('standart', 'cron');
        $encryption_available = array('ssl', 'tls', 'null');
        if (!(isset($post['encryption']) and is_string($post['encryption']) and in_array($post['encryption'], $encryption_available))) {
            Notify::add(__("backend/mailer.err4"));
            return false;
        }

        if (!(isset($post['type']) and is_string($post['type']) and in_array($post['type'], $type_available))) {
            Notify::add(__("backend/mailer.err9"));
            return false;
        }



        if (!(isset($post['host']) and is_string($post['host']) and strlen($post['host']) > 0)) {
            Notify::add(__("backend/mailer.err5"));
            return false;
        }
        if (!(isset($post['port']) and is_numeric($post['port']) and (int) $post['port'] > 0)) {
            Notify::add(__("backend/mailer.err6"));
            return false;
        }
        if (!(isset($post['email']) and is_string($post['email']) and filter_var($post['email'], FILTER_VALIDATE_EMAIL))) {
            Notify::add(__("backend/mailer.err7"));
            return false;
        }
        if (!(isset($post['password']) and is_string($post['password']) and strlen($post['password']) > 0)) {
            Notify::add(__("backend/mailer.err8"));
            return false;
        }



        $array = array();
        $array['MAIL_DRIVER'] = $post['type'];

        $array['MAIL_HOST'] = strip_tags($post['host']);
        $array['MAIL_PORT'] = (int) $post['port'];
        $array['MAIL_USERNAME'] = strtolower($post['email']);
        $array['MAIL_PASSWORD'] = $post['password'];
        $array['MAIL_ENCRYPTION'] = $post['encryption'];

        \core\AppEnv::save($array);
        \core\Notify::add(__("backend/mailer.save_success"));
        return true;
    }

}
