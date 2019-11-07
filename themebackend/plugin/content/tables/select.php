<select class="form-control table_field" name="field" >
    <?php
    if (count($fields)) {
        foreach ($fields as $field) {
            ?>
            <option value="<?php echo $field['name']; ?>"><?php echo $field['title']; ?></option>
            <?php
        }
    }
    ?>
</select>