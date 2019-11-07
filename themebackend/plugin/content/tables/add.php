 
<ol class="breadcrumb">



    <li class="active"><?php echo __("backend/content.create_table") ?></li>
</ol>
<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">

        </div>
        <h2><?php echo __("backend/content.add_table") ?> </h2>
    </div>
    <!-- END Example Title -->

    <!-- Example Content -->
    <form action="{pathadmin}content/tables/ajaxadd" class="ajaxsend" method="POST">
        <table class="table">
            <tr>
                <td><?php echo __("backend/content.table_name") ?></td>
                <td><input type="text" name="name" class="form-control" required></td>
            </tr>
            <tr>
                <td><?php echo __("backend/content.table_title") ?></td>
                <td><input type="text" name="title" class="form-control" required></td>
            </tr>
            <tr>
                <td><?php echo __("backend/content.count_on_page") ?></td>
                <td><input type="number" name="count" min="0" class="form-control" required></td>
            </tr>

            <tr>
                <td colspan="2"><strong><?php echo __("backend/content.fields_on_page") ?></strong>:</td>
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
                    <a href="#" data-next="0" class="btn btn-success addfield"><i class="fa fa-plus"></i> поле</a>
                </td>
            </tr>



            <tr><td><?php echo csrf_field(); ?></td>
                <td><button class="btn btn-danger btn_add_table" disabled  ><?php echo __("backend/content.do_add_table") ?></button></td>
            </tr>
        </table>
    </form>

</div>
