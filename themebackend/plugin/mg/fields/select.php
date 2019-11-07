<select class="form-control" name="<?php echo $name; ?>">
    <?php
    if (isset($rows) and is_array($rows) and count($rows)) {
        foreach ($rows as $row) {
            $selected = "";

            if (isset($value['last_id']) and (int) $value['last_id'] == (int) $row['value']) {
                $selected = "selected";
            }
            ?>
            <option <?php echo $selected; ?> value="<?php echo $row['value'] ?>"><?php echo $row['title']; ?></option>
            <?php
        }
    }
    ?>
</select>
