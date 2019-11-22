<?php
if (isset($items) and is_array($items) and count($items) > 0) {
    if ($style == "ordered") {
        ?>
        <ol>
            <?php
            foreach ($items as $item) {
                ?>
                <li><?php echo $item; ?></li>
                <?php
            }
            ?>
        </ol>
        <?php
    } else {
        ?>
        <ul>
            <?php
            foreach ($items as $item) {
                ?>
                <li><?php echo $item; ?></li>
                <?php
            }
            ?>
        </ul>
        <?php
    }
}
