<h4><?php echo __("backend/content.main_setup_block") ?></h4>

<?php
if (isset($languages)) {
    ?>
    <div class="well">
        <p><strong><?php echo __("backend/mg.choose_lng"); ?>:</strong>
            <a class="btn btn-primary <?php
            if ($lang == "null") {
                echo 'active';
            }
            ?>" href="?lang=null"><?php echo __("backend/mg.for_all"); ?></a>    
               <?php
               foreach ($languages as $language) {
                   ?>
                <a class="btn btn-primary <?php
                if ($lang == $language) {
                    echo 'active';
                }
                ?>" href="?lang=<?php echo $language; ?>"><?php echo $language; ?></a> 
                   <?php
               }
               ?></p>  
    </div>
    <?php
}
?>

<input type="hidden" name="lang" value="<?php echo $lang; ?>">
<table class="table">
    <tr>
        <td>HTML</td>
        <td>  
            <div id="editorjs" data-output-id="output_<?php echo $name; ?>" data-btn="editor_btn_<?php echo $name; ?>"></div>
            <button style="display:none;"  id="editor_btn_<?php echo $name; ?>" type="button" ></button>
            <textarea id="output_<?php echo $name; ?>" style="display:none;" name="param[<?php echo $name; ?>]"></textarea>
            <script>
<?php
if (isset($params) and isset($params[$name]) and is_array($params[$name]) and isset($params[$name]['blocks'])) {
    ?>

                    //                    var tmp_json = <?php echo json_encode($params[$name]['blocks']); ?>;
                    //                    console.log(tmp_json);
                    var editorjs_value = <?php echo json_encode($params[$name]['blocks']); ?>;
    <?php
} else {
    ?>
                    var editorjs_value = [];
<?php }
?>

                var additional_blocks =<?php echo json_encode($blocks); ?>;
            </script></td>
    </tr>
</table>

