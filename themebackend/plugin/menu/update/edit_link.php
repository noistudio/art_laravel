<ol class="breadcrumb">
    <li><a href="{pathadmin}menu/index"><?php echo __("backend/menu.list"); ?></a></li>
    <li><a href="{pathadmin}menu/update/<?php echo $menu['id']; ?>"><?php echo $menu['title']; ?></a></li>
    <?php
    if (isset($link['parent'])) {
        ?>
        <li><a href="{pathadmin}menu/update/editlink/<?php echo $menu['id']; ?>/<?php echo $link['parent']['key']; ?>/null"><?php echo $link['parent']['title']; ?></a></li>
        <li class="active"><?php echo __("backend/menu.edit_link"); ?></li>
        <?php
    } else {
        ?>
        <li class="active"><?php echo __("backend/menu.edit_link"); ?></li>
        <?php
    }
    ?>

</ol>
<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo __("backend/menu.edit_link"); ?></h2>

    </div>
    <!-- END Example Title -->



    <form action="{pathadmin}menu/update/doeditlink/<?php echo $menu['id']; ?>/<?php echo $suffix; ?>" method="POST">
        <table class="table">
            <tr>
                <td><?php echo __("backend/menu.title"); ?></td>
                <td><textarea class="form-control" name="title"  ><?php echo $link['title']; ?></textarea></td>
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
                                $selected = "";
                                if ($link['language'] == $lang) {
                                    $selected = "selected";
                                }
                                ?>
                                <option <?php echo $selected; ?> value="<?php echo $lang; ?>"><?php echo $lang; ?></option>   
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
                <td>Тип</td>
                <td><select data-target=".link_input" class="value_to_edit form-control">
                        <option value="null"><?php echo __("backend/menu.not_choosed"); ?></option>
                        <?php
                        if (count($types)) {
                            foreach ($types as $type) {
                                $selected = "";
                                if ($link['link'] == $type['value']) {
                                    $selected = "selected";
                                }
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
                        <option <?php
                        if ($link['target'] == "_self") {
                            echo 'selected';
                        }
                        ?> value="_self">_self</option>
                        <option <?php
                        if ($link['target'] == "_blank") {
                            echo 'selected';
                        }
                        ?> value="_blank">_blank</option>
                        <option  <?php
                        if ($link['target'] == "_top") {
                            echo 'selected';
                        }
                        ?> value="_top">_top</option>
                        <option  <?php
                        if ($link['target'] == "_parent") {
                            echo 'selected';
                        }
                        ?> value="_top">_parent</option>
                    </select></td>
            </tr>
            <tr>
                <td><?php echo __("backend/menu.link"); ?></td>
                <td><input type="text" name="link" class="link_input form-control" value="<?php echo $link['link']; ?>"></td>
            </tr>

            <tr>
                <td><?php echo csrf_field(); ?></td>
                <td><button class="btn btn-primary" type="submit" ><?php echo __("backend/menu.save"); ?></button></td>

            </tr>
        </table>
    </form>
    <?php
    if (isset($link['childrens']) and count($link['childrens']) > 0) {
        echo $controller->renderEditMenu($link['childrens'], $link['prefix'], $menu['id']);
    }
    ?>
</div>
