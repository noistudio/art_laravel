<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">
                <?php
                if (\admins\models\AdminAuth::have("forms_create")) {
                    ?>
                    <a href="{pathadmin}forms/add" class="btn btn-success"><?php echo __("backend/forms.form_add_title"); ?></a>
                    <?php
                }
                ?>

            </div>
        </div>
        <h2><?php echo __("backend/forms.allforms"); ?></h2>
    </div>
    <!-- END Example Title -->

    <!-- Example Content -->
    <table class="table">
        <thead>
            <tr>
                <th><?php echo __("backend/forms.form_title"); ?></th>



                <th></th>



            </tr>
        </thead>
        <tbody>
            <?php
            if (count($rows)) {
                foreach ($rows as $row) {
                    ?>
                    <tr>
                        <td><a class="btn btn-primary" href="{pathadmin}forms/manage/<?php echo $row->id; ?>"><?php echo $row->title; ?></a></td>


                        <th>
                            <?php
                            if (\admins\models\AdminAuth::have("block_delete")) {
                                ?>
                                <form action="{pathadmin}forms/delete" method="POST">
                                    <input type="hidden" name="form_id" value="<?php echo $row->id; ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit"     data-msg="<?php echo __("backend/forms.want_delete_form", ["name" => $row->title]); ?>" class="deleteerror btn btn-danger"><?php echo __("backend/forms.form_delete"); ?></button>  
                                </form>

                                <?php
                            }
                            ?>
                        </th>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>

</div>
