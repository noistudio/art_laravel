<div class="block">
    <div class="block-title">
        <div class="block-options pull-right">

        </div>
        <h2><?php echo $form['title']; ?></h2>
    </div>

    <ul class="nav nav-tabs">
        <li ><a href="{pathadmin}forms/manage/<?php echo $form['id']; ?>"><i class="fa fa-envelope"></i> <?php echo __("backend/forms.messages"); ?></a></li>
        <li ><a href="{pathadmin}forms/manage/setup/<?php echo $form['id']; ?>"><i class="fa fa-cog"></i> <?php echo __("backend/forms.setup"); ?></a></li>
        <li  ><a href="{pathadmin}forms/manage/template/<?php echo $form['id']; ?>"><i class="fa fa-html"></i> <?php echo __("backend/forms.template_form"); ?></a></li>
        <li class="active"><a href="{pathadmin}forms/manage/templateemail/<?php echo $form['id']; ?>"><i class="fa fa-html"></i> <?php echo __("backend/forms.template_email"); ?></a></li>
    </ul>
    <!-- Example Content -->


    <h4><?php echo __("backend/forms.template_email"); ?></h4>
    <div class="alert alert-warning">
        <p><?php echo __("backend/forms.template_email_notice"); ?></p>
        <p><?php echo $path_php_notify; ?></p>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="widget-content themed-background-info text-light">
                <i class="fa fa-fw fa-sticky-note"></i> <strong><?php echo __("backend/forms.hints"); ?></strong>
            </div> 
            <?php
            if (count($form['fields'])) {
                foreach ($form['fields'] as $key => $field) {
                    $var = '{%' . $key . '%}';
                    ?>
                    <div class="block" >
                        <div class="block-title">
                            <h2 style="text-transform: lowercase;"><?php echo $var; ?></h2>
                        </div>
                        <p><?php echo __("backend/forms.field_val"); ?> <?php echo $field['title']; ?> </p>

                    </div>
                    <?php
                }
            }
            ?>
            <div class="block" >
                <div class="block-title">
                    <h2 style="text-transform: lowercase;">{%date_register%}</h2>
                </div>
                <p><?php echo __("backend/forms.field_val"); ?> <?php echo __("backend/forms.field_date_create"); ?></p>

            </div>



        </div>
        <div class="col-md-8">
            <form action="{pathadmin}forms/manage/savenotify/<?php echo $form['id']; ?>" method="POST">
                <textarea name="notify" class="form-control tiny" rows="20" ><?php echo $form['notify']; ?></textarea>
                <p>&nbsp;</p>
                <?php echo csrf_field(); ?>
                <p class=""><button class="btn btn-primary" type="submit" ><?php echo __("backend/forms.save_btn"); ?> </button></p>
            </form>

        </div>

    </div>
</div>
