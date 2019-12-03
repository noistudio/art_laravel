
<?php
if (count($links)) {
    foreach ($links as $key => $link) {
        $language = "";
        if (isset($link['language']) and $link['language'] != "null") {
            $language = "{" . $link['language'] . "}";
        }
        $newkey = $key;
        if (isset($prefix) and strlen($prefix) > 0) {
            $newkey = $prefix . "_" . $key;
        }
        ?>
        <div class="block">
            <div class="row">
                <div class="col-md-2">
                    <a href="{pathadmin}menu/arrows/up/<?php echo $menu_id; ?>/<?php echo $newkey; ?>"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
                    <?php echo $link['sort']; ?>
                    <a href="{pathadmin}menu/arrows/down/<?php echo $menu_id; ?>/<?php echo $newkey; ?>"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>

                </div>

                <div class="col-md-2"><?php echo $link['title']; ?></div>
                <div class="col-md-2"><?php echo $language; ?></div>
                <div class="col-md-2"><a href="{pathadmin}menu/update/editlink/<?php echo $menu_id; ?>/<?php echo $newkey; ?>"><?php echo __("backend/menu.edit"); ?></a></div>
                <div class="col-md-2"><a href="{pathadmin}menu/update/delete/<?php echo $menu_id; ?>/<?php echo $newkey; ?>"><?php echo __("backend/menu.delete"); ?></a></div>
            </div>
            <?php
            if (isset($link['childrens']) and is_array($link['childrens']) and count($link['childrens']) > 0) {
                ?>
                <div class="row">   
                    <div class="col-md-2"><?php echo __("backend/menu.submenu"); ?></div>
                    <div class="col-md-10">
                        <?php
                        echo $controller->renderEditMenu($link['childrens'], $newkey, $menu_id);
                        ?>
                    </div>

                </div>


                <?php
            }
            ?>
        </div>
        <?php
    }
}
?>
