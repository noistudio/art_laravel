<ol class="breadcrumb">


    <li class="active"><?php echo __("backend/mg.create_collection") ?></li>
</ol>
<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">

        </div>
        <h2><?php echo __("backend/mg.create_collection") ?> </h2>
    </div>
    <!-- END Example Title -->

    <!-- Example Content -->
    <form action="{pathadmin}mg/collections/ajaxadd" class="ajaxsend" method="POST">
        <table class="table">
            <tr>
                <td><?php echo __("backend/mg.collection_name") ?></td>
                <td><input type="text" name="name" class="form-control" required></td>
            </tr>
            <tr>
                <td><?php echo __("backend/mg.collection_title") ?></td>
                <td><input type="text" name="title" class="form-control" required></td>
            </tr>
            <tr>
                <td><?php echo __("backend/mg.collection_count") ?></td>
                <td><input type="number" name="count" min="0" class="form-control" required></td>
            </tr>

            <tr>
                <td colspan="2"><strong><?php echo __("backend/mg.fields") ?></strong>:</td>
            </tr>
            <tr class="tr_add_field">
                <td>
                    <select class="form-control table_field" name="field" >
                        <?php
                        if (count($fields)) {
                            foreach ($fields as $field) {
                                ?>
                                <option value="<?php echo $field['name']; ?>"><?php echo $field['title']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <a href="#" data-next="0" data-link="mg/collections/field/" class="btn btn-success addfield"><i class="fa fa-plus"></i> <?php echo __("backend/mg.field") ?></a>
                </td>
            </tr>



            <tr><td><?php echo csrf_field(); ?></td>
                <td><button class="btn btn-danger btn_add_table" disabled ><?php echo __("backend/mg.create_btn") ?></button></td>
            </tr>
        </table>
    </form>

</div>
