<ol class="breadcrumb">

    <li><a href="{pathadmin}blocks/index"><?php echo __("backend/blocks.all_blocks"); ?></a></li>
    <li class="active"><?php echo $block['title']; ?></li>
</ol>
<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo $block['title']; ?></h2>

    </div>
    <!-- END Example Title -->
    <form action="{pathadmin}blocks/update/ajaxedit/<?php echo $block['id']; ?>" class="ajaxsend" method="POST">
        <!-- Example Content -->
        <table class="table">
            <tr>
                <td><?php echo __("backend/blocks.code_html"); ?></td>
                <td><textarea class="form-control " readonly="readonly">[block<?php echo $block['id']; ?>]</textarea></td>
            </tr>
            <tr>
                <td><?php echo __("backend/blocks.title_block"); ?></td>
                <td><input type='text' name='title' class='form-control' value="<?php echo $block['title']; ?>" required></td>
            </tr>
            <tr>
                <td><?php echo __("backend/blocks.is_publishing"); ?></td>
                <td><input type='checkbox' name='status' class='form-control' value="1" <?php
                    if ($block['status'] == 1) {
                        echo 'checked';
                    }
                    ?>  ></td>
            </tr>
            <tr>
                <td><?php echo __("backend/blocks.type"); ?></td>
                <td><select class='form-control choosetype' name='type'>
                        <option    value='html'><?php echo __("backend/blocks.show_html"); ?> </option>
                        <?php
                        if (count($types)) {
                            foreach ($types as $type) {
                                $selected = "";
                                if ($block['type'] == $type['id']) {
                                    $selected = "selected";
                                }
                                ?>
                                <option <?php echo $selected; ?>   value='<?php echo $type['id'] ?>'><?php echo $type['title']; ?></option> 
                                <?php
                            }
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td>font aweasome icon</td>
                <td><select class="selectpicker "  data-hide-disabled="true"  data-width="100%" data-dropup-auto="false"  data-live-search="true" name="icon" searchable="Search here..">

                        <?php
                        if (isset($icons)) {
                            foreach ($icons as $icon) {
                                $selected = "";
                                if (isset($block['params']['_icon']) and $block['params']['_icon'] == $icon) {
                                    $selected = "selected";
                                }
                                ?>
                                <option value="<?php echo $icon; ?>" <?php echo $selected; ?> data-content='<i class="fa <?php echo $icon; ?> fa-fw"></i> <?php echo $icon; ?>'></option>
                                <?php
                            }
                        }
                        ?>


                    </select></td>
            </tr>
            <tr class='field_html' <?php if ($block['type'] != "html") { ?> style="display:none;" <?php } ?>>
                <td><?php echo __("backend/blocks.html"); ?></td>
                <td><textarea class='form-control tiny' name="html"><?php echo $block['html']; ?></textarea></td>
            </tr>
            <?php
            if (languages\models\LanguageHelp::is("frontend")) {
                $languages = languages\models\LanguageHelp::getAll("frontend");
                if (count($languages)) {
                    foreach ($languages as $lang) {
                        ?>
                        <tr class='field_html' <?php if ($block['type'] != "html") { ?> style="display:none;" <?php } ?>>
                            <td><?php echo __("backend/blocks.html"); ?>(<?php echo $lang; ?>)</td>
                            <td><textarea class='form-control tiny' name="html_<?php echo $lang; ?>"><?php echo $block['html_' . $lang]; ?></textarea></td>
                        </tr>
                        <?php
                    }
                }
            }
            ?>

        </table>
        <div class=' field_others' <?php if ($block['type'] == "html") { ?> style="display:none;" <?php } ?>>
            <?php
            echo $block['typehtml'];
            ?>
        </div>
        <?php
        echo csrf_field();
        ?>
        <table class="table">
            <tr>
                <td><button type="submit"  class="btn btn-primary" ><?php echo __("backend/blocks.editing_block"); ?></button></td>
            </tr>
        </table>
    </form>
</div>
