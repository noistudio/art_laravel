var editor_options={

holder: 'editorjs',
placeholder:'<?php echo __("backend/editjs.placeholder"); ?>',

tools: {
<?php
if (count($blocks)) {
    foreach ($blocks as $name => $block) {
        ?>
        <?php echo $name; ?>:<?php echo $name; ?>,
        <?php
    }
}
?>
paragraph: Paragraph, 
delimiter: Delimiter,
warning: Warning,
header: {
class: Header,

config: {
placeholder: 'Header'
},
shortcut: 'CMD+SHIFT+H'
},
linkTool: {
class: LinkTool,
config: {
endpoint:$("#pathadmin").data("link-fetchurl"), // Your backend endpoint for url data fetching
}
},
image: {
class: ImageTool,

config: {
endpoints: {
byFile: $("#pathadmin").data("file-upload"), // Your backend file uploader endpoint
// Your endpoint that provides uploading by Url
}
}

},

list: {
class: List,
inlineToolbar: true,
shortcut: 'CMD+SHIFT+L'
},

quote: {
class: Quote,
inlineToolbar: true,
config: {
quotePlaceholder: 'Enter a quote',
captionPlaceholder: 'Quote\'s author'
},
shortcut: 'CMD+SHIFT+O'
},


embed: Embed,

table: {
class: Table,
inlineToolbar: true,
shortcut: 'CMD+ALT+T'
},


},



}
