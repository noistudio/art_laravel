<select class="form-control" multiple="multiple" name="<?php echo $name; ?>[]">
    <?php
    if (isset($rows) and is_array($rows) and count($rows)) {
        foreach ($rows as $row) {
            $selected = "";

            if (isset($value['id_' . $row['value']])) {
                $selected = "selected";
            }
            ?>
            <option <?php echo $selected; ?> value="<?php echo $row['value'] ?>"><?php echo $row['title']; ?></option>
            <?php
        }
    }
    ?>
</select>
