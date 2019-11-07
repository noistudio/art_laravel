<?php

namespace logs\models;

class LogsConfig {

    static function get() {

        $path_to_logs = realpath(__DIR__ . "/../../../db_json/logs.data.json");

        $rows = json_decode(file_get_contents($path_to_logs), true);

        $channels = array();
        if (isset($rows) and is_array($rows) and count($rows) > 0) {
            foreach ($rows as $key => $log) {
                $log['params'] = json_decode($log['params'], true);
                if (isset($log['status']) and $log['status'] == "enable") {
                    if ($log['channel'] == "single") {
                        $channels['single'] = [
                            'driver' => 'single',
                            'path' => storage_path('logs/' . $log['params']['file_name']),
                            'level' => $log['level'],
                        ];
                    } else if ($log['channel'] == "slack") {
                        $channels['slack'] = [
                            'driver' => 'slack',
                            'url' => $log['params']['url'],
                            'username' => $log['params']['username'],
                            'emoji' => $log['params']['emoji'],
                            'level' => $log['params']['level'],
                        ];
                    } else if ($log['channel'] == "stack") {
                        $channels['stack'] = [
                            'driver' => 'stack',
                            'channels' => $log['params']['channels'],
                        ];
                    }
                }
            }
        }

        return $channels;
    }

}
