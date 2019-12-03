<?php

namespace managers\backend\controllers;

class BackupBackend extends \managers\backend\AdminController {

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    function __construct($is_plugin = false) {
        parent::__construct($is_plugin);
    }

    public function actionIndex() {


        $disk = \Storage::disk(config('backup.backup.destination.disks')[0]);
        $files = $disk->files(config('backup.backup.name'));

        $backups = [];
        // make an array of backup files, with their filesize and creation date
        foreach ($files as $k => $f) {
            // only take the zip files into account
            if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                $backups[] = [
                    'file_path' => $f,
                    'file_name' => str_replace(config('backup.backup.name') . '/', '', $f),
                    'file_size' => $disk->size($f) / 1000000,
                    'last_modified' => $disk->lastModified($f),
                ];
            }
        }
        // reverse the backups, so the newest one would be on top
        $backups = array_reverse($backups);

        $data['backups'] = $backups;


        return $this->render("list_backups", $data);
    }

    public function actionCreateonlyDB() {
        try {
            // start the backup process
            \Artisan::call('backup:run --only-db');
            $output = \Artisan::output();
            // log the results
            \Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n" . $output);
            // return the results as a response to the ajax call

            return redirect()->back();
        } catch (Exception $e) {
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function actionCreate() {

        try {
            // start the backup process
            \Artisan::call('backup:run');
            $output = \Artisan::output();
            // log the results
            \Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n" . $output);
            // return the results as a response to the ajax call

            return redirect()->back();
        } catch (Exception $e) {
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function actionDelete($file_name) {
        $disk = \Storage::disk(config('backup.backup.destination.disks')[0]);
        if ($disk->exists(config('backup.backup.name') . '/' . $file_name)) {
            $disk->delete(config('backup.backup.name') . '/' . $file_name);
            return redirect()->back();
        } else {
            abort(404, "The backup file doesn't exist.");
        }
    }

    public function actionDownload($file_name) {

        $file = config('backup.backup.name') . '/' . $file_name;
        $disk = \Storage::disk(config('backup.backup.destination.disks')[0]);

        if ($disk->exists($file)) {
            $fs = \Storage::disk(config('backup.backup.destination.disks')[0])->getDriver();
            $stream = $fs->readStream($file);
            return \Response::stream(function () use ($stream) {
                        fpassthru($stream);
                    }, 200, [
                        "Content-Type" => $fs->getMimetype($file),
                        "Content-Length" => $fs->getSize($file),
                        "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
            ]);
        } else {
            abort(404, "The backup file doesn't exist.");
        }
    }

}
