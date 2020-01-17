<ol class="breadcrumb">
    <li><a href="{pathadmin}params/index">Все параметры</a></li>
    <li><a href="{pathadmin}params/manage/<?php echo $param['name']; ?>"><?php echo $param['title']; ?></a></li>
    <li class="active">Редактирование</li>
</ol>
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


                </div>
            </div>
            <h2><?php echo $param['title']; ?></h2>

        </div>
        <?php
    }
    ?>

    <!-- END Example Title -->

    <!-- Example Content -->
    <form method="POST" action="{pathadmin}params/manage/doupdate/<?php echo $param['name']; ?>/<?php echo $last_id; ?>">
        <table class="table">

            <tbody>
                <?php
                foreach ($param['fields'] as $namefield => $field) {
                    $class = "\\content\\fields\\" . $field['type'];


                    $value = "";
                    if (isset($field['value'])) {
                        $value = $field['value'];
                    }
                    $onefield = new $class($value, $namefield);
                    ?>
                    <tr>
                        <td><?php echo $field['title']; ?></td>
                        <td><?php echo $onefield->get(); ?></td>
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
