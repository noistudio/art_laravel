<ol class="breadcrumb">
    <li><a href="{pathadmin}menu/index"><?php echo __("backend/menu.list"); ?></a></li>
    <li class="active"><?php echo $menu['title']; ?></li>
</ol>
<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo $menu['title']; ?></h2>

    </div>
    <ul class="nav nav-tabs">
        <li ><a href="{pathadmin}menu/update/<?php echo $menu['id']; ?>">  <?php echo __("backend/menu.edit_tab"); ?></i> </a></li>
        <li class="active"><a href="{pathadmin}menu/update/template/<?php echo $menu['id']; ?>"><i class="fa fa-html"></i> <?php echo __("backend/menu.template"); ?></a></li>


    </ul>
    <!-- END Example Title -->

    <!-- Example Content -->
    <h4><?php echo __("backend/menu.template_menu"); ?></h4>
    <div class="row">
        <div class="col-md-4">
            <div class="widget-content themed-background-info text-light">
                <i class="fa fa-fw fa-sticky-note"></i> <strong><?php echo __("backend/menu.hints"); ?></strong>
            </div> 
            <div class="block" >
                <div class="block-title">
                    <h2 style="text-transform: lowercase;">$link[' children_choose'];</h2>
                </div>
                <p><?php echo __("backend/menu.substatus_description"); ?></p>

            </div>
            <div class="block" >
                <div class="block-title">
                    <h2 style="text-transform: lowercase;">$link['choose'];</h2>
                </div>
                <p><?php echo __("backend/menu.status_description"); ?> </p>

            </div>
            <div class="block" >
                <div class="block-title">
                    <h2 style="text-transform: lowercase;">$link['target'];</h2>
                </div>
                <p><?php echo __("backend/menu.attr"); ?>  target </p>

            </div>
            <div class="block" >
                <div class="block-title">
                    <h2 style="text-transform: lowercase;">$link['link'];</h2>
                </div>
                <p><?php echo __("backend/menu.link_description"); ?> </p>

            </div>
            <div class="block" >
                <div class="block-title">
                    <h2 style="text-transform: lowercase;">$link['title'];</h2>
                </div>
                <p><?php echo __("backend/menu.title"); ?>  </p>

            </div>
            <div class="block" >
                <div class="block-title">
                    <h2 style="text-transform: lowercase;">$sublink['choose'];</h2>
                </div>
                <p><?php echo __("backend/menu.status_description"); ?></p>

            </div>
            <div class="block" >
                <div class="block-title">
                    <h2 style="text-transform: lowercase;">$sublink['target'];</h2>
                </div>
                <p><?php echo __("backend/menu.attr"); ?> target </p>

            </div>
            <div class="block" >
                <div class="block-title">
                    <h2 style="text-transform: lowercase;">$sublink['link'];</h2>
                </div>
                <p><?php echo __("backend/menu.link_description"); ?> </p>

            </div>
            <div class="block" >
                <div class="block-title">
                    <h2 style="text-transform: lowercase;">$sublink['title'];</h2>
                </div>
                <p><?php echo __("backend/menu.title"); ?>  </p>

            </div>



        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="widget-content themed-background text-light-op">
                    <i class="fa fa-fw fa-pencil"></i> <strong><?php echo $path_template; ?></strong>
                </div> 
                <textarea class="form-control" rows="20" readonly="readonly"><?php echo $template; ?></textarea>
            </div>



        </div>

    </div>

</div>
