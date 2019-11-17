<ol class="breadcrumb">
    <li><a href="{pathadmin}menu/index"><?php echo __("backend/menu.list"); ?></a></li>
    <li class="active"><?php echo $menu['title']; ?></li>
</ol>
<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo $menu['title']; ?></h2>

    </div>
    <ul class="nav nav-tabs">
        <li class="active"><a href="{pathadmin}menu/update/<?php echo $menu['id']; ?>">  <?php echo __("backend/menu.edit_tab"); ?></i> </a></li>
        <li><a href="{pathadmin}menu/update/template/<?php echo $menu['id']; ?>"><i class="fa fa-html"></i> <?php echo __("backend/menu.template"); ?></a></li>


    </ul>
    <!-- END Example Title -->

    <form action="{pathadmin}menu/update/doedit/<?php echo $menu['id']; ?>" method="POST">
        <table class="table">
            <tr>
                <td><?php echo __("backend/menu.code_template"); ?></td>
                <td><textarea class="form-control" readonly>[menu<?php echo $menu['id']; ?>]</textarea></td>
            </tr>
            <tr>
                <td><?php echo __("backend/menu.menu_title"); ?></td> 
                <td><input type="text" name="title" class="form-control" required value="<?php echo $menu['title']; ?>"  ></td>
            </tr>
            <tr>
                <td><?php echo __("backend/menu.publish"); ?></td>
                <td>
                    <input type="checkbox" name="status" value="1" class="form-control" <?php
                    if ($menu['status'] == 1) {
                        echo 'checked';
                    }
                    ?>>
                </td>
            </tr>
            <tr>
                <td><?php echo csrf_field(); ?></td> 
                <td><button type="submit" class="btn btn-danger"   value="  "><?php echo __("backend/menu.edit_menu"); ?></button></td>
            </tr>
        </table>
    </form>

    <h4><?php echo __("backend/menu.links"); ?></h4>

    <form action="{pathadmin}menu/update/add/<?php echo $menu['id']; ?>" method="POST">
        <table class="table">
            <tr>
                <td><?php echo __("backend/menu.title"); ?></td>
                <td><textarea class="form-control" name="title"></textarea></td>
            </tr>
            <?php
            if (languages\models\LanguageHelp::is("frontend")) {
                $languages = languages\models\LanguageHelp::getAll("frontend");
                ?>
                <tr>
                    <td><?php echo __("backend/menu.language"); ?></td>
                    <td>
                        <select class="form-control" name="language">
                            <option value="null"><?php echo __("backend/menu.all_languages"); ?></option>
                            <?php
                            foreach ($languages as $lang) {
                                ?>
                                <option value="<?php echo $lang; ?>"><?php echo $lang; ?></option>   
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td><?php echo __("backend/menu.type"); ?></td>
                <td><select data-target=".link_input" class="value_to_edit form-control">
                        <option value="null"><?php echo __("backend/menu.not_choosed"); ?></option>
                        <?php
                        if (count($types)) {
                            foreach ($types as $type) {
                                ?>
                                <option value="<?php echo $type['value']; ?>"><?php echo $type['title']; ?></option>
                                <?php
                            }
                        }
                        ?>

                    </select></td>
            </tr>
            <tr>
                <td>target <a href="http://htmlbook.ru/html/a/target" target="_blank"><i class="fa fa-question-circle"></i></a></td>
                <td><select name="target" class="form-control">
                        <option value="_self">_self</option>
                        <option value="_blank">_blank</option>
                        <option value="_top">_parent</option>
                    </select></td>
            </tr>
            <tr>
                <td><?php echo __("backend/menu.link"); ?></td>
                <td><input type="text" name="link" class="link_input form-control" value=""></td>
            </tr>
            <tr>
                <td><?php echo __("backend/menu.parent"); ?></td>
                <td><select name="parent" class=" form-control">
                        <option value="null"><?php echo __("backend/menu.not_choosed"); ?></option>
                        <?php
                        if (count($parents)) {
                            foreach ($parents as $key => $link) {
                                ?>
                                <option value="<?php echo $key; ?>"><?php echo $link['prefix_title']; ?></option>
                                <?php
                            }
                        }
                        ?>

                    </select></td>
            </tr>
            <tr>
                <td><?php echo csrf_field(); ?></td>
                <td><button class="btn btn-primary" type="submit"  ><?php echo __("backend/menu.add"); ?></button></td>

            </tr>
        </table>
    </form>

    <?php
    if (count($menu['links'])) {
        echo $controller->renderEditMenu($menu['links'], "", $menu['id']);
    }
    ?>
    <table class="table" style="display:none;">
        <?php
        if (count($menu['links'])) {
            foreach ($menu['links'] as $key => $link) {
                $language = "";
                if (isset($link['language']) and $link['language'] != "null") {
                    $language = "{" . $link['language'] . "}";
                }
                ?>
                <tr> 
                    <td>
                        <a href="{pathadmin}menu/arrows/up/<?php echo $menu['id']; ?>/<?php echo $key; ?>/null"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
                        <?php echo $link['sort']; ?>
                        <a href="{pathadmin}menu/arrows/down/<?php echo $menu['id']; ?>/<?php echo $key; ?>/null"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                    </td>
                    <td></td>
                    <td><?php echo $link['title']; ?></td>
                    <td><?php echo $language; ?></td>
                    <td><a href="{pathadmin}menu/update/editlink/<?php echo $menu['id']; ?>/<?php echo $key; ?>/null"><?php echo __("backend/menu.edit"); ?></a></td>
                    <td><a href="{pathadmin}menu/update/delete/<?php echo $menu['id']; ?>/<?php echo $key; ?>/null"><?php echo __("backend/menu.delete"); ?></a></td>

                </tr>

                <?php
                if (count($link['childrens'])) {
                    ?>
                    <tr>
                        <td colspan="5"><?php echo __("backend/menu.submenu"); ?>:</td>
                    </tr>
                    <?php
                    foreach ($link['childrens'] as $subkey => $children) {
                        ?>
                        <tr> 
                            <td></td>
                            <td>
                                <a href="{pathadmin}menu/arrows/up/<?php echo $menu['id']; ?>/<?php echo $key; ?>/<?php echo $subkey; ?>"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
                                <?php echo $children['sort']; ?>
                                <a href="{pathadmin}menu/arrows/down/<?php echo $menu['id']; ?>/<?php echo $key; ?>/<?php echo $subkey; ?>"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                            </td>
                            <td><?php echo $children['title']; ?></td>
                            <td><a href="{pathadmin}menu/update/editlink/<?php echo $menu['id']; ?>/<?php echo $key; ?>/<?php echo $subkey; ?>"><?php echo __("backend/menu.edit"); ?></a></td>
                            <td><a href="{pathadmin}menu/update/delete/<?php echo $menu['id']; ?>/<?php echo $key; ?>/<?php echo $subkey; ?>"><?php echo __("backend/menu.delete"); ?></a></td>
                        </tr>
                        <?php
                    }
                }
            }
        }
        ?>
    </table>

</div>
