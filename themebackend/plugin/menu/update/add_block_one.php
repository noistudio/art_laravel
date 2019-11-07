<h4><?php echo __("backend/menu.block_setup"); ?></h4>

<table class="table">

    <tr>
        <td><?php echo __("backend/menu.postfix"); ?> </td>
        <td>
            <input type="text" name="{param}[postfix_template]" value="<?php echo $params['postfix_template']; ?>" class="form-control"/> 
        </td>

    </tr>
</table>
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
            <p><?php echo __("backend/menu.substatus_description"); ?> </p>

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
            <p><?php echo __("backend/menu.attr"); ?> target </p>

        </div>
        <div class="block" >
            <div class="block-title">
                <h2 style="text-transform: lowercase;">$link['link'];</h2>
            </div>
            <p><?php echo __("backend/menu.link_description"); ?></p>

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
            <p><?php echo __("backend/menu.status_description"); ?> </p>

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