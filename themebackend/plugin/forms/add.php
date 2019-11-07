<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">

        </div>
        <h2><?php echo __("backend/forms.form_add"); ?></h2>
    </div>
    <!-- END Example Title -->

    <!-- Example Content -->
    <form action="{pathadmin}forms/ajaxadd" class="ajaxsend" method="POST">
        <table class="table">
            <tr>
                <td><?php echo __("backend/forms.db"); ?></td>
                <td>
                    <select name="type" class="typecontrol form-control">
                        <?php
                        if (!(\core\ManagerConf::isOnlyMongodb())) {
                            ?>
                            <option data-fields="content/tables/select/"  data-link="content/tables/field/" value="mysql">mysql</option>
                            <?php
                        }
                        if ($ismongodb) {
                            ?>
                            <option data-fields="mg/collections/select/"  data-link="mg/collections/field/" value="mongodb">mongodb</option> 

                            <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo __("backend/forms.form_title"); ?></td>
                <td><input type="text" name="title" class="form-control" required></td>
            </tr>
            <tr>
                <td><?php echo __("backend/forms.form_email"); ?></td>
                <td><input type="email" name="email" class="form-control" required></td>
            </tr>

            <tr>
                <td colspan="2"><strong><?php echo __("backend/forms.fields_in_form"); ?></strong>:</td>
            </tr>
            <tr class="tr_add_field">
                <td class="fields_list">
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
                    <a href="#" data-link="<?php if (!\core\ManagerConf::isOnlyMongodb()) { ?>content/tables/field/<?php } else { ?>mg/collections/field/<?php } ?>" data-next="0" class="btn btn-success addfield"><i class="fa fa-plus"></i> <?php echo __("backend/forms.field"); ?></a>
                </td>
            </tr>



            <tr><td><?php echo csrf_field(); ?></td>
                <td><button class="btn btn-danger btn_add_table" disabled  ><?php echo __("backend/forms.form_create"); ?></button></td>
            </tr>
        </table>
    </form>

</div>
