<div class="jumbotron">
    <?php
    if (isset($meta['title'])) {
        ?>
        <p><?php echo $meta['title']; ?></p>
        <?php
    }
    ?>
    <?php
    if (isset($meta['keywords'])) {
        ?>
        <p><?php echo $meta['keywords']; ?></p>
        <?php
    }
    ?>
    <?php
    if (isset($meta['description'])) {
        ?>
        <p><?php echo $meta['description']; ?></p>
        <?php
    }
    ?>
    <p><a class="btn btn-primary btn-lg" target="_blank" href="<?php echo $link; ?>" role="button"><?php echo $link; ?></a></p>
</div>
