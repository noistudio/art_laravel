<select class="form-control" name="<?php echo $name; ?>">
    <option value="main">Это главная категория</option>
    <?php
    if (count($rows)) {
        foreach ($rows as $row) {

            $selected = "";

            if (is_array($value) and isset($value['last_id']) and (int) $value['last_id'] == (int) $row['value']) {
                $selected = "selected";
            }
            ?>
            <option <?php echo $selected; ?> value="<?php echo $row['value'] ?>"><?php echo $row['title']; ?></option>
            <?php
        }
    }
    ?>
</select>
