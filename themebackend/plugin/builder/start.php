<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php echo \plugsystem\GlobalParams::$helper->c("csrf")->meta(); ?>
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="favicon.ico">
        <base href="">
        <title>Конструктор страниц</title>
        <link rel="stylesheet" href="{asset}css/plugins.css">
        <link href="{asset}builder_js/css/editor.css" rel="stylesheet">
        <link href="{asset}builder_js/css/line-awesome.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" media="screen" href="{asset}filemanager/css/elfinder.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="{asset}filemanager/css/theme.css">
        <style>
            #blocks .drag-elements-sidepane li[data-type] {
                height:auto;   
            }
        </style>
    </head>
    <body id="pathadmin" data-path="{pathadmin}">


        <div id="vvveb-builder">

            <div id="top-panel">
                <?php
                $conf = setup\models\ConfModel::get();
                ?>
                <a href="{pathadmin}index"><button class="float-left btn btn-danger"><?php echo $conf['name']; ?></button></a>
                <img style="display:none;" src="{asset}builder_js/img/logo.png" alt="Vvveb" class="float-left" id="logo">


                <div class="btn-group float-left" role="group">
                    <button class="btn btn-light" title="Toggle file manager" id="toggle-file-manager-btn" data-vvveb-action="toggleFileManager" data-toggle="button" aria-pressed="false">
                        <img src="{asset}builder_js/libs/builder/icons/file-manager-layout.svg" width="20px" height="20px">
                    </button>

                    <button class="btn btn-light" title="Toggle left column" id="toggle-left-column-btn" data-vvveb-action="toggleLeftColumn" data-toggle="button" aria-pressed="false">
                        <img src="{asset}builder_js/libs/builder/icons/left-column-layout.svg" width="20px" height="20px">
                    </button>

                    <button class="btn btn-light" title="Toggle right column" id="toggle-right-column-btn" data-vvveb-action="toggleRightColumn" data-toggle="button" aria-pressed="false">
                        <img src="{asset}builder_js/libs/builder/icons/right-column-layout.svg" width="20px" height="20px">
                    </button>
                </div>

                <div class="btn-group mr-3" role="group">
                    <button class="btn btn-light" title="Undo (Ctrl/Cmd + Z)" id="undo-btn" data-vvveb-action="undo" data-vvveb-shortcut="ctrl+z">
                        <i class="la la-undo"></i>
                    </button>

                    <button class="btn btn-light"  title="Redo (Ctrl/Cmd + Shift + Z)" id="redo-btn" data-vvveb-action="redo" data-vvveb-shortcut="ctrl+shift+z">
                        <i class="la la-undo la-flip-horizontal"></i>
                    </button>
                </div>


                <div class="btn-group mr-3" role="group">
                    <button class="btn btn-light" title="Designer Mode (Free component dragging)" id="designer-mode-btn" data-toggle="button" aria-pressed="false" data-vvveb-action="setDesignerMode">
                        <i class="la la-hand-grab-o"></i>
                    </button>

                    <button class="btn btn-light" title="Preview" id="preview-btn" type="button" data-toggle="button" aria-pressed="false" data-vvveb-action="preview">
                        <i class="la la-eye"></i>
                    </button>

                    <button class="btn btn-light" title="Fullscreen (F11)" id="fullscreen-btn" data-toggle="button" aria-pressed="false" data-vvveb-action="fullscreen">
                        <i class="la la-arrows"></i>
                    </button>

                </div>

                <div class="btn-group mr-3" role="group">
                    <?php
                    if (isset($this->page)) {
                        ?>
                        <button type="button" class="btn btn-sm btn-light btn-sm" data-toggle="modal" data-target="#exampleModal">
                            <i class="fa fa-cog"></i> 
                        </button>
                        <?php
                    }
                    ?>
                    <?php
                    if (isset($this->type) and is_numeric($this->type)) {
                        ?>
                        <a target="_blank" href="/builder/<?php echo $this->type; ?>" class="btn btn-light" >На страницу</a>
                        <?php
                    }
                    ?>


                    <button class="btn btn-light" title="Export (Ctrl + E)" id="save-btn" data-vvveb-action="saveAjax" data-vvveb-shortcut="ctrl+e">
                        <i class="la la-save"></i>
                    </button>




                </div>	


                <div class="btn-group float-right responsive-btns" role="group">
                    <button id="mobile-view" data-view="mobile" class="btn btn-light"  title="Mobile view" data-vvveb-action="viewport">
                        <i class="la la-mobile-phone"></i>
                    </button>

                    <button id="tablet-view"  data-view="tablet" class="btn btn-light"  title="Tablet view" data-vvveb-action="viewport">
                        <i class="la la-tablet"></i>
                    </button>

                    <button id="desktop-view"  data-view="" class="btn btn-light"  title="Desktop view" data-vvveb-action="viewport">
                        <i class="la la-laptop"></i>
                    </button>


                </div>

            </div>	

            <div id="left-panel">

                <div id="filemanager"> 
                    <div class="header">
                        <a href="#" class="text-secondary">Pages</a>

                        <div class="btn-group responsive-btns mr-4 float-right" role="group">


                            <!--  &ensp;
                            <button class="btn btn-link text-dark p-0"  title="Delete file" id="delete-file-btn" data-vvveb-action="deletePage" data-vvveb-shortcut="">
                                    <i class="la la-trash"></i> <small>Delete</small>
                            </button> -->
                        </div>

                    </div>

                    <div class="tree pages_tree">
                        <ol>
                        </ol>
                    </div>
                </div>



                <div class="drag-elements">

                    <div class="header">							
                        <ul class="nav nav-tabs" id="elements-tabs" role="tablist">
                            <li class="nav-item component-tab">
                                <a class="nav-link active" id="components-tab" data-toggle="tab" href="#components" role="tab" aria-controls="components" aria-selected="true"><i class="la la-lg la-cube"></i> <div><small>Components</small></div></a>
                            </li>
                            <li class="nav-item blocks-tab">
                                <a class="nav-link" id="blocks-tab" data-toggle="tab" href="#blocks" role="tab" aria-controls="blocks" aria-selected="false"><i class="la la-lg la-image"></i> <div><small>Blocks</small></div></a>
                            </li>
                            <li class="nav-item component-properties-tab" style="display:none">
                                <a class="nav-link" id="properties-tab" data-toggle="tab" href="#properties" role="tab" aria-controls="blocks" aria-selected="false"><i class="la la-lg la-cog"></i> <div><small>Properties</small></div></a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="components" role="tabpanel" aria-labelledby="components-tab">

                                <div class="search">
                                    <input class="form-control form-control-sm component-search" placeholder="Search components" type="text" data-vvveb-action="componentSearch" data-vvveb-on="keyup">
                                    <button class="clear-backspace"  data-vvveb-action="clearComponentSearch">
                                        <i class="la la-close"></i>
                                    </button>
                                </div>

                                <div class="drag-elements-sidepane sidepane">
                                    <div>

                                        <ul class="components-list clearfix" data-type="leftpanel">
                                        </ul>

                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="blocks" role="tabpanel" aria-labelledby="blocks-tab">

                                <div class="search">
                                    <input class="form-control form-control-sm block-search" placeholder="Search blocks" type="text" data-vvveb-action="blockSearch" data-vvveb-on="keyup">
                                    <button class="clear-backspace"  data-vvveb-action="clearBlockSearch">
                                        <i class="la la-close"></i>
                                    </button>
                                </div>

                                <div class="drag-elements-sidepane sidepane">
                                    <div>

                                        <ul class="blocks-list clearfix" data-type="leftpanel">
                                        </ul>

                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="properties" role="tabpanel" aria-labelledby="blocks-tab">
                                <div class="component-properties-sidepane">
                                    <div>
                                        <div class="component-properties">
                                            <div class="mt-4 text-center">Click on an element to edit.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>							

                </div>
            </div>	

            <div id="canvas">

                <div id="iframe-wrapper">
                    <div id="iframe-layer">

                        <div id="highlight-box">
                            <div id="highlight-name"></div>

                            <div id="section-actions">
                                <a id="add-section-btn" href="" title="Add element"><i class="la la-plus"></i></a>
                            </div>
                        </div>

                        <div id="select-box">

                            <div id="wysiwyg-editor">
                                <a id="bold-btn" href="" title="Bold"><i><strong>B</strong></i></a>
                                <a id="italic-btn" href="" title="Italic"><i>I</i></a>
                                <a id="underline-btn" href="" title="Underline"><u>u</u></a>
                                <a id="strike-btn" href="" title="Strikeout"><del>S</del></a>
                                <a id="link-btn" href="" title="Create link"><strong>a</strong></a>
                            </div>

                            <div id="select-actions">
                                <a id="drag-btn" href="" title="Drag element"><i class="la la-arrows"></i></a>
                                <a id="parent-btn" href="" title="Select parent"><i class="la la-level-down la-rotate-180"></i></a>

                                <a id="up-btn" href="" title="Move element up"><i class="la la-arrow-up"></i></a>
                                <a id="down-btn" href="" title="Move element down"><i class="la la-arrow-down"></i></a>
                                <a id="clone-btn" href="" title="Clone element"><i class="la la-copy"></i></a>
                                <a id="delete-btn" href="" title="Remove element"><i class="la la-trash"></i></a>
                            </div>
                        </div>

                        <!-- add section box -->
                        <div id="add-section-box" class="drag-elements">

                            <div class="header">							
                                <ul class="nav nav-tabs" id="box-elements-tabs" role="tablist">
                                    <li class="nav-item component-tab">
                                        <a class="nav-link active" id="box-components-tab" data-toggle="tab" href="#box-components" role="tab" aria-controls="components" aria-selected="true"><i class="la la-lg la-cube"></i> <div><small>Components</small></div></a>
                                    </li>
                                    <li class="nav-item blocks-tab">
                                        <a class="nav-link" id="box-blocks-tab" data-toggle="tab" href="#box-blocks" role="tab" aria-controls="blocks" aria-selected="false"><i class="la la-lg la-image"></i> <div><small>Blocks</small></div></a>
                                    </li>
                                    <li class="nav-item component-properties-tab" style="display:none">
                                        <a class="nav-link" id="box-properties-tab" data-toggle="tab" href="#box-properties" role="tab" aria-controls="blocks" aria-selected="false"><i class="la la-lg la-cog"></i> <div><small>Properties</small></div></a>
                                    </li>
                                </ul>

                                <div class="section-box-actions">

                                    <div id="close-section-btn" class="btn btn-light btn-sm bg-white btn-sm float-right"><i class="la la-close"></i></div>

                                    <div class="small mt-1 mr-3 float-right">

                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="add-section-insert-mode-after" value="after" checked="checked" name="add-section-insert-mode" class="custom-control-input">
                                            <label class="custom-control-label" for="add-section-insert-mode-after">After</label>
                                        </div>

                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="add-section-insert-mode-inside" value="inside" name="add-section-insert-mode" class="custom-control-input">
                                            <label class="custom-control-label" for="add-section-insert-mode-inside">Inside</label>
                                        </div>

                                    </div>

                                </div>

                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="box-components" role="tabpanel" aria-labelledby="components-tab">

                                        <div class="search">
                                            <input class="form-control form-control-sm component-search" placeholder="Search components" type="text" data-vvveb-action="addBoxComponentSearch" data-vvveb-on="keyup">
                                            <button class="clear-backspace"  data-vvveb-action="clearComponentSearch">
                                                <i class="la la-close"></i>
                                            </button>
                                        </div>

                                        <div>
                                            <div>

                                                <ul class="components-list clearfix" data-type="addbox">
                                                </ul>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="box-blocks" role="tabpanel" aria-labelledby="blocks-tab">

                                        <div class="search">
                                            <input class="form-control form-control-sm block-search" placeholder="Search blocks" type="text" data-vvveb-action="addBoxBlockSearch" data-vvveb-on="keyup">
                                            <button class="clear-backspace"  data-vvveb-action="clearBlockSearch">
                                                <i class="la la-close"></i>
                                            </button>
                                        </div>

                                        <div>
                                            <div>

                                                <ul class="blocks-list clearfix"  data-type="addbox">
                                                </ul>

                                            </div>
                                        </div>

                                    </div>

                                    <!-- div class="tab-pane fade" id="box-properties" role="tabpanel" aria-labelledby="blocks-tab">
                                            <div class="component-properties-sidepane">
                                                    <div>
                                                            <div class="component-properties">
                                                                    <div class="mt-4 text-center">Click on an element to edit.</div>
                                                            </div>
                                                    </div>
                                            </div>
                                    </div -->
                                </div>
                            </div>		

                        </div>
                        <!-- //add section box -->
                    </div>


                    <iframe src="about:none" id="iframe1"></iframe>
                </div>


            </div>

            <div id="right-panel">
                <div class="component-properties">

                    <ul class="nav nav-tabs nav-fill" id="properties-tabs" role="tablist">
                        <li class="nav-item content-tab">
                            <a class="nav-link active" data-toggle="tab" href="#content-tab" role="tab" aria-controls="components" aria-selected="true">
                                <i class="la la-lg la-cube"></i> <div><span>Content</span></div></a>
                        </li>
                        <li class="nav-item style-tab">
                            <a class="nav-link" data-toggle="tab" href="#style-tab" role="tab" aria-controls="blocks" aria-selected="false">
                                <i class="la la-lg la-image"></i> <div><span>Style</span></div></a>
                        </li>
                        <li class="nav-item advanced-tab">
                            <a class="nav-link" data-toggle="tab" href="#advanced-tab" role="tab" aria-controls="blocks" aria-selected="false">
                                <i class="la la-lg la-cog"></i> <div><span>Advanced</span></div></a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="content-tab" role="tabpanel" aria-labelledby="content-tab">
                        </div>

                        <div class="tab-pane fade show" id="style-tab" role="tabpanel" aria-labelledby="style-tab">
                        </div>

                        <div class="tab-pane fade show" id="advanced-tab" role="tabpanel" aria-labelledby="advanced-tab">
                        </div>


                    </div>



                </div>
            </div>

            <div id="bottom-panel">


                <?php
                if (isset($this->page)) {
                    ?>
                    <button type="button" class="btn btn-sm btn-light btn-sm" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-cog"></i>  Настройка страницы
                    </button>
                    <?php
                }
                ?>

                <!-- Modal -->



                <div class="btn-group" role="group">

                    <button id="code-editor-btn" data-view="mobile" class="btn btn-sm btn-light btn-sm"  title="Code editor" data-vvveb-action="toggleEditor">
                        <i class="la la-code"></i> Code editor
                    </button>

                    <div id="toggleEditorJsExecute" class="custom-control custom-checkbox mt-1" style="display:none">
                        <input type="checkbox" class="custom-control-input" id="customCheck" name="example1" data-vvveb-action="toggleEditorJsExecute">
                        <label class="custom-control-label" for="customCheck"><small>Run javascript code on edit</small></label>
                    </div>
                </div>

                <div id="vvveb-code-editor">
                    <textarea class="form-control"></textarea>
                    <div>

                    </div>	
                </div>
            </div>


            <!-- templates -->

            <script id="vvveb-input-textinput" type="text/html">

                <div>
                    <input name="{%=key%}" type="text" class="form-control"/>
                </div>

            </script>
            <script id="vvveb-input-urlinput" type="text/html">

                <div>
                    <input name="{%=key%}" type="text" class="url_input form-control"/>
                    <a href="#" class="choose_link_builder">Выбрать</a>
                </div>

            </script>


            <script id="vvveb-input-checkboxinput" type="text/html">

                <div class="custom-control custom-checkbox">
                    <input name="{%=key%}" class="custom-control-input" type="checkbox" id="{%=key%}_check">
                    <label class="custom-control-label" for="{%=key%}_check">{% if (typeof text !== 'undefined') { %} {%=text%} {% } %}</label>
                </div>

            </script>

            <script id="vvveb-input-radioinput" type="text/html">

                <div>

                    {% for ( var i = 0; i < options.length; i++ ) { %}

                    <label class="custom-control custom-radio  {% if (typeof inline !== 'undefined' && inline == true) { %}custom-control-inline{% } %}"  title="{%=options[i].title%}">
                        <input name="{%=key%}" class="custom-control-input" type="radio" value="{%=options[i].value%}" id="{%=key%}{%=i%}" {%if (options[i].checked) { %}checked="{%=options[i].checked%}"{% } %}>
                        <label class="custom-control-label" for="{%=key%}{%=i%}">{%=options[i].text%}</label>
                    </label>

                    {% } %}

                </div>

            </script>

            <script id="vvveb-input-radiobuttoninput" type="text/html">

                <div class="btn-group btn-group-toggle  {%if (extraclass) { %}{%=extraclass%}{% } %} clearfix" data-toggle="buttons">

                    {% for ( var i = 0; i < options.length; i++ ) { %}

                    <label class="btn  btn-outline-primary  {%if (options[i].checked) { %}active{% } %}" for="{%=key%}{%=i%} " title="{%=options[i].title%}">
                        <input name="{%=key%}" class="custom-control-input" type="radio" value="{%=options[i].value%}" id="{%=key%}{%=i%}" {%if (options[i].checked) { %}checked="{%=options[i].checked%}"{% } %}>
                        {%if (options[i].icon) { %}<i class="{%=options[i].icon%}"></i>{% } %}
                        {%=options[i].text%}
                    </label>

                    {% } %}

                </div>

            </script>


            <script id="vvveb-input-toggle" type="text/html">

                <div class="toggle">
                    <input type="checkbox" name="{%=key%}" value="{%=on%}" data-value-off="{%=off%}" data-value-on="{%=on%}" class="toggle-checkbox" id="{%=key%}">
                    <label class="toggle-label" for="{%=key%}">
                        <span class="toggle-inner"></span>
                        <span class="toggle-switch"></span>
                    </label>
                </div>

            </script>

            <script id="vvveb-input-header" type="text/html">

                <h6 class="header">{%=header%}</h6>

            </script>


            <script id="vvveb-input-select" type="text/html">

                <div>

                    <select class="form-control custom-select">
                        {% for ( var i = 0; i < options.length; i++ ) { %}
                        <option value="{%=options[i].value%}">{%=options[i].text%}</option>
                        {% } %}
                    </select>

                </div>

            </script>


            <script id="vvveb-input-listinput" type="text/html">

                <div class="row">

                    {% for ( var i = 0; i < options.length; i++ ) { %}
                    <div class="col-6">
                        <div class="input-group">
                            <input name="{%=key%}_{%=i%}" type="text" class="form-control" value="{%=options[i].text%}"/>
                            <div class="input-group-append">
                                <button class="input-group-text btn btn-sm btn-danger">
                                    <i class="la la-trash la-lg"></i>
                                </button>
                            </div>
                        </div>
                        <br/>
                    </div>
                    {% } %}


                    {% if (typeof hide_remove === 'undefined') { %}
                    <div class="col-12">

                        <button class="btn btn-sm btn-outline-primary">
                            <i class="la la-trash la-lg"></i> Add new
                        </button>

                    </div>
                    {% } %}

                </div>

            </script>

            <script id="vvveb-input-grid" type="text/html">

                <div class="row">
                    <div class="mb-1 col-12">

                        <label>Flexbox</label>
                        <select class="form-control custom-select" name="col">

                            <option value="">None</option>
                            {% for ( var i = 1; i <= 12; i++ ) { %}
                            <option value="{%=i%}" {% if ((typeof col !== 'undefined') && col == i) { %} selected {% } %}>{%=i%}</option>
                            {% } %}

                        </select>
                        <br/>
                    </div>

                    <div class="col-6">
                        <label>Extra small</label>
                        <select class="form-control custom-select" name="col-xs">

                            <option value="">None</option>
                            {% for ( var i = 1; i <= 12; i++ ) { %}
                            <option value="{%=i%}" {% if ((typeof col_xs !== 'undefined') && col_xs == i) { %} selected {% } %}>{%=i%}</option>
                            {% } %}

                        </select>
                        <br/>
                    </div>

                    <div class="col-6">
                        <label>Small</label>
                        <select class="form-control custom-select" name="col-sm">

                            <option value="">None</option>
                            {% for ( var i = 1; i <= 12; i++ ) { %}
                            <option value="{%=i%}" {% if ((typeof col_sm !== 'undefined') && col_sm == i) { %} selected {% } %}>{%=i%}</option>
                            {% } %}

                        </select>
                        <br/>
                    </div>

                    <div class="col-6">
                        <label>Medium</label>
                        <select class="form-control custom-select" name="col-md">

                            <option value="">None</option>
                            {% for ( var i = 1; i <= 12; i++ ) { %}
                            <option value="{%=i%}" {% if ((typeof col_md !== 'undefined') && col_md == i) { %} selected {% } %}>{%=i%}</option>
                            {% } %}

                        </select>
                        <br/>
                    </div>

                    <div class="col-6 mb-1">
                        <label>Large</label>
                        <select class="form-control custom-select" name="col-lg">

                            <option value="">None</option>
                            {% for ( var i = 1; i <= 12; i++ ) { %}
                            <option value="{%=i%}" {% if ((typeof col_lg !== 'undefined') && col_lg == i) { %} selected {% } %}>{%=i%}</option>
                            {% } %}

                        </select>
                        <br/>
                    </div>

                    {% if (typeof hide_remove === 'undefined') { %}
                    <div class="col-12">

                        <button class="btn btn-sm btn-outline-light text-danger">
                            <i class="la la-trash la-lg"></i> Remove
                        </button>

                    </div>
                    {% } %}

                </div>

            </script>

            <script id="vvveb-input-textvalue" type="text/html">

                <div class="row">
                    <div class="col-6 mb-1">
                        <label>Value</label>
                        <input name="value" type="text" value="{%=value%}" class="form-control"/>
                    </div>

                    <div class="col-6 mb-1">
                        <label>Text</label>
                        <input name="text" type="text" value="{%=text%}" class="form-control"/>
                    </div>

                    {% if (typeof hide_remove === 'undefined') { %}
                    <div class="col-12">

                        <button class="btn btn-sm btn-outline-light text-danger">
                            <i class="la la-trash la-lg"></i> Remove
                        </button>

                    </div>
                    {% } %}

                </div>

            </script>

            <script id="vvveb-input-rangeinput" type="text/html">

                <div>
                    <input name="{%=key%}" type="range" min="{%=min%}" max="{%=max%}" step="{%=step%}" class="form-control"/>
                </div>

            </script>

            <script id="vvveb-input-imageinput" type="text/html">

                <div>
                    <input name="{%=key%}" type="text" class="file_input form-control"/>


                    <a href="#" class="choose_file_on_builder">Выбрать файл</a>
                </div>

            </script>

            <script id="vvveb-input-colorinput" type="text/html">

                <div>
                    <input name="{%=key%}" type="color" {% if (typeof value !== 'undefined' && value != false) { %} value="{%=value%}" {% } %}  pattern="#[a-f0-9]{6}" class="form-control"/>
                </div>

            </script>

            <script id="vvveb-input-bootstrap-color-picker-input" type="text/html">

                <div>
                    <div id="cp2" class="input-group" title="Using input value">
                        <input name="{%=key%}" type="text" {% if (typeof value !== 'undefined' && value != false) { %} value="{%=value%}" {% } %}	 class="form-control"/>
                               <span class="input-group-append">
                            <span class="input-group-text colorpicker-input-addon"><i></i></span>
                        </span>
                    </div>
                </div>

            </script>

            <script id="vvveb-input-numberinput" type="text/html">
                <div>
                    <input name="{%=key%}" type="number" value="{%=value%}" 
                           {% if (typeof min !== 'undefined' && min != false) { %}min="{%=min%}"{% } %} 
                           {% if (typeof max !== 'undefined' && max != false) { %}max="{%=max%}"{% } %} 
                           {% if (typeof step !== 'undefined' && step != false) { %}step="{%=step%}"{% } %} 
                           class="form-control"/>
                </div>
            </script>

            <script id="vvveb-input-button" type="text/html">
                <div>
                    <button class="btn btn-sm btn-primary">
                        <i class="la  {% if (typeof icon !== 'undefined') { %} {%=icon%} {% } else { %} la-plus {% } %} la-lg"></i> {%=text%}
                    </button>
                </div>		
            </script>

            <script id="vvveb-input-cssunitinput" type="text/html">
                <div class="input-group" id="cssunit-{%=key%}">
                    <input name="number" type="number"  {% if (typeof value !== 'undefined' && value != false) { %} value="{%=value%}" {% } %} 
                           {% if (typeof min !== 'undefined' && min != false) { %}min="{%=min%}"{% } %} 
                           {% if (typeof max !== 'undefined' && max != false) { %}max="{%=max%}"{% } %} 
                           {% if (typeof step !== 'undefined' && step != false) { %}step="{%=step%}"{% } %} 
                           class="form-control"/>
                           <div class="input-group-append">
                        <select class="form-control custom-select small-arrow" name="unit">
                            <option value="em">em</option>
                            <option value="px">px</option>
                            <option value="%">%</option>
                            <option value="rem">rem</option>
                            <option value="auto">auto</option>
                        </select>
                    </div>
                </div>

            </script>


            <script id="vvveb-filemanager-page" type="text/html">
                <li data-url="{%=url%}"  data-last_id="{%=last_id%}" data-page="{%=name%}">
                    <label data-url="{%=url%}"  data-last_id="{%=last_id%}" data-page="{%=name%}"  for="{%=name%}"><span>{%=title%}</span></label> <input type="checkbox" checked id="{%=name%}" />
                    <a class="delete_page delete_page_{%=last_id%}" href="{pathadmin}builder/delete/{%=last_id%}">[x]</a>
                    <ol></ol>
                </li>
            </script>

            <script id="vvveb-filemanager-component" type="text/html">
                <li data-url="{%=url%}"  data-component="{%=name%}" class="file">
                    <a href="{%=url%}"><span>{%=title%}</span></a>
                </li>
            </script>

            <script id="vvveb-input-sectioninput" type="text/html">

                <label class="header" data-header="{%=key%}" for="header_{%=key%}"><span>&ensp;{%=header%}</span> <div class="header-arrow"></div></label> 
                <input class="header_check" type="checkbox" {% if (typeof expanded !== 'undefined' && expanded == false) { %} {% } else { %}checked="true"{% } %} id="header_{%=key%}"> 
                       <div class="section" data-section="{%=key%}"></div>		

            </script>


            <script id="vvveb-property" type="text/html">

                <div class="form-group {% if (typeof col !== 'undefined' && col != false) { %} col-sm-{%=col%} d-inline-block {% } else { %}row{% } %}" data-key="{%=key%}" {% if (typeof group !== 'undefined' && group != null) { %}data-group="{%=group%}" {% } %}>

                     {% if (typeof name !== 'undefined' && name != false) { %}<label class="{% if (typeof inline === 'undefined' ) { %}col-sm-4{% } %} control-label" for="input-model">{%=name%}</label>{% } %}

                    <div class="{% if (typeof inline === 'undefined') { %}col-sm-{% if (typeof name !== 'undefined' && name != false) { %}8{% } else { %}12{% } } %} input"></div>

                </div>		 

            </script>

            <script id="vvveb-input-autocompletelist" type="text/html">

                <div>
                    <input name="{%=key%}" type="text" class="form-control"/>

                    <div class="form-control autocomplete-list" style="min=height: 150px; overflow: auto;">
                        <div id="featured-product43"><i class="la la-close"></i> MacBook
                            <input name="product[]" value="43" type="hidden">
                        </div>
                        <div id="featured-product40"><i class="la la-close"></i> iPhone
                            <input name="product[]" value="40" type="hidden">
                        </div>
                        <div id="featured-product42"><i class="la la-close"></i> Apple Cinema 30"
                            <input name="product[]" value="42" type="hidden">
                        </div>
                        <div id="featured-product30"><i class="la la-close"></i> Canon EOS 5D
                            <input name="product[]" value="30" type="hidden">
                        </div>
                    </div>
                </div>

            </script>


            <!--// end templates -->


            <!-- export html modal-->
            <div class="modal fade" id="textarea-modal" tabindex="-1" role="dialog" aria-labelledby="textarea-modal" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p class="modal-title text-primary"><i class="la la-lg la-save"></i> Export html</p>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><small><i class="la la-close"></i></small></span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <textarea rows="25" cols="150" class="form-control"></textarea>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal"><i class="la la-close"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- message modal-->
            <div class="modal fade" id="message-modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p class="modal-title text-primary"><i class="la la-lg la-comment"></i> VvvebJs</p>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><small><i class="la la-close"></i></small></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Page was successfully saved!.</p>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-primary">Ok</button> -->
                            <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal"><i class="la la-close"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- new page modal-->
            <div class="modal fade" id="new-page-modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">

                    <form>

                        <div class="modal-content">
                            <div class="modal-header">
                                <p class="modal-title text-primary"><i class="la la-lg la-file"></i> New page</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><small><i class="la la-close"></i></small></span>
                                </button>
                            </div>

                            <div class="modal-body text">
                                <div class="form-group row" data-key="type">      
                                    <label class="col-sm-3 control-label">
                                        Template 
                                        <abbr class="badge badge-pill badge-secondary" title="This template will be used as a start">?</abbr> 
                                    </label>      
                                    <div class="col-sm-9 input">
                                        <div>    
                                            <select class="form-control custom-select" name="startTemplateUrl">        
                                                <option value="new-page-blank-template.html">Blank Template</option>        
                                                <option value="demo/narrow-jumbotron/index.html">Narrow jumbotron</option>       
                                                <option value="demo/album/index.html">Album</option>       
                                            </select>    
                                        </div>
                                    </div>     
                                </div>

                                <div class="form-group row" data-key="href">     
                                    <label class="col-sm-3 control-label">Page name</label>      
                                    <div class="col-sm-9 input">
                                        <div>   
                                            <input name="title" type="text" class="form-control" placeholder="My page" required>  
                                        </div>
                                    </div>     
                                </div>

                                <div class="form-group row" data-key="href">     
                                    <label class="col-sm-3 control-label">File name</label>      
                                    <div class="col-sm-9 input">
                                        <div>   
                                            <input name="fileName" type="text" class="form-control" placeholder="my-page.html" required>  
                                        </div>
                                    </div>     
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-primary btn-lg" type="submit"><i class="la la-check"></i> Create page</button>
                                <button class="btn btn-secondary btn-lg" type="reset" data-dismiss="modal"><i class="la la-close"></i> Cancel</button>
                            </div>
                        </div>

                    </form>		

                </div>
            </div>
        </div>

        <?php
        if (isset($this->page)) {
            ?>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Настройка страницы</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="block_need_url" data-url="/builder/<?php echo $this->type; ?>"></div>
                            <form action="{pathadmin}builder/save/title/<?php echo $this->type; ?>" method="POST">
                                <table class="table">
                                    <tr>
                                        <td>Название страницы</td>
                                        <td><input type="text" name="name" value="<?php echo $this->page['name']; ?>"></td>
                                        <td><button type="submit" class="btn btn-danger" name="_csrf" value="<?php echo $this->_csrf; ?>">Сохранить название</button></td>
                                    </tr>
                                </table>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>

                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>


        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Выбор ссылок</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        if (count($this->types)) {
                            foreach ($this->types as $type) {
                                ?>
                                <p><a href="#" class="set_link" data-url="<?php echo $type['value']; ?>"><?php echo $type['title']; ?></a></p>
                                <?php
                            }
                        }
                        ?>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>

                    </div>
                </div>
            </div>
        </div>
        <!-- jquery-->
        <script src="{asset}builder_js/js/jquery.min.js"></script>

        <link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css" />
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="{asset}filemanager/js/elfinder.min.js"></script>
        <!--        <-- Import Trumbowyg -->


        <!--        <-- Import Trumbowyg plugins... -->
        <!--        <script src="{asset}js/newgui/plugins/upload/trumbowyg.cleanpaste.min.js"></script>
        -->
        <script src="{asset}js/newgui/dist/trumbowyg.elfinder.js"></script>
        <script src="{asset}js/newgui/plugins/pasteimage/trumbowyg.pasteimage.js"></script>
        <script src="{asset}js/newgui/dist/trumbowyg.js"></script>
        <!--        <-- Init Trumbowyg -->
        <script>
            // Doing this in a loaded JS file is better, I put this here for simplicity

        </script>


        <link rel="stylesheet" href="{asset}notify/themes/alertify.core.css" />
        <link rel="stylesheet" href="{asset}notify/themes/alertify.default.css" id="toggleCSS" />
        <script src="{asset}notify/lib/alertify.min.js"></script>
        <script type="text/javascript" src="{asset}js/global.js"></script>
        <script>
<?php
$notifys = \plugsystem\models\NotifyModel::getAll();
if (count($notifys)) {
    foreach ($notifys as $notify) {
        ?>
                    alertify.alert("<?php echo $notify; ?>");
        <?php
    }
}
?>
<?php
$notifys = plugcomponents\Notify::getAll();
if (count($notifys)) {
    foreach ($notifys as $notify) {
        ?>
                    alertify.alert("<?php echo $notify['message']; ?>");
        <?php
    }
}
?>
        </script>
        <script src="{asset}builder_js/js/jquery.hotkeys.js"></script>

        <!-- bootstrap-->
        <script src="{asset}builder_js/js/popper.min.js"></script>
        <script src="{asset}builder_js/js/bootstrap.min.js"></script>

        <!-- builder code-->
        <script src="{asset}builder_js/libs/builder/builder.js"></script>	
        <!-- undo manager-->
        <script src="{asset}builder_js/libs/builder/undo.js"></script>	
        <!-- inputs-->
        <script src="{asset}builder_js/libs/builder/inputs.js"></script>	

        <!-- bootstrap colorpicker //uncomment bellow scripts to enable -->
        <!--
        <script src="libs/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <link href="libs/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <script src="libs/builder/plugin-bootstrap-colorpicker.js"></script>
        -->

        <!-- components-->
        <script src="{asset}builder_js/libs/builder/components-bootstrap4.js"></script>	
        <script src="{asset}builder_js/libs/builder/components-widgets.js"></script>	

        <!-- blocks-->

        <script  src="{pathadmin}builder/blocks/index"></script>
<!--        <script src="{asset}builder_js/libs/builder/blocks-bootstrap4.js"></script>	-->

        <!-- plugins -->

        <!-- code mirror - code editor syntax highlight -->
        <link href="{asset}builder_js/libs/codemirror/lib/codemirror.css" rel="stylesheet"/>
        <link href="{asset}builder_js/libs/codemirror/theme/material.css" rel="stylesheet"/>
        <script src="{asset}builder_js/libs/codemirror/lib/codemirror.js"></script>
        <script src="{asset}builder_js/libs/codemirror/lib/xml.js"></script>
        <script src="{asset}builder_js/libs/codemirror/lib/formatting.js"></script>
        <script src="{asset}builder_js/libs/builder/plugin-codemirror.js"></script>	

        <!-- jszip - download page as zip -->
        <!-- script src="libs/jszip/jszip.min.js"></script>
        <script src="libs/builder/plugin-jszip.js"></script -->

        <script>
            $(document).ready(function ()
            {
                $(".block_update").on("click", function () {
                    alert('1111');
                    return false;
                })
                //if url has #no-right-panel set one panel demo
                if (window.location.hash.indexOf("no-right-panel") != -1)
                {
                    $("#vvveb-builder").addClass("no-right-panel");
                    $(".component-properties-tab").show();
                    Vvveb.Components.componentPropertiesElement = "#left-panel .component-properties";
                } else
                {
                    $(".component-properties-tab").hide();
                }
                Vvveb.Builder.init('/builder/tmp/<?php echo $this->type; ?>', function () {
                    //run code after page/iframe is loaded
                });

                Vvveb.Gui.init();
                Vvveb.FileManager.init();
                Vvveb.FileManager.addPages(
<?php echo json_encode($this->pages_json); ?>);

                Vvveb.FileManager.loadPage("page<?php echo $this->type; ?>");
            });

            $(document).ready(function () {
                $(".delete_page_new").detach();
                $(".delete_page").on("click", function () {
                    var url = $(this).attr("href");

                    document.onbeforeunload = function () {
                        return;
                    };
                    document.location.href = url;

                })
                $(".pages_tree > ol > li > label").on("click", function () {
                    var url = $(this).data("last_id");



                    var path_admin = $("#pathadmin").data("path");
                    path_admin = path_admin + "builder/" + url;
                    document.location.href = path_admin;

                });
            });
        </script>
    </body>
</html>
