<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2>Параметры</h2>
        <form action="{pathadmin}params/add" method="POST">
            <table class="table">
                <tr>
                    <td>Название(a-Z)</td>
                    <td><input type="text" name="name"  class="form-control" required></td>
                </tr>
                <tr>
                    <td>Заголовок</td>
                    <td><input type="text" name="title"  class="form-control" required></td>  
                </tr>
                <tr>
                    <td><input type="checkbox" name="isone"  value=1> Для одного?</td>
                    <td><button type="submit" class="btn btn-primary">Добавить</button>   <?php echo csrf_field(); ?></td>

                </tr>
            </table>
        </form>
    </div>
    <!-- END Example Title -->

    <!-- Example Content -->
    <table class="table">
        <thead>
            <tr>

                <th>Название</th>
                <th></th>
                <th></th>
                <th></th>


            </tr>
        </thead>
        <tbody>
            <?php
            if (count($rows)) {
                foreach ($rows as $key => $row) {
                    ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>

                        <td><a href="{pathadmin}params/manage/<?php echo $row['name']; ?>">Посмотреть</a></td>
                        <td><a class="btn btn-primary" href="{pathadmin}params/fields/index/<?= $key; ?>"><i class="fa fa-pencil-square-o"></i></a></td>
                        <td><a class="btn btn-primary" href="{pathadmin}params/delete/<?= $key; ?>"><i class="fa fa-remove"></i></a></td>

                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
    <?php echo $pages; ?>
</div>
