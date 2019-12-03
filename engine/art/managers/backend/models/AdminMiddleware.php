<?php

namespace managers\backend\models;

use Closure;

class AdminMiddleware {

    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        \languages\models\LanguageHelp::get();

        $manager = \core\ManagerConf::current();


        $current_url = \admins\models\AdminModel::getQueryString();

        if ($manager == "backend") {


            $result = \admins\models\AdminAuth::isLogin();




            if (!$result) {
                return \core\ManagerConf::redirect("login");
            }

            if (!\admins\models\AdminAuth::isRoot()) {

                $availables_path = array('/index', '/admin', '/admins/edit', '/logout', '/admins/doedit');
                $info = \admins\models\AdminAuth::getMy();

                if (!(isset($info['access'])) and is_array(isset($info['access'])) and count(isset($info['access'])) > 0) {
                    if (!in_array($current_url, $availables_path)) {
                        \core\Notify::add("У вас нет доступа!");
                        return \core\ManagerConf::redirect("index");
                    }
                }
                $all_rules = AdminRules::getAll();
                $my_rules = $info['access'];
                foreach ($info['access'] as $access) {
                    if (isset($all_rules[$access])) {
                        $rule = $all_rules[$access];
                        foreach ($rule['links'] as $link) {
                            $tmp_link = str_replace($link, "", $current_url);
                            if ($current_url != $tmp_link or $link == "*") {
                                return $next($request);
                            }
                        }
                    }
                }

                if (!in_array($current_url, $availables_path)) {
                    \core\Notify::add("У вас нет доступа!");
                    return \core\ManagerConf::redirect("index");
                }
            }
        }
//        if ($request->input('age') < 200) {
//            return redirect('home');
//        }

        return $next($request);
    }

}
