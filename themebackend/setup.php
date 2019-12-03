<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo __("backend/main.setup_title"); ?></h2>

    </div>
    <!-- END Example Title -->

    <form action="<?php echo route('backend/setup/save') ?>" method="POST">
        <h4><?php echo __("backend/main.seo_title_page"); ?></h4>



        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingNull">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseNull" aria-expanded="true" aria-controls="collapseNull">
                            <?php echo __("backend/main.default_lang"); ?>
                        </a>
                    </h4>
                </div>
                <div id="collapseNull" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingNull">
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <td>meta-title</td>
                                <td><input class="form-control" type="text" name="APP_TITLE" required value="<?php
                                    if (isset($config['APP_TITLE'])) {
                                        echo $config['APP_TITLE'];
                                    }
                                    ?>"></td>
                            </tr>
                            <tr>
                                <td>Meta keywords</td>
                                <td><textarea name="APP_META_KEYWORDS" class="form-control" rows="2"><?php
                                        if (isset($config['APP_META_KEYWORDS'])) {
                                            echo $config['APP_META_KEYWORDS'];
                                        }
                                        ?></textarea></td>
                            </tr>
                            <tr>
                                <td>Meta description</td>
                                <td><textarea name="APP_META_DESCRIPTION" class="form-control" rows="2"><?php
                                        if (isset($config['APP_META_DESCRIPTION'])) {
                                            echo $config['APP_META_DESCRIPTION'];
                                        }
                                        ?></textarea></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <?php
            if (\languages\models\LanguageHelp::is("frontend")) {
                ?>
                <?php
                $languages = \languages\models\LanguageHelp::getAll("frontend");
                foreach ($languages as $lang) {

                    $title = "";
                    $meta_description = "";
                    $meta_keywords = "";
                    if (isset($config['APP_TITLE_' . strtoupper($lang)])) {
                        $title = $config['APP_TITLE_' . strtoupper($lang)];
                    }
                    if (isset($config['APP_META_DESCRIPTION_' . strtoupper($lang)])) {
                        $meta_description = $config['APP_META_DESCRIPTION_' . strtoupper($lang)];
                    }
                    if (isset($config['APP_META_KEYWORDS_' . strtoupper($lang)])) {
                        $meta_keywords = $config['APP_META_KEYWORDS_' . strtoupper($lang)];
                    }
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading<?php echo $lang; ?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $lang; ?>" aria-expanded="true" aria-controls="collapse<?php echo $lang; ?>">
                                    <?php echo __("backend/main.language"); ?> <?php echo $lang; ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse<?php echo $lang; ?>" class="panel-collapse collapse " role="tabpanel" aria-labelledby="heading<?php echo $lang; ?>">
                            <div class="panel-body">
                                <table class="table">
                                    <tr>
                                        <td>meta-title </td>
                                        <td><input class="form-control" type="text" name="APP_TITLE_<?php echo strtoupper($lang); ?>"  value="<?php echo $title; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Meta keywords</td>
                                        <td><textarea name="APP_META_KEYWORDS_<?php echo strtoupper($lang); ?>" class="form-control" rows="2"><?php echo $meta_keywords; ?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Meta description</td>
                                        <td><textarea name="APP_META_DESCRIPTION_<?php echo strtoupper($lang); ?>" class="form-control" rows="2"><?php echo $meta_description; ?></textarea></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>




            </div>
            <?php
        }
        ?>


        <table class="table">
            <tr>
                <td><?php echo __("backend/main.setup_css"); ?></td>
                <td>
                    <select class="form-control" name="css" required>
                        <option <?php
                        if (isset($config['APP_BACKEND_CSS']) and $config['APP_BACKEND_CSS'] == "amethyst.css") {
                            echo 'selected';
                        }
                        ?> value="amethyst.css">amethyst.css</option>
                        <option <?php
                        if (isset($config['APP_BACKEND_CSS']) and $config['APP_BACKEND_CSS'] == "classy.css") {
                            echo 'selected';
                        }
                        ?> value="classy.css">classy.css</option>
                        <option <?php
                        if (isset($config['APP_BACKEND_CSS']) and $config['APP_BACKEND_CSS'] == "creme.css") {
                            echo 'selected';
                        }
                        ?> value="creme.css">creme.css</option>
                        <option <?php
                        if (isset($config['APP_BACKEND_CSS']) and $config['APP_BACKEND_CSS'] == "flat.css") {
                            echo 'selected';
                        }
                        ?> value="flat.css">flat.css</option>
                        <option <?php
                        if (isset($config['APP_BACKEND_CSS']) and $config['APP_BACKEND_CSS'] == "passion.css") {
                            echo 'selected';
                        }
                        ?> value="passion.css">passion.css</option
                        <option <?php
                        if (isset($config['APP_BACKEND_CSS']) and $config['APP_BACKEND_CSS'] == "social.css") {
                            echo 'selected';
                        }
                        ?> value="social.css">social.css</option
                    </select></td>
            </tr>
            <tr>
                <td><?php echo __("backend/main.setup_copyright"); ?></td>
                <td>
                    <input type="text" class="form-control" value="<?php
                    if (isset($config['APP_BACKEND_COPYRIGHT_TITLE'])) {
                        echo $config['APP_BACKEND_COPYRIGHT_TITLE'];
                    }
                    ?>" name="name" required>
                </td>
            </tr>
            <tr>
                <td><?php echo __("backend/main.setup_link"); ?></td>
                <td>
                    <input type="text" class="form-control" value="<?php
                    if (isset($config['APP_BACKEND_COPYRIGHT_LINK'])) {
                        echo $config['APP_BACKEND_COPYRIGHT_LINK'];
                    }
                    ?>" name="link" required>
                </td>
            </tr>

            <tr>
                <td><?php echo __("backend/main.status_site"); ?></td>
                <td><select name='disabled' class='form-control'>
                        <option  value='false'><?php echo __("backend/main.enable"); ?></option>
                        <option <?php
                        if (isset($config['APP_DISABLED']) and $config['APP_DISABLED'] == TRUE) {
                            echo "selected";
                        }
                        ?> value='true'><?php echo __("backend/main.disable"); ?></option>
                    </select></td>
            </tr>
            <tr>
                <td><?php echo __("backend/main.debug_mode"); ?></td>
                <td><select name='APP_DEBUG' class='form-control'>
                        <option  value='false'><?php echo __("backend/main.disable"); ?></option>
                        <option <?php
                        if (isset($config['APP_DEBUG']) and $config['APP_DEBUG'] == TRUE) {
                            echo "selected";
                        }
                        ?> value='true'><?php echo __("backend/main.enable"); ?></option>
                    </select></td>
            </tr>
            <tr>
                <td><?php echo __("backend/main.disable_message"); ?></td>
                <td>
                    <textarea class='form-control' name='disable_message'><?php
                        if (isset($config['APP_DISABLED_MESSAGE'])) {
                            echo $config['APP_DISABLED_MESSAGE'];
                        }
                        ?></textarea>
                </td>

            </tr>


            <tr>
                <td>
                    <?php echo csrf_field(); ?>

                </td>
                <td>
                    <button type="submit" class="btn btn-submit"><?php echo __("backend/main.setup_save"); ?></button>
                </td>
            </tr>

        </table>
    </form>

</div>
