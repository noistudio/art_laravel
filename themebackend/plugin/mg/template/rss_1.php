<ol class="breadcrumb">
    <li><a href="{pathadmin}mg/collections/index">Все коллекции</a></li>
    <li><a href="{pathadmin}mg/manage/<?php echo $this->collection['name']; ?>"><?php echo $this->collection['title']; ?></a></li>
    <li class="active">Шаблон rss лента</li>
</ol>

<div class="block">
    <!-- Example Title -->
    <div class="block-title">

        <h2>Шаблон rss лента </h2>
    </div>
    <!-- END Example Title -->

    <div class="well alert alert-warning">
        <p>Адрес rss ленты</p>
        <p>http://<?php echo $_SERVER['HTTP_HOST']; ?>/mg/rss/<?php echo $this->collection['name']; ?></p>

    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="widget-content themed-background-info text-light">
                <i class="fa fa-fw fa-sticky-note"></i> <strong>Подсказки</strong>
            </div> 
            <?php
            if (count($this->collection['fields'])) {
                foreach ($this->collection['fields'] as $key => $field) {
                    $var = '$row["' . $key . '"]';
                    ?>
                    <div class="block">
                        <div class="block-title">
                            <h2 style="text-transform: lowercase;"><?php echo $var; ?></h2>
                        </div>
                        <p>поле <?php echo $field['title']; ?> </p>
                        <p>тип \mg\fields\<?php echo $field['type']; ?></p>
                    </div>
                    <?php
                }
            }
            ?>



        </div>
        <div class="col-md-8">
            <div class="widget-content themed-background text-light-op">
                <i class="fa fa-fw fa-pencil"></i> <strong><?php echo $this->path_template; ?></strong>
            </div> 
            <textarea class="form-control" rows="20" readonly="readonly"><?php echo $this->template; ?></textarea>
        </div>

    </div>

</div>
