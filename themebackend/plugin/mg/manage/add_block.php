<h4><?php echo __("backend/mg.block_setup"); ?></h4>
<table class="table">
    <tr>
        <td><?php echo __("backend/mg.call_with_dyn_params"); ?></td>
        <td><textarea class="form-control" readonly >[block{"id": <?php echo $block['id']; ?>,"fields":{"category":{"type":"=","value":"1"}}}] 
            </textarea></td>
    </tr>
    <tr>
        <td><?php echo __("backend/mg.postfix_template"); ?> </td>
        <td>
            <input type="text" name="{param}[postfix_template]" value="<?php echo $params['postfix_template']; ?>" class="form-control"/> 
        </td>

    </tr>

</table>
<div class="row">
    <div class="col-md-4">
        <div class="widget-content themed-background-info text-light">
            <i class="fa fa-fw fa-sticky-note"></i> <strong><?php echo __("backend/mg.hints"); ?></strong>
        </div> 
        <?php
        if (count($table['fields'])) {
            foreach ($table['fields'] as $key => $field) {
                $var = '$row["' . $key . '_val"]';
                ?>
                <div class="block">
                    <div class="block-title">
                        <h2 style="text-transform: lowercase;"><?php echo $var; ?></h2>
                    </div>
                    <p><?php echo __("backend/mg.field"); ?> <?php echo $field['title']; ?> </p>
                    <p><?php echo __("backend/mg.type"); ?> \content\fields\<?php echo $field['type']; ?></p>
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
<h4><?php echo __("backend/mg.setup_sort"); ?></h4>
<table class="table">
    <tr>
        <td><?php echo __("backend/mg.sort_by_field"); ?> (<?php echo $params['order_field']; ?>)</td>
        <td>
            <select name="{param}[order_field]" class="form-control">
                <option value="arrow_sort"><?php echo __("backend/mg.sort_by_pos"); ?></option> 
                <?php
                if (count($fields)) {
                    foreach ($fields as $name => $field) {
                        $selected = "";

                        if (isset($params['order_field']) and $params['order_field'] == $field['name']) {
                            $selected = "selected";
                        }
                        ?>
                        <option <?php echo $selected; ?> value="<?php echo $field['name']; ?>"><?php echo $field['title'] ?></option> 
                        <?php
                    }
                }
                ?>


            </select>
        </td>

    </tr>
    <tr>
        <td><?php echo __("backend/mg.sort_type"); ?> </td>
        <td>
            <select name="{param}[order_type]" class="form-control">
                <option <?php
                if (isset($params['order_type']) and $params['order_type'] == "asc") {
                    echo "selected";
                }
                ?> value="asc"><?php echo __("backend/mg.sort_asc"); ?></option> 
                <option <?php
                if (isset($params['order_type']) and $params['order_type'] == "desc") {
                    echo "selected";
                }
                ?> value="desc"><?php echo __("backend/mg.sort_desc"); ?></option> 



            </select>
        </td>

    </tr>

</table>
<h4><?php echo __("backend/mg.setup_select"); ?></h4>
<table class="table">
    <tr>
        <td><input name="{param}[conditions][]" <?php
            if (isset($params['conditions']) and is_array($params['conditions']) and in_array("table_limit", $params['conditions']) === true) {
                echo 'checked';
            }
            ?> value="table_limit" type="checkbox"  ></td>
        <td><?php echo __("backend/mg.block_limit"); ?> </td>
        <td></td>

        <td><input type="number" value="<?php
            if (isset($params['table_limit'])) {
                echo $params['table_limit'];
            }
            ?>" class="form-control" name="{param}[table_limit]"></td>
    </tr>   
    <?php
    if (count($fields)) {
        foreach ($fields as $field_name => $field) {
            if ($field['showsearch'] == 1) {
                ?>
                <tr>
                    <td><?php
                ?><input name="{param}[conditions][]" <?php
                        if (isset($params['conditions']) and is_array($params['conditions']) and in_array($field['name'], $params['conditions']) === true) {
                            echo 'checked';
                        }
                        ?> value="<?php echo $field['name']; ?>" type="checkbox"  ></td>
                    <td><?php echo $field['title']; ?></td>
                    <td> 
                        <select class="form-control" name="{param}[type_<?php echo $field['name']; ?>]">
                            <option <?php
                            if (isset($params['fields'][$field['name']]['type']) and $params['fields'][$field['name']]['type'] == "=") {
                                echo 'selected';
                            }
                            ?> value='='><?php echo __("backend/mg.op_="); ?></option>
                            <option <?php
                            if (isset($params['fields'][$field['name']]['type']) and $params['fields'][$field['name']]['type'] == "LIKE") {
                                echo 'selected';
                            }
                            ?> value='LIKE'><?php echo __("backend/mg.op_LIKE"); ?></option>
                            <option <?php
                            if (isset($params['fields'][$field['name']]['type']) and $params['fields'][$field['name']]['type'] == ">=") {
                                echo 'selected';
                            }
                            ?> value='>='><?php echo __("backend/mg.op_>="); ?></option>
                            <option <?php
                            if (isset($params['fields'][$field['name']]['type']) and $params['fields'][$field['name']]['type'] == "<=") {
                                echo 'selected';
                            }
                            ?> value='<='><?php echo __("backend/mg.op_<="); ?></option>
                            <option <?php
                            if (isset($params['fields'][$field['name']]['type']) and $params['fields'][$field['name']]['type'] == "!=") {
                                echo 'selected';
                            }
                            ?> value='!='><?php echo __("backend/mg.op_!="); ?></option>
                        </select>
                    </td>
                    <td><?php echo $field['input']; ?></td>
                </tr>   
                <?php
            }
        }
    }
    ?>

</table>