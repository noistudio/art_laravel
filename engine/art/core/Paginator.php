<?php

namespace core;

use plugsystem\GlobalParams;
use plugsystem\models\ViewModel;
use Yii;
use yii\helpers\Url;

class Paginator {

    public function get() {
        $offset = 0;
        $get = request()->query->all();

        if (isset($get['offset']) and is_numeric($get['offset']) and (int) $get['offset'] >= 0) {
            $offset = (int) $get['offset'];
        }
        return $offset;
    }

    private function getUrl($offset) {

        $tmp_url = request()->server("REQUEST_URI");
        $tmp_url = explode("?", $tmp_url);

        $get = request()->query->all();
        $get['offset'] = $offset;
        $url = $tmp_url[0];
        $copyurl = $url;
        // if (isset($copyurl[0]) and  $copyurl[0]="/") {
        //     $copyurl=substr($copyurl, 1);
        // }



        if (isset($get[$copyurl])) {
            unset($get[$copyurl]);
        }

        $url = $url . "?" . http_build_query($get);
        return $url;
    }

    public function show($count, $offset, $on_page) {


        $max_count = $count;
        $current_page = 1;
        $current_page = ceil($offset / $on_page) + 1;
        $result = array();
        $result['next'] = false;
        $result['prev'] = false;
        $result['current_page'] = $current_page;
        $result['next_pages'] = array();
        $result['prev_pages'] = array();
        $i = $offset;
        $trying = 0;
        while ($i < $max_count) {
            $i += $on_page;
            if ($i < $max_count) {
                $trying++;
                $result['next_pages'][] = array('page' => ceil($i / $on_page) + 1, 'offset' => $this->getUrl($i));
                if ($trying == 3) {
                    break;
                }
            }
        }


        if ($current_page >= 1) {
            $i = $offset;
            $trying = 0;
            while ($i > 0) {
                $i -= $on_page;

                if ($i >= 0) {
                    $trying++;
                    $result['prev_pages'][] = array('page' => ceil($i / $on_page) + 1, 'offset' => $this->getUrl($i));

                    if ($trying == 3) {
                        break;
                    }
                }
            }
        }
        if (count($result['prev_pages'])) {
            $result['prev_pages'] = array_reverse($result['prev_pages']);
        }
        if (isset($result['prev_pages'][0])) {
            $result['prev'] = $result['prev_pages'][0];
        }
        if (isset($result['next_pages'][0])) {
            $result['next'] = $result['next_pages'][0];
        }


        if ($count > 0 and $count > $on_page) {
            return view("app::paginator", $result)->render();
        } else {
            return "";
        }
    }

}
