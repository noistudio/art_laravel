<select class="form-control" name="<?php echo $name; ?>[]" multiple="multiple">
    <?php
    if (count($rows)) {
        foreach ($rows as $row) {
            $selected = "";

            if (isset($values['id_' . $row['value']])) {
                $selected = "selected";
            }
            ?>
            <option <?php echo $selected; ?> value="<?php echo $row['value'] ?>"><?php echo $row['title']; ?></option>
            <?php
        }
    }
    ?>
</select>
