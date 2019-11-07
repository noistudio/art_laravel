<?php
$nav = (string) core\AppConfig::get("nav");
$subnav = (string) core\AppConfig::get("subnav");
?>

<li class="<?php
if ($nav == "builder") {
    echo 'active';
}
?>">
    <a href="{pathadmin}builder/index"  ><i class="fa fa-building sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Конструктор</span></a>
</li>