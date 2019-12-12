/**
* @typedef {Object} HeaderData
* @description Tool's input and output data format
* @property {String} text — Header's content
* @property {number} level - Header's level from 1 to 3
*/

/**
* @typedef {Object} HeaderConfig
* @description Tool's config from Editor
* @property {string} placeholder — Block's placeholder
*/

/**
* Header block for the Editor.js.
*
* @author CodeX (team@ifmo.su)
* @copyright CodeX 2018
* @license The MIT License (MIT)
* @version 2.0.0
*/
class <?php echo $block['name']; ?> {
/**
* Render plugin`s main Element and fill it with saved data
*
* @param {{data: HeaderData, config: HeaderConfig, api: object}}
*   data — previously saved data
*   config - user config for Tool
*   api - Editor.js API
*/
constructor({data, config, api}) {
this.api = api;

/**
* Styles
* @type {Object}
*/
this._CSS = {
block: this.api.styles.block,
settingsButton: this.api.styles.settingsButton,
settingsButtonActive: this.api.styles.settingsButtonActive,
wrapper: 'ce-block_div',
};

/**
* Tool's settings passed from Editor
* @type {HeaderConfig}
* @private
*/
this._settings = config;

/**
* Block's data
* @type {HeaderData}
* @private
*/
this._data = this.normalizeData(data);

/**
* List of settings buttons
* @type {HTMLElement[]}
*/
this.settingsButtons = [];

this.vars=[];
this.images=[];
/**
* Main Block wrapper
* @type {HTMLElement}
* @private
*/
this._element = this.getTag();
}

/**
* Normalize input data
* @param {HeaderData} data
* @return {HeaderData}
* @private
*/
normalizeData(data) {

const newData = {};

if (typeof data !== 'object') {
data = {};
}


<?php
if (isset($block['vars']) and count($block['vars']) > 0) {
    foreach ($block['vars'] as $key => $var) {
        $name_var = "key" . $key;
        ?>
        newData.<?php echo $name_var; ?> = data.<?php echo $name_var; ?> || ''
        <?php
    }
}
if (isset($block['texts']) and count($block['texts']) > 0) {
    foreach ($block['texts'] as $key => $var) {
        $name_var = "textkey" . $key;
        ?>
        newData.<?php echo $name_var; ?> = data.<?php echo $name_var; ?> || ''
        <?php
    }
}
if (isset($block['images']) and count($block['images']) > 0) {
    foreach ($block['images'] as $key => $var) {
        $name_var = "imgkey" . $key;
        ?>
        newData.<?php echo $name_var; ?> = data.<?php echo $name_var; ?> || ''
        <?php
    }
}
?>
console.log("new data");
console.log(newData);

return newData;
}

/**
* Return Tool's view
* @returns {HTMLHeadingElement}
* @public
*/
render(){
var div=document.createElement('div');
div.classList.add("alert");
div.classList.add("alert-info");
div.innerHTML="<p><strong><?php echo $block['title']; ?></strong></p><p><a  class='btn btn-danger' href='<?php echo route('backend/blocks/update', $block['id']); ?>' target='_blank'>Настройка блока</a></p>";
console.log(this.data);
<?php
if (isset($block['vars']) and is_array($block['vars']) and count($block['vars']) > 0) {
    foreach ($block['vars'] as $key => $var) {
        $name_var = "key" . $key;
        ?>
        this.vars.push("<?php echo $name_var; ?>");
        var val_tmp="";
        if(typeof this.data.<?php echo $name_var ?> != 'undefined'){
        val_tmp=this.data.<?php echo $name_var ?>;
        }
        var tmp_el="<h4><?php echo $var; ?></h4><input class='form-control' type='text' value='"+val_tmp+"' placeholder='<?php echo $var; ?>' id='<?php echo $name_var; ?>'>"
        div.innerHTML=div.innerHTML+tmp_el;
        <?php
    }
}
?>
<?php
if (isset($block['texts']) and count($block['texts'])) {
    foreach ($block['texts'] as $key => $var) {
        $name_var = "textkey" . $key;
        ?>
        this.vars.push("<?php echo $name_var; ?>");
        var val_tmp="";
        if(typeof this.data.<?php echo $name_var ?> != 'undefined'){
        val_tmp=this.data.<?php echo $name_var ?>;
        }
        var tmp_el="<h4><?php echo $var; ?></h4><textarea class='form-control  p_textarea ' contenteditable='true' data-placeholder='<?php echo $var; ?>'  id='<?php echo $name_var; ?>' spellcheck='false' data-gramm='false'>"+val_tmp+"</textarea>";
        div.innerHTML=div.innerHTML+tmp_el;
        <?php
    }
}
?>    
<?php
if (isset($block['images']) and count($block['images']) > 0) {
    foreach ($block['images'] as $key => $var) {

        $name_var = "imgkey" . $key;
        ?>
        this.images.push("<?php echo $name_var; ?>");
        var val_tmp="";
        if(typeof this.data.img<?php echo $name_var ?> != 'undefined'){
        val_tmp=this.data.img<?php echo $name_var ?>;
        }
        var tmp_el="<a onclick='load_editor_image(this);'   name='<?php echo $name_var; ?>' class='btn_img_<?php echo $name_var; ?> choose_file_editjs btn btn-success'><?php echo __("backend/editjs.select"); ?> <?php echo $var; ?></a>"

        div.innerHTML=div.innerHTML+tmp_el;
        <?php
    }
    ?>
    var images=div.querySelectorAll('.choose_file_editjs');

    if(images.length>0){
    for (var i = 0; i < images.length; ++i) {
    var name=images[i].name;

    console.log(name);
    if(typeof this.data[name]!= 'undefined' && this.data[name].length>0){

    images[i].innerHTML="<b name='"+name+"'  data-name='"+name+"' class='file_val'>"+this.data[name]+"</b>"

    }

    }
    }
    <?php
}
?>    

return div;
}

/**
* Create Block's settings block
*
* @return {HTMLElement}
*/


/**
* Callback for Block's settings buttons
* @param level
*/
setLevel(level) {
this.data = {

};

/**
* Highlight button by selected level
*/
this.settingsButtons.forEach(button => {

});
}

/**
* Method that specified how to merge two Text blocks.
* Called by Editor.js by backspace at the beginning of the Block
* @param {HeaderData} data
* @public
*/
merge(data) {
let newData = {
text: this.data.text + data.text,
level: this.data.level
};

this.data = newData;
}

/**
* Validate Text block data:
* - check for emptiness
*
* @param {HeaderData} blockData — data received after saving
* @returns {boolean} false if saved data is not correct, otherwise true
* @public
*/
validate(savedData){


return true;
}

/**
* Extract Tool's data from the view
* @param {HTMLHeadingElement} toolsContent - Text tools rendered view
* @returns {HeaderData} - saved data
* @public
*/
save(toolsContent) {
var result={};
var input = toolsContent.querySelectorAll('input');
if(input.length>0){
for (var i = 0; i < input.length; ++i) {
result[input[i].id]=input[i].value;

}
}

var texts = toolsContent.querySelectorAll('.p_textarea');
if(texts.length>0){
for (var i = 0; i < texts.length; ++i) {
console.log("text");
console.log(texts[i]);
result[texts[i].id]=texts[i].value;

}
}
var images=toolsContent.querySelectorAll('.file_val');
if(images.length>0){
for (var i = 0; i < images.length; ++i) {

console.log(images[i]);
result[images[i].dataset.name]=images[i].innerHTML;

}
}
console.log("result_before_send");
console.log(result);
return result;
}

/**
* Allow Header to be converted to/from other blocks
*/


/**
* Sanitizer Rules
*/


/**
* Get current Tools`s data
* @returns {HeaderData} Current data
* @private
*/
get data() {


return this._data;
}

/**
* Store data in plugin:
* - at the this._data property
* - at the HTML
*
* @param {HeaderData} data — data to set
* @private
*/
set data(data) {
this._data = this.normalizeData(data);

/**
* If level is set and block in DOM
* then replace it to a new block
*/
if (data.level !== undefined && this._element.parentNode) {
/**
* Create a new tag
* @type {HTMLHeadingElement}
*/
let newHeader = this.getTag();

/**
* Save Block's content
*/
newHeader.innerHTML = this._element.innerHTML;

/**
* Replace blocks
*/
this._element.parentNode.replaceChild(newHeader, this._element);

/**
* Save new block to private variable
* @type {HTMLHeadingElement}
* @private
*/
this._element = newHeader;
}

/**
* If data.text was passed then update block's content
*/
if (data.text !== undefined) {
this._element.innerHTML = this._data.text || '';
}
}

/**
* Get tag for target level
* By default returns second-leveled header
* @return {HTMLElement}
*/
getTag() {
/**
* Create element for current Block's level
*/
let tag = document.createElement("p");

/**
* Add text to block
*/
tag.innerHTML = this._data.text || '';

/**
* Add styles class
*/
tag.classList.add(this._CSS.wrapper);

/**
* Make tag editable
*/
tag.contentEditable = 'true';

/**
* Add Placeholder
*/
tag.dataset.placeholder = this._settings.placeholder || '';

return tag;
}

/**
* Get current level
* @return {level}
*/


/**
* Return default level
* @returns {level}
*/
get defaultLevel() {
/**
* Use H2 as default header
*/
return this.levels[1];
}

/**
* @typedef {object} level
* @property {number} number - level number
* @property {string} tag - tag correspondes with level number
* @property {string} svg - icon
*/

/**
* Available header levels
* @return {level[]}
*/


/**
* Handle H1-H6 tags on paste to substitute it with header Tool
*
* @param {PasteEvent} event - event with pasted content
*/
onPaste(event) {
const content = event.detail.data;

/**
* Define default level value
* @type {number}
*/
let level = 2;

switch (content.tagName) {
case 'H1':
level = 1;
break;
/** H2 is a default level */
case 'H3':
level = 3;
break;
case 'H4':
level = 4;
break;
case 'H5':
level = 5;
break;
case 'H6':
level = 6;
break;
}

this.data = {
level,
text: content.innerHTML
};
}

/**
* Used by Editor.js paste handling API.
* Provides configuration to handle H1-H6 tags.
*
* @returns {{handler: (function(HTMLElement): {text: string}), tags: string[]}}
*/


/**
* Get Tool toolbox settings
* icon - Tool icon's SVG
* title - title to show in toolbox
*
* @return {{icon: string, title: string}}
*/
static get toolbox() {
return {
icon: '<i class="fa <?php echo $block['params']['_icon']; ?> "></i>',
title: '<?php echo $block['title']; ?>'
};
}
}
