<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2><?php echo __("backend/menu.add_menu"); ?></h2>

    </div>
    <!-- END Example Title -->

    <form action="{pathadmin}menu/doadd" method="POST">
        <table class="table">
            <tr>
                <td><?php echo __("backend/menu.menu_title"); ?></td> 
                <td><input type="text" name="title" class="form-control" required  ></td>
            </tr>
            <tr>
                <td><?php echo csrf_field(); ?></td> 
                <td><button type="submit" class="btn btn-danger" ><?php echo __("backend/menu.add_menu"); ?></button></td>
            </tr>
        </table>
    </form>

</div>
