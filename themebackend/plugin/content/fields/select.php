<?php
$type = content\models\MasterTable::getType();
?>
<select class="form-control" name="<?php echo $name; ?>">
    <?php
    if (isset($type) and $type == "list") {
        ?>
        <option></option>
        <?php
    }

    if (count($rows)) {
        foreach ($rows as $row) {
            $selected = "";

            if ((int) $value == (int) $row['value']) {
                $selected = "selected";
            }
            ?>
            <option <?php echo $selected; ?> value="<?php echo $row['value'] ?>"><?php echo $row['title']; ?></option>
            <?php
        }
    }
    ?>
</select>
