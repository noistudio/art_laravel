<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal<?php echo $name; ?>">
    <?php echo $modal_btn; ?>
</button>

<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="myModal<?php echo $name; ?>" tabindex="-1" role="dialog" aria-labelledby="myModal<?php echo $name; ?>Label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $modal; ?></h4>
            </div>
            <div class="modal-body">
                <table class="table  ">
                    <tr  >     
                        <?php
                        if (isset($fields) and is_array($fields) and count($fields)) {
                            foreach ($fields as $field) {
                                ?>
                                <td><?php echo $field['title']; ?></td>
                                <?php
                            }
                        }
                        ?>

                        <td></td>
                    </tr>

                    <?php
                    if (isset($value) and is_array($value) and count($value)) {
                        foreach ($value as $key => $arr) {
                            ?>  <tr class="parent">
                            <?php
                            foreach ($arr as $name => $html) {
                                ?>

                                    <td><?php echo $html; ?></td>




                                    <?php
                                }
                                ?>
                                <td> <a href="#" class="dynamic_delete">[x]</a></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>

                <p class="additional_<?php echo $name; ?>"></p>
                <div class="field_example_<?php echo $name; ?>" style="display:none;">

                    <table class="parent table" >
                        <?php
                        if (isset($fields) and is_array($fields) and count($fields)) {
                            foreach ($fields as $field => $val) {
                                ?>
                                <tr >
                                    <td><?php echo $val['title']; ?></td>
                                    <td><?php echo $val['html']; ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>



                        <tr>
                            <td></td>
                            <td> <a href="#" class="dynamic_delete">[x]</a></td>
                        </tr>      




                        </tr>
                    </table>


                </div>
                <p ><a href="#" class="btn btn-primary btnajaxadd" data-result=".additional_<?php echo $name; ?>" data-selector=".field_example_<?php echo $name; ?>" data-name="<?php echo $name; ?>"><?php echo $add; ?></a></p>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>

        </div>
    </div>
</div>
</div>





