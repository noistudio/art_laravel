<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingTwo">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <?php echo __("backend/routes.setup_seo_url"); ?> <?php echo $route['old_url']; ?>        </a>
            </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
                <div class="notify_route"></div>
                <div class="alert alert-warning">
                    <a class="btn btn-primary" target="_blank" href="<?php echo $route['old_url']; ?>"><?php echo __("backend/routes.redirect_to"); ?> <?php echo $route['old_url']; ?></a>  
                    <form enctype="multipart/form-data" class="route_update"  data-url="<?php echo $route['old_url']; ?>"   method="POST">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><?php echo __("backend/routes.old_link"); ?> </td>
                                    <td><input type="text" name="old_link" readonly class="form-control"  required value="<?php echo $route['old_url']; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo __("backend/routes.new_link"); ?> </td>
                                    <td><input type="text" name="new_link" class="form-control"  required value="<?php echo $route['new_url']; ?>">
                                    </td>
                                </tr>

                                <tr>
                                    <td><?php echo __("backend/routes.meta_title"); ?> </td>
                                    <td><input type="text" name="meta_title" class="form-control"  required value="<?php echo $route['title']; ?>">
                                    </td>
                                </tr>

                                <tr>
                                    <td><?php echo __("backend/routes.meta_description"); ?> </td>
                                    <td><textarea class="form-control " required name="meta_description" name="content" rows=3><?php echo $route['meta_description']; ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo __("backend/routes.meta_keywords"); ?> </td>
                                    <td><textarea class="form-control " required name="meta_keywords" name="content" rows=3><?php echo $route['meta_keywords']; ?></textarea>
                                    </td>
                                </tr>






                                <tr>
                                    <td></td>
                                    <td><button type="submit" class="btn btn-warning"><i class="fa fa-floppy-o"></i> <?php echo __("backend/routes.change_btn"); ?></button></td>

                                </tr>

                            </tbody>
                        </table>

                        <input type="hidden" name="_token" class="block_csrf_need" value="" >
                    </form>
                </div>
            </div>
        </div>
    </div>




</div>
