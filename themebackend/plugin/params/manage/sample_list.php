<div class="block">

                           <!-- Example Title -->
                           <div class="block-title">
                               <div class="block-options pull-right">
                                    <div class="btn-group">
<a class="btn btn-danger" href="{pathadmin}params/manage/form/<?php echo $param['name'];?>">Добавить </a>
                                   </div>
                               </div>
                               <h2>Слайдерная слайдерка</h2>

                           </div>

                           <!-- END Example Title -->

                           <!-- Example Content -->
                          <table class="table">
                          <thead>
                          <?php
                          foreach ($param['fields'] as $field) {
                              if ($field['showinlist']==1) {
                                  ?>
                          <th><?php echo $field['title']; ?></th>
                          <?php

                              }
                          }
                          ?>
                          <th></th>
                          <th></th>
                          </thead>

                          <tbody>
                          <?php
                          if (count($all)) {
                              foreach ($all as $key=>$row) {
                                  ?>
                          <tr>
                            <?php
                            foreach ($param['fields'] as $namefield=>$field) {
                                if ($field['showinlist']==1) {
                                    $value="";
                                    if (isset($row[$namefield])) {
                                        $value=$row[$namefield];
                                    } ?>
                            <th><?php echo $value; ?></th>
                            <?php

                                }
                            } ?>
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
