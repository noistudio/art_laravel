<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">
                <ol class="breadcrumb">
                    <li><a href="{pathadmin}index"><i class="fa fa-home"></i></a></li>
                    <li><a href="{pathadmin}params/manage/<?php echo $param['name']; ?>"><?php echo $param['title']; ?></a></li>
                    <li><a href="#">Настройка</a></li>
                </ol>


            </div>
        </div>
        <h2>Настройка </h2>

    </div>
    <!-- END Example Title -->


    <form  method="POST" action="{pathadmin}params/fields/add/<?php echo $param['last_id']; ?>">
        <table class="table">
            <tr>
                <td>Title</td>
                <td><input type="text" name="field_title" class="form-control input-sm"></td>
            </tr>

            <tr>
                <td>
                    Name
                </td>
                <td><input type="text" name="name" class="form-control"></td>
            </tr>

            <tr>
                <td>Type</td>
                <td> <select class="form-control" name="type" >
                        <?php
                        if (count($fields)) {
                            foreach ($fields as $field) {
                                ?>
                                <option value="<?php echo $field['name']; ?>"><?php echo $field['title']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td>Multilang</td>
                <td><input type="checkbox" name="multilang" value="1"></td>
            </tr>
            <tr>
                <td>Required</td>
                <td><input type="checkbox" name="required" value="1"></td>
            </tr>
            <tr>
                <td>Unique</td>
                <td><input type="checkbox" name="unique"></td>
            </tr>
            <tr>
                <td>Default value</td>
                <td><input type="text" name="field_value" class="form-control input-sm"></td>
            </tr>
            <tr>
                <td>Show in list</td>
                <td><input type="checkbox" name="showinlist" value="1"></td>
            </tr>
            <tr>
                <td>Options(JSON)</td>
                <td><textarea  class="form-control" name="json"></textarea></td>
            </tr>
            <tr>
                <td><?php echo csrf_field(); ?></td>
                <td><input type="submit" class="btn btn-submit" value="Add Field"></td>
            </tr>
        </table>
    </form>
    <h4>Список полей</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Name</th>
                <th></th>

            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($param['fields']) and is_array($param['fields']) and count($param['fields']) > 0) {
                foreach ($param['fields'] as $key => $field) {
                    ?>
                    <tr>
                        <td><?= $field['title']; ?></td>
                        <td><?= $key; ?></td>
                        <td><a href="{pathadmin}params/fields/delete/<?php echo $param['last_id']; ?>/<?php echo $key; ?>">Delete</a></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>

</div>
