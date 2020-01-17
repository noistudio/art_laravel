<ol class="breadcrumb">
    <li><a href="{pathadmin}params/index">Все параметры</a></li>
    <li class="active"><?php echo $param['title']; ?></li>
</ol>
<div class="block">

    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-left">
            <a class="btn btn-danger " href="{pathadmin}params/fields/<?php echo $param['name']; ?>">Поля </a>

        </div>
        <div class="block-options pull-right">
            <div class="btn-group">

                <a class="btn btn-danger" href="{pathadmin}params/manage/form/<?php echo $param['name']; ?>">Добавить </a>
            </div>
        </div>
        <h2><?php echo $param['title']; ?></h2>

    </div>

    <!-- END Example Title -->
    <h4>
        Получение всех значений
    </h4>
    <?php
    $code = "<?php echo \db\SqlDocument::all('" . $param['name'] . "');?>";
    $code = htmlspecialchars($code);
    ?>
    <blockquote >
        <?php echo $code; ?>
    </blockquote>

    <h4>
        Получение значения по ключу 1
    </h4>
    <?php
    $code = "<?php echo \db\SqlDocument::get('" . $param['name'] . "',1);?>";
    $code = htmlspecialchars($code);
    ?>
    <blockquote >
        <?php echo $code; ?>
    </blockquote>
    <!-- Example Content -->
    <table class="table">
        <thead>
            <tr>
                <th>Уровень</th>
                <?php
                foreach ($param['fields'] as $field) {
                    if ($field['showinlist'] == 1) {
                        ?>
                        <th><?php echo $field['title']; ?></th>
                        <?php
                    }
                }
                ?>
                <th></th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php
            if (count($all)) {
                foreach ($all as $key => $row) {
                    $new = $key + 1;
                    ?>
                    <tr>
                        <td><?php echo $new; ?></td>
                        <?php
                        foreach ($param['fields'] as $namefield => $field) {
                            if ($field['showinlist'] == 1) {

                                $value = "";
                                if (isset($row[$namefield])) {
                                    $value = $row[$namefield];
                                }
                                ?>
                                <th><?php echo $value; ?></th>
                                <?php
                            }
                        }
                        ?>
                        <td><a href="{pathadmin}params/manage/update/<?php echo $param['name']; ?>/<?php echo $key; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                        <td><a href="{pathadmin}params/manage/delete/<?php echo $param['name']; ?>/<?php echo $key; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>

</div>
