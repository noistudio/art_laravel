<ol class="breadcrumb">
    <li><a href="{pathadmin}mg/collections/index"><?php echo __("backend/mg.all_collections"); ?></a></li>
    <li><a href="{pathadmin}mg/manage/<?php echo $collection['name']; ?>"><?php echo $collection['title']; ?></a></li>
    <li class="active"><?php echo __("backend/mg.template_list_documents"); ?></li>
</ol>

<div class="block">
    <!-- Example Title -->
    <div class="block-title">

        <h2><?php echo __("backend/mg.template_list_documents"); ?> </h2>
    </div>
    <!-- END Example Title -->


    <div class="row">
        <div class="col-md-4">
            <div class="widget-content themed-background-info text-light">
                <i class="fa fa-fw fa-sticky-note"></i> <strong><?php echo __("backend/mg.hints"); ?></strong>
            </div> 
            <?php
            if (count($collection['fields'])) {
                foreach ($collection['fields'] as $key => $field) {
                    $var = '$row["' . $key . '"]';
                    ?>
                    <div class="block">
                        <div class="block-title">
                            <h2 style="text-transform: lowercase;"><?php echo $var; ?></h2>
                        </div>
                        <p><?php echo __("backend/mg.field"); ?> <?php echo $field['title']; ?> </p>
                        <p><?php echo __("backend/mg.type"); ?> \mg\fields\<?php echo $field['type']; ?></p>
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
