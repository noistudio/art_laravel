<?php
if (!(isset($param['limit']) and $param['limit'] == 1)) {
    ?>
    <ol class="breadcrumb">
        <li><a href="{pathadmin}params/index">Все параметры</a></li>
        <li><a href="{pathadmin}params/manage/<?php echo $param['name']; ?>"><?php echo $param['title']; ?></a></li>
        <li class="active">Создание</li>
    </ol>
    <?php
}
?>
<div class="block">

    <!-- Example Title -->
    <?php
    if (file_exists($controller->path($param['name'] . "_head.php"))) {
        echo $controller->render($param['name'] . "_head.php", array());
    } else {
        ?>
        <div class="block-title">
            <div class="block-options pull-right">
                <div class="btn-group">
                    <a class="btn btn-danger" href="{pathadmin}params/fields/<?php echo $param['name']; ?>">Поля </a>


                </div>
            </div>
            <h2><?php echo $param['title']; ?></h2>

        </div>
        <?php
    }
    ?>
    <h4>
        Получение значения 
    </h4>
    <?php
    $code = "<?php echo \db\SqlDocument::get('" . $param['name'] . "',0);?>";
    $code = htmlspecialchars($code);
    ?>
    <blockquote >
        <?php echo $code; ?>
    </blockquote>
    <!-- END Example Title -->

    <!-- Example Content -->
    <form method="POST" action="{pathadmin}params/manage/add/<?php echo $param['name']; ?>">
        <table class="table">

            <tbody>
                <?php
                foreach ($param['fields'] as $namefield => $field) {
                    $class = "\\content\\fields\\" . $field['type'];

                    $value = "";
                    if (isset($field['value'])) {
                        $value = $field['value'];
                    }
                    $obj = new $class($value, $namefield);
                    ?>
                    <tr>
                        <td><?php echo $field['title']; ?></td>
                        <td><?php echo $obj->get(); ?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td><?php echo csrf_field(); ?></td>
                    <td><input class="btn btn-danger" type="submit" value="Обновить данные"></td>
                </tr>
            </tbody>
        </table>
    </form>

</div>
