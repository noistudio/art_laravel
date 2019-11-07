<ol class="breadcrumb">
    <li><a href="{pathadmin}routes/index"><?php echo __("backend/routes.list"); ?></a></li>
    <li class="active"><?php echo __("backend/routes.add"); ?></li>
</ol>
<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo __("backend/routes.add"); ?></h2>
    </div>
    <!-- END Example Title -->


    <!-- Example Content -->
    <form enctype="multipart/form-data" action='{pathadmin}routes/add/doadd' method="POST">
        <table class="table">
            <tbody>
                <tr>
                    <td><?php echo __("backend/routes.old_link"); ?> </td>
                    <td><input type="text" name="old_link" class="form-control"  required value="">
                    </td>
                </tr>
                <tr>
                    <td><?php echo __("backend/routes.new_link"); ?> </td>
                    <td><input type="text" name="new_link" class="form-control"  required value="">
                    </td>
                </tr>

                <tr>
                    <td><?php echo __("backend/routes.meta_title"); ?> </td>
                    <td><input type="text" name="meta_title" class="form-control"  required value="">
                    </td>
                </tr>

                <tr>
                    <td><?php echo __("backend/routes.meta_description"); ?></td>
                    <td><textarea class="form-control " required name="meta_description" name="content" rows=10>

                        </textarea>
                    </td>
                </tr>
                <tr>
                    <td><?php echo __("backend/routes.meta_keywords"); ?> </td>
                    <td><textarea class="form-control " required name="meta_keywords" name="content" rows=10>

                        </textarea>
                    </td>
                </tr>






                <tr>
                    <td></td>
                    <td><button type="submit" class="btn btn-warning"><i class="fa fa-floppy-o"></i> <?php echo __("backend/routes.add_btn"); ?></button></td>

                </tr>

            </tbody>
        </table>
        <?php
        echo csrf_field();
        ?>

    </form>

</div>
