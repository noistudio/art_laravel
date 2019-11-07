<div class="block">
    <!-- Example Title -->
    <div class="block-title">
        <div class="block-options pull-right">
            <div class="btn-group">


            </div>
        </div>
        <h2>Мультиязычность</h2>

    </div>


    <!-- END Example Title -->

    <table class="table">
        <thead>
            <tr>
                <th>Язык</th>
                <th>Директория c фразами</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($languages)) {
                foreach ($languages as $lang) {
                    $path = base_path("resources/lang/" . $lang);
                    ?>
                    <tr>
                        <td><?php echo $lang; ?></td>
                        <td><?php echo $path; ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>

</div>
