<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Главная</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $document['title']; ?></li>
    </ol>
</nav>

<div class="container">
    <h2><?php echo $document['title']; ?></h2>

    <?php
    echo $document['content_full'];
    ?>
</div>

