<?php

namespace managers\backend\models;

class AdminPwa {

    static function generate($render = true) {
        $basicManifest = [
            'name' => config('laravelpwa_admin.manifest.name'),
            'short_name' => config('laravelpwa_admin.manifest.short_name'),
            'start_url' => asset(config('laravelpwa_admin.manifest.start_url')),
            'display' => config('laravelpwa_admin.manifest.display'),
            'theme_color' => config('laravelpwa_admin.manifest.theme_color'),
            'background_color' => config('laravelpwa_admin.manifest.background_color'),
            'orientation' => config('laravelpwa_admin.manifest.orientation'),
            'splash' => config('laravelpwa_admin.manifest.splash')
        ];

        foreach (config('laravelpwa_admin.manifest.icons') as $size => $file) {
            $fileInfo = pathinfo($file);
            $basicManifest['icons'][] = [
                'src' => $file,
                'type' => 'image/' . $fileInfo['extension'],
                'sizes' => $size
            ];
        }

        foreach (config('laravelpwa_admin.manifest.custom') as $tag => $value) {
            $basicManifest[$tag] = $value;
        }
        if ($render == true) {
            return \View::make('laravelpwa::meta', ['config' => $basicManifest])->render();
        }
        return $basicManifest;
    }

}
