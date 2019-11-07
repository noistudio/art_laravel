<ol class="breadcrumb">

    <li><a href="{pathadmin}blocks/index"><?php echo __("backend/blocks.all_blocks"); ?></a></li>
    <li class="active"><?php echo __("backend/blocks.add_block"); ?></li>
</ol>
<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo __("backend/blocks.add_block"); ?></h2>

    </div>
    <!-- END Example Title -->
    <form action="{pathadmin}blocks/add/ajaxadd" class="ajaxsend" method="POST">
        <!-- Example Content -->
        <table class="table">
            <tr>
                <td><?php echo __("backend/blocks.title_block"); ?></td>
                <td><input type='text' name='title' class='form-control' required></td>
            </tr>
            <tr>
                <td><?php echo __("backend/blocks.type"); ?></td>
                <td><select class='form-control choosetype' name='type'>
                        <option    value='html'><?php echo __("backend/blocks.show_html"); ?> </option>
                        <?php
                        if (count($types)) {
                            foreach ($types as $type) {
                                ?>
                                <option   value='<?php echo $type['id'] ?>'><?php echo $type['title']; ?></option> 
                                <?php
                            }
                        }
                        ?>
                    </select></td>
            </tr>
            <tr class='field_html'>
                <td><?php echo __("backend/blocks.html"); ?></td>
                <td><textarea name="html" class='form-control tiny'></textarea></td>
            </tr>

        </table>
        <div class=' field_others'></div>
        <?php
        echo csrf_field();
        ?>
        <table class="table">
            <tr>
                <td><button type="submit" class="btn btn-primary" ><?php echo __("backend/blocks.add_block"); ?></button></td>
            </tr>
        </table>
    </form>
</div>
