<?php

namespace menu\models;

use blocks\models\AbstractBlock;
use plugsystem\GlobalParams;

class MenuBlock extends AbstractBlock {

    public function __construct($op, $value, $params = array(), $block = array()) {

        parent::__construct($op, $value, $params, $block);
    }

    public function run() {

        if (!isset($this->params['postfix_template'])) {
            $this->params['postfix_template'] = "";
        }
        $postfix_template = $this->params['postfix_template'];
        return \menu\models\MenuModel::runMenu($this->op, $postfix_template);
    }

    public function editPage() {
        $controller = new \menu\controllers\backend\UpdateMenu();
        $id = (int) $this->op;

        $menu = \menu\models\MenuModel::get($id);
        if (is_array($menu)) {

            if (!isset($this->params['postfix_template'])) {
                $this->params['postfix_template'] = "";
            }

            $data = array();
            $data['menu'] = $menu;
            $template = "";
            $template = '<div class="menu">
    <?php
    if (count($this->links)) {
        foreach ($this->links as $link) {
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
            $data['path_template'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/menu/menu" . $id . $this->params['postfix_template'] . ".php";
            $data['params'] = $this->params;

            return $controller->partial_render("add_block_one", $data);
        }

        return "";
    }

    public function validate() {


        if (isset($this->params['postfix_template']) and is_string($this->params['postfix_template']) and strlen($this->params['postfix_template']) > 0) {
            return $this->success();
        } else {
            $this->params['postfix_template'] = "";
            return $this->success();
        }
    }

    public function addPage() {
        $controller = new \menu\controllers\backend\UpdateMenu();
        $id = (int) $this->op;

        $menu = \menu\models\MenuModel::get($id);
        if (is_array($menu)) {

            if (!isset($this->params['postfix_template'])) {
                $this->params['postfix_template'] = "";
            }

            $data = array();
            $data['menu'] = $menu;
            $template = "";
            $template = '<div class="menu">
    <?php
    if (count($this->links)) {
        foreach ($this->links as $link) {
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
            $data['path_template'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/menu/menu" . $id . $this->params['postfix_template'] . ".php";
            $data['params'] = $this->params;
            return $controller->partial_render("add_block_one", $data);
        }

        return "";
    }

}
