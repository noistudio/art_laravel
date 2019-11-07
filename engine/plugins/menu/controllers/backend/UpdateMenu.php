<?php

namespace menu\controllers\backend;

use blocks\models\BlocksModel;
use content\models\SqlModel;
use core\AppConfig;

class UpdateMenu extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();
        AppConfig::set("nav", "menu");
    }

    public function actionIndex($id) {



        $menu = \menu\models\MenuModel::get($id);

        if (is_array($menu)) {
            AppConfig::set("subnav", "menu" . $id);
            $data = array();
            $data['menu'] = $menu;
            $data['types'] = \menu\models\MenuModel::loadTypes();
            $data['parents'] = array();

            if (isset($menu['links'])) {
                $data['parents'] = \menu\models\MenuModel::getParents($menu['links']);
            }


            $data['controller'] = $this;


            return $this->render("edit", $data);
        }
    }

    public function renderEditMenu($links, $prefix = "", $menuID) {

        $data = array();
        $data['links'] = $links;
        $data['prefix'] = $prefix;
        $data['controller'] = $this;
        $data['menu_id'] = $menuID;
        return $this->partial_render("edit_menu_list", $data);
    }

    public function actionTemplate($id) {

        $menu = \menu\models\MenuModel::get($id);
        if (is_array($menu)) {
            AppConfig::set("subnav", "menu" . $id);
            $data = array();
            $data['menu'] = $menu;
            $template = "";
            $template = '<div class="menu">
    <?php
    if (count($links)) {
        foreach ($links as $link) {
            if (isset($link["childrens"])) {
                ?><li class="<?php
                if ($link["choose"]) {
                    echo "active";
                }
                ?>">
                    <a href="<?php echo $link["link"]; ?>" target="<?php echo $link["target"]; ?>"><?php echo $link["title"]; ?></a>
                    <br>
                    <ul>
                        <?php foreach ($link["childrens"] as $sublink) { ?> <?php ?>
                            <li class="<?php
                            if ($sublink["choose"]) {
                                echo "active";
                            }
                            ?>"><a href="<?php echo $sublink["link"]; ?>" target="<?php echo $sublink["target"]; ?>"><?php echo $sublink["title"]; ?></a></li><?php } ?></ul></li> 

            <?php }
        else {
                ?>
                <li class="<?php
                if ($link["choose"]) {
                    echo "active";
                }
                ?>">  <a href="<?php echo $link["link"]; ?>" target="<?php echo $link["target"]; ?>"><?php echo $link["title"]; ?></a></li>
                    <?php
                }
            }
    } ?>
</div>

';

            $template = htmlspecialchars($template);
            $data['template'] = $template;
            $data['path_template'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/menu/menu" . $id . ".php";

            return $this->render("template", $data);
        }
    }

    public function actionDoedit($id) {

        $menu = \menu\models\MenuModel::get($id);
        if (is_array($menu)) {
            return \menu\models\MenuModel::edit($menu);
        }
    }

    public function actionAdd($id) {

        $menu = \menu\models\MenuModel::get($id);
        if (is_array($menu)) {
            $result = \menu\models\MenuModel::addLink($menu);

            if (isset($result['message'])) {
                \core\Notify::add($result['message'], $result['type']);
            }
            return back();
        }
    }

    public function actionEditlink($id_menu, $id_link) {

        $menu = \menu\models\MenuModel::get($id_menu);
        if (is_array($menu)) {
            AppConfig::set("subnav", "menu" . $id_menu);
            $link = \menu\models\MenuModel::getLink($menu, $id_link);

            if (is_array($link)) {
                $data = array();
                $data['link'] = $link;
                $data['suffix'] = $link['prefix'];
                $data['id_link'] = $id_link;
                $data['types'] = \menu\models\MenuModel::loadTypes();
                $data['menu'] = $menu;
                $data['controller'] = $this;
                return $this->render("edit_link", $data);
            }
        }
    }

    public function actionDelete($id_menu, $id_link) {

        $menu = \menu\models\MenuModel::get($id_menu);
        if (is_array($menu)) {

            $link = \menu\models\MenuModel::getLink($menu, $id_link);

            \menu\models\MenuModel::deleteLink($menu, $id_link, $link);
        }
        return back();
    }

    public function actionDoeditlink($id_menu, $id_link) {

        $menu = \menu\models\MenuModel::get($id_menu);
        if (is_array($menu)) {

            $link = \menu\models\MenuModel::getLink($menu, $id_link);

            \menu\models\MenuModel::saveLink($menu, $id_link, $link);
        }
        return back();
    }

}
