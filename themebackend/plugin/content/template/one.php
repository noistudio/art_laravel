<ol class="breadcrumb">
    <li><a href="{pathadmin}content/tables/index"><?php echo __("backend/content.all_tables") ?></a></li>
    <li><a href="{pathadmin}content/manage/<?php echo $table['name']; ?>"><?php echo $table['title']; ?></a></li>
    <li class="active"><?php echo __("backend/content.template_one_document") ?></li>
</ol>

<div class="block">
    <!-- Example Title -->
    <div class="block-title">

        <h2><?php echo __("backend/content.template_one_document") ?> </h2>
    </div>
    <!-- END Example Title -->


    <div class="row">
        <div class="col-md-4">
            <div class="widget-content themed-background-info text-light">
                <i class="fa fa-fw fa-sticky-note"></i> <strong><?php echo __("backend/content.hints") ?></strong>
            </div> 

            <?php
            if (count($table['fields'])) {
                foreach ($table['fields'] as $key => $field) {
                    $var = '$document["' . $key . '_val"]';
                    ?>
                    <div class="block">
                        <div class="block-title">
                            <h2 style="text-transform: lowercase;"><?php echo $var; ?></h2>
                        </div>
                        <p><?php echo __("backend/content.field") ?> <?php echo $field['title']; ?> </p>
                        <p><?php echo __("backend/content.type") ?> \content\fields\<?php echo $field['type']; ?></p>
                    </div>
                    <?php
                }
            }
            ?>



        </div>
        <div class="col-md-8">
            <div class="widget-content themed-background text-light-op">
                <i class="fa fa-fw fa-pencil"></i> <strong><?php echo $path_template; ?></strong>
            </div> 
            <textarea class="form-control" rows="20" readonly="readonly"><?php echo $template; ?></textarea>
        </div>

    </div>

</div>
