<ol class="breadcrumb">

    <li><a href="{pathadmin}share/index"><?php echo __("backend/share.templates"); ?></a></li>
    <li class="active"><?php echo __("backend/share.edit_template"); ?></li>
</ol>

<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo __("backend/share.edit_template"); ?></h2>
    </div>
    <!-- END Example Title -->

    <form action="<?php echo route('backend/share/doedit', $key); ?>" method="POST">
        <table class="table">
            <tr>
                <td>
                    <?php echo __("backend/share.title"); ?>    
                </td>
                <td><input type="text" name="title" value="<?php echo $row['title']; ?>" class="form-control"></td>
            </tr>
            <tr>
                <td><?php echo __("backend/share.type_publish"); ?></td>
                <td>
                    <select name="type_publish">
                        <option <?php
                        if ($row['type_publish'] == "link") {
                            echo 'selected';
                        }
                        ?> value="link"><?php echo __("backend/share.typep_link"); ?></option> 
                        <option <?php
                        if ($row['type_publish'] == "textlink") {
                            echo 'selected';
                        }
                        ?> value="textlink"><?php echo __("backend/share.typep_textlink"); ?></option>
                        <option <?php
                        if ($row['type_publish'] == "text") {
                            echo 'selected';
                        }
                        ?> value="text"><?php echo __("backend/share.typep_text"); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo __("backend/share.images"); ?></td>   
                <td><textarea name="photos_field" class="form-control"><?php echo $row['photos_field']; ?></textarea></td>
            </tr>
            <tr>
                <td><?php echo __("backend/share.template_publish"); ?></td>   
                <td>
                    <?php echo __("backend/share.template_publish_descr"); ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><textarea name="text_field" class="form-control"><?php echo $row['text_field']; ?></textarea></td>
            </tr>
            <tr>
                <td><?php echo __("backend/share.type_template"); ?></td>
                <td>
                    <?php echo $row['type']; ?>
                </td>
            </tr>
            <?php
            echo $params_form;
            ?>
            <tr>
                <td>   <td><?php echo csrf_field(); ?></td></td>
                <td>
                    <button type="submit"  class="btn btn-success"><?php echo __("backend/share.edit_template"); ?></button>
                </td>
            </tr>
        </table>
    </form>

</div>
