<ol class="breadcrumb">
    <li><a href="{pathadmin}forms/manage/<?php echo $form['id']; ?>"><?php echo $form['title']; ?></a></li>

    <li class="active"><?php echo __("backend/forms.look_msg", array('id' => $row['last_id'])); ?></li>
</ol>
<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">

        </div>
        <h2><?php echo __("backend/forms.msg", array("id" => $row['last_id'])); ?></h2>
    </div>
    <!-- END Example Title -->

    <!-- Example Content -->
    <table class="table">
        <tr>
            <td><?php echo __("backend/forms.date_create"); ?></td>
            <td><?php echo $row['date_create']; ?></td>
        </tr>
        <?php
        if (count($form['fields'])) {
            foreach ($form['fields'] as $name => $field) {
                ?>
                <tr>
                    <td><?php echo $field['title']; ?></td>
                    <td><?php echo $row[$name . "_val"]; ?></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>

</div>
