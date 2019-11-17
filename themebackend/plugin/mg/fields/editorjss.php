<div id="editorjs" data-output-id="output_<?php echo $name; ?>" data-btn="editor_btn_<?php echo $name; ?>"></div>
<button style="display:none;"  id="editor_btn_<?php echo $name; ?>" type="button" ></button>
<textarea id="output_<?php echo $name; ?>" style="display:none;" name="<?php echo $name; ?>"></textarea>
<script>
    var object_<?php echo $name; ?> = {name: "editorjs_<?php echo $name; ?>"};
<?php if (is_array($value) and isset($value['blocks'])) { ?>
        //var tmp_json = '<?php echo json_encode($value['blocks']); ?>';
        //   var editorjs_value = JSON.parse(tmp_json);
        var editorjs_value = <?php echo json_encode($value['blocks']); ?>;

        object_<?php echo $name; ?>.value =<?php echo json_encode($value['blocks']); ?>,
<?php } else {
    ?>
        object_<?php echo $name; ?>.value = [];
        var editorjs_value = [];
<?php }
?>

    object_<?php echo $name; ?>.blocks =<?php echo json_encode($blocks); ?>;


    // editorjs_configs.push(object_<?php echo $name; ?>);
</script>