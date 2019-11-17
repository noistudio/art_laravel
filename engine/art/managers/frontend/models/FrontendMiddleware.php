<?php

namespace managers\frontend\models;

use Closure;

class FrontendMiddleware {

    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        \languages\models\LanguageHelp::get();


        $current_url = url()->current();
        $current_url = \core\Helper::path($current_url);

        $info_url = \routes\models\RoutesModel::getInfoBy($current_url);



        if (isset($info_url)) {
            if ($info_url->old_url != $info_url->new_url) {

                if ($current_url == $info_url->old_url) {

                    return redirect($info_url->new_url, 302);
                }
            }

            $canonical_url = \URL::to($info_url->new_url);
            \SEOMeta::setTitle($info_url->title);

            \SEOMeta::setDescription($info_url->meta_description);
            \SEOMeta::setKeywords($info_url->meta_keywords);

            \SEOMeta::setCanonical($canonical_url);
        }

//        if ($request->input('age') < 200) {
//            return redirect('home');
//        }

        return $next($request);
    }

}
