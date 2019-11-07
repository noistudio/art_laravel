<ol class="breadcrumb">
    <li><a href="{pathadmin}routes/index"><?php echo __("backend/routes.list"); ?></a></li>
    <li class="active"><?php echo __("backend/routes.edit"); ?></li>
</ol>
<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo __("backend/routes.edit"); ?></h2>
    </div>

    <!-- END Example Title -->
    <?php
    ?>


    <!-- Example Content -->
    <form enctype="multipart/form-data" action='{pathadmin}routes/update/doupdate/<?php echo $route->id; ?>' method="POST">
        <table class="table">
            <tbody>
                <tr>
                    <td><?php echo __("backend/routes.old_link"); ?> </td>
                    <td><input type="text" name="old_link" class="form-control"  required value="<?php echo $route->old_url; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo __("backend/routes.new_link"); ?></td>
                    <td><input type="text" name="new_link" class="form-control"  required value="<?php echo $route->new_url; ?>">
                    </td>
                </tr>

                <tr>
                    <td><?php echo __("backend/routes.meta_title"); ?> </td>
                    <td><input type="text" name="meta_title" class="form-control"  required value="<?php echo $route->title; ?>">
                    </td>
                </tr>

                <tr>
                    <td><?php echo __("backend/routes.meta_description"); ?> </td>
                    <td><textarea class="form-control " required name="meta_description"   rows=10><?php echo $route->meta_description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td><?php echo __("backend/routes.meta_keywords"); ?> </td>
                    <td><textarea class="form-control " required name="meta_keywords"  rows=10><?php echo $route->meta_keywords; ?></textarea>
                    </td>
                </tr>
                <?php
                if (\languages\models\LanguageHelp::is()) {
                    $languages = \languages\models\LanguageHelp::getAll();
                    foreach ($languages as $lang) {
                        $title = "";
                        $meta_description = "";
                        $meta_keywords = "";
                        if (isset($langs[$lang]['title'])) {
                            $title = $langs[$lang]['title'];
                        }
                        if (isset($langs[$lang]['meta_keywords'])) {
                            $meta_keywords = $langs[$lang]['meta_keywords'];
                        }
                        if (isset($langs[$lang]['meta_description'])) {
                            $meta_description = $langs[$lang]['meta_description'];
                        }
                        ?>
                        <tr>
                            <td><?php echo __("backend/routes.meta_title"); ?> (<?php echo $lang; ?>) </td>
                            <td><input type="text" name="meta_title_<?php echo $lang; ?>" class="form-control"  required value="<?php echo $title; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><?php echo __("backend/routes.meta_description"); ?>(<?php echo $lang; ?>)  </td>
                            <td><textarea class="form-control " required name="meta_description_<?php echo $lang; ?>"  rows=10><?php echo $meta_description; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo __("backend/routes.meta_keywords"); ?> (<?php echo $lang; ?>)  </td>
                            <td><textarea class="form-control " required name="meta_keywords_<?php echo $lang; ?>"   rows=10><?php echo $meta_keywords; ?></textarea>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>






                <tr>
                    <td></td>
                    <td><button type="submit" class="btn btn-warning"><i class="fa fa-floppy-o"></i> <?php echo __("backend/routes.change_btn"); ?></button></td>

                </tr>

            </tbody>
        </table>
        <?php
        echo csrf_field();
        ?>

    </form>

</div>
