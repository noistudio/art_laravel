<select class="form-control" name="<?php echo $name; ?>">
    <option <?php
    if ($value == "percent") {
        echo 'selected';
    }
    ?> value="percent">Процент</option>
    <option <?php
    if ($value == "number") {
        echo 'selected';
    }
    ?> value="number">Число</option>
</select>
