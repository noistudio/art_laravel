<?php
if (isset($content) and is_array($content) and count($content) > 0) {
    ?>
    <table class="table">
        <?php
        foreach ($content as $cont) {
            ?>
            <tr>
                <?php
                if (count($cont)) {
                    foreach ($cont as $row) {
                        ?>
                        <td><?php echo $row; ?></td>
                        <?php
                    }
                }
                ?>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
}
?>
