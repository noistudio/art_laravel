<ol class="breadcrumb">

    <li><a href="{pathadmin}share/index"><?php echo __("backend/share.templates"); ?></a></li>
    <li class="active"><?php echo __("backend/share.new"); ?></li>
</ol>

<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo __("backend/share.new"); ?></h2>
    </div>
    <!-- END Example Title -->

    <form action="<?php echo route('backend/share/doadd'); ?>" method="POST">
        <table class="table">
            <tr>
                <td>
                    <?php echo __("backend/share.title"); ?>  
                </td>
                <td><input type="text" name="title" class="form-control"></td>
            </tr>
            <tr>
                <td><?php echo __("backend/share.type_publish"); ?></td>
                <td>
                    <select name="type_publish" class="form-control">
                        <option value="link"><?php echo __("backend/share.typep_link"); ?></option> 
                        <option value="textlink"><?php echo __("backend/share.typep_textlink"); ?></option>
                        <option value="text"><?php echo __("backend/share.typep_text"); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo __("backend/share.images"); ?></td>   
                <td><textarea name="photos_field" class="form-control"></textarea></td>
            </tr>
            <tr>
                <td><?php echo __("backend/share.template_publish"); ?></td>   
                <td>
                    <?php echo __("backend/share.template_publish_descr"); ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><textarea name="text_field" class="form-control"></textarea></td>
            </tr>
            <tr>
                <td><?php echo __("backend/share.type_template"); ?></td>
                <td>
                    <select class="form-control" name="type">
                        <?php
                        if (count($types)) {
                            foreach ($types as $type) {
                                ?>
                                <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td><?php echo csrf_field(); ?></td>
                <td>
                    <button type="submit"   class="btn btn-success"><?php echo __("backend/share.add"); ?></button>
                </td>
            </tr>
        </table>
    </form>

</div>
