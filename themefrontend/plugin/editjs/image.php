<?php
$style_css = "max-width: 100%;
    vertical-align: bottom;
    display: block;";
if (isset($stretched) and $stretched == true) {
    $style_css .= "width:100%;";
}
if (isset($withBorder) and $withBorder == true) {
    $style_css .= "border:20px;";
}
if (isset($file['url'])) {
    ?>
    <div class="row-f justify-content-center">

        <img src="<?php echo $file['url']; ?>" alt="Example blog post alt" class="img-fluid">

        <?php
        if (isset($caption) and is_string($caption) and strlen($caption) > 1) {
            ?>
            <h5 class="h2 font-weight-light mb-0"><?php echo $caption; ?></h5>

            <?php
        }
        ?>
    </div>


    <?php
}
?>
