<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php
        if (is_array($prev)) {
            ?>
            <li>
                <a href="<?= $prev['offset']; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php
        }
        ?>

        <?php
        if (count($prev_pages)) {
            foreach ($prev_pages as $arr) {
                ?>
                <li><a href="<?= $arr['offset']; ?>"><?= $arr['page']; ?></a></li>
                <?php
            }
        }
        ?>
        <li class="active"><a href="#"><?= $current_page ?></a></li>
            <?php
            if (count($next_pages)) {
                foreach ($next_pages as $arr) {
                    ?>
                <li><a href="<?= $arr['offset']; ?>"><?= $arr['page']; ?></a></li>
                <?php
            }
        }
        ?>

        <?php
        if (is_array($next)) {
            ?>
            <li>
                <a href="<?= $next['offset']; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
            <?php
        }
        ?>
    </ul>
</nav>
