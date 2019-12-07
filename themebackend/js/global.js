  function getMobileOperatingSystem() {
  var userAgent = navigator.userAgent || navigator.vendor || window.opera;

      // Windows Phone must come first because its UA also contains "Android"
    if (/windows phone/i.test(userAgent)) {
        return "Windows Phone";
    }

    if (/android/i.test(userAgent)) {
        return "Android";
    }

    // iOS detection from: http://stackoverflow.com/a/9039885/177710
    if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
        return "iOS";
    }

    return "unknown";
}
  function isMobile() {
  try{ document.createEvent("TouchEvent"); return true; }
  catch(e){ return false; }
}
   String.prototype.replaceAll = function( token, newToken, ignoreCase ) {
    var _token;
    var str = this + "";
    var i = -1;

    if ( typeof token === "string" ) {

        if ( ignoreCase ) {

            _token = token.toLowerCase();

            while( (
                i = str.toLowerCase().indexOf(
                    _token, i >= 0 ? i + newToken.length : 0
                ) ) !== -1
            ) {
                str = str.substring( 0, i ) +
                    newToken +
                    str.substring( i + token.length );
            }

        } else {
            return this.split( token ).join( newToken );
        }

    }
return str;
};
  
  var path_admin=$("#pathadmin").data("path");
  var url_dialog=$("#pathadmin").data("path")+"files/dialog"
      var url_connector=$("#pathadmin").data("elfinder-connector");
      
      
 function load_editor_image(el){
      var current_obj=el
            var param = $('meta[name=csrf-param]').attr("content");
            var token = $('meta[name=csrf-token]').attr("content");
            var rails_csrf = {};
            rails_csrf[param] = token;


            var opts = {
            url : url_connector,
            lang : 'ru',
            cur:$(this),
            commandsOptions:{
            getfile: {
            //onlyURL: true,
            folders: false,
            multiple: false,
            oncomplete: "destroy"
            }
            },
            current_object:current_obj,
            customData: rails_csrf,
            getFileCallback: function(file, el){

            var url = document.createElement('a');
            url.href = file.url;
                     

            current_obj.innerHTML="<b data-name='"+current_obj.name+"' name='"+current_obj.name+"'  class='file_val'>"+url.pathname+"</b>"
          //  current_obj.innerHTML="<img src='"+url.pathname+"' name='"+current_obj.name+"' class='img img-thumbnail image_val'>";
            // current_obj.innerHTML="Выбрать изображение("+url.pathname+")";


            return false;
            },
            title               : 'Файловый менеджер',
            width               : 960,
            height              : 500,
            resizable           : false,
            rememberLastDir     : false,
            autoOpen            : true,
            destroyOnClose      : true,
            debug               : false
            };
            return   $("<div>").dialogelfinder(opts);
     console.log(el);
     return false;
 }     
function elFinderBrowser (field_name, url, type, win) {


 tinymce.activeEditor.windowManager.open({
   file: url_dialog,// use an absolute path!
   title: ' Файловый менеджер',
   width: 900,
   height: 450,
   resizable: 'yes'
 }, {
   setUrl: function (file) {
     win.document.getElementById(field_name).value = file.url;
   }
 });
  return false;
}
$(".superjax").submit(function(event){


 var iframe;
var $form=$(this);
var success=$(this).data("success");
    if (!$form.attr('target'))
    {
        //create a unique iframe for the form
        iframe = $("<iframe></iframe>").attr('name', 'ajax_form_' + Math.floor(Math.random() * 999999)).hide().appendTo($('body'));
       $form.attr('target', iframe.attr('name'));

    }


        iframe = iframe || $('iframe[name=" ' + $form.attr('target') + ' "]');
        iframe.load(function ()
        {
            //get the server response
            var response = iframe.contents().find('body').text();
            var obj=JSON.parse(response);


                    if(obj.type=="success"){
                    if(obj.link!=undefined){
                     success=obj.link;
                    }
                      if(obj.stop==undefined){

                      document.location.href=success;
                    }else {
                        alertify.alert("Успешно");
                    }

                    }else {
                      alertify.alert(obj.message);
                    }
                    $(".notify").show();
        });


})


//$("body").on("keyup",".textarea-cdx",function(){
//   var text=$(this).html();
//   
//});

$("body").on("click",".dynamic_delete",function(){
    $(this).parents(".parent").detach();
    return false;
})
$(".ajaxsend").submit(function(){
 var iframe;
var $form=$(this);
var success=$(this).data("success");
    if (!$form.attr('target'))
    {
        //create a unique iframe for the form
        iframe = $("<iframe></iframe>").attr('name', 'ajax_form_' + Math.floor(Math.random() * 999999)).hide().appendTo($('body'));
       $form.attr('target', iframe.attr('name'));

    }


        iframe = iframe || $('iframe[name=" ' + $form.attr('target') + ' "]');
        iframe.load(function ()
        {
            //get the server response
            var response = iframe.contents().find('body').text();
            var obj=JSON.parse(response);


            if(obj.type=="success"){
            if(obj.link!=undefined){
             success=obj.link;
            }
              if(obj.stop==undefined){

              document.location.href=success;
            }else {
                alertify.alert("Успешно");
            }

            }else {
              alertify.alert(obj.message);
            }
                    $(".notify").show();
        });


})
$(document).on('click', ".deleteblock", function(e) {
  $(this).parent("p").detach();

  return false;
//do whatever

});
var global_this=null;
$(document).on("submit",".route_update",function(){
  var url=$(this).data("url");
  $(".block_csrf_need").attr("name",$('meta[name=csrf-param]').attr("content"));
  $(".block_csrf_need").val($('meta[name=csrf-token]').attr("content"));
  var iframe;
var $form=$(".route_update");
    $form.attr("action",$("#pathadmin").data("path")+"routes/ajax/save");
   if (!$form.attr('target'))
   {
       //create a unique iframe for the form
       iframe = $("<iframe></iframe>").attr('name', 'ajax_form_' + Math.floor(Math.random() * 999999)).hide().appendTo($('body'));
      $form.attr('target', iframe.attr('name'));

   }


       iframe = iframe || $('iframe[name=" ' + $form.attr('target') + ' "]');
       iframe.on("load",function ()
       {
           //get the server response
           var response = iframe.contents().find('body').text();
           var obj=JSON.parse(response);
if(obj.csrf){
$('meta[name=csrf-token]').attr("content",obj.csrf);
}

                   if(obj.type=="success"){
                   $(".notify_route").html("<div class='alert alert-success'><p>"+obj.message+"</p></div>")
                   }else {
                  $(".notify_route").html("<div class='alert alert-danger'><p>"+obj.message+"</p></div>")

                   }
                   $(".notify_route").show();
       });

});

$(document).on("click",".choose_file_on_builder",function(){
  var name=$(this).data("name");

global_this=this;
  var param = $('meta[name=csrf-param]').attr("content");
  var token = $('meta[name=csrf-token]').attr("content");
  var rails_csrf = {};
rails_csrf[param] = token;


  var opts = {
             url : url_connector,
             lang : 'ru',
             cur:$(this),
             commandsOptions:{
                 getfile: {
                     //onlyURL: true,
                     folders: false,
                     multiple: false,
                     oncomplete: "destroy"
                 }
             },
              customData: rails_csrf,
             getFileCallback: function(file, el){
                 
                 var url = document.createElement('a');
url.href = file.url;
 
           

               $(global_this).parent().find(".file_input").val(url.pathname);
 $(global_this).parent().find(".file_input").trigger( "change" );
  $(global_this).parent().find(".file_input").trigger( "blur" );
  parent.location.hash = '';
 
             
             },
             title               : 'Файловый менеджер',
             width               : 960,
             height              : 500,
             resizable           : false,
             rememberLastDir     : false,
             autoOpen            : true,
             destroyOnClose      : true,
             debug               : false
         };
$("<div>").dialogelfinder(opts);
return false;
})

$("body").on("click",".choose_file_editjs_old",function(){
    var current_obj=$(this);
  

global_this=this;
  var param = $('meta[name=csrf-param]').attr("content");
  var token = $('meta[name=csrf-token]').attr("content");
  var rails_csrf = {};
rails_csrf[param] = token;


  var opts = {
             url : url_connector,
             lang : 'ru',
             cur:$(this),
             commandsOptions:{
                 getfile: {
                     //onlyURL: true,
                     folders: false,
                     multiple: false,
                     oncomplete: "destroy"
                 }
             },
              customData: rails_csrf,
             getFileCallback: function(file, el){

var url = document.createElement('a');
url.href = file.url;
 
               current_obj.data("val",url.pathname);
               current_obj.text("Выбрать изображение("+url.pathname+")");

               
             },
             title               : 'Файловый менеджер',
             width               : 960,
             height              : 500,
             resizable           : false,
             rememberLastDir     : false,
             autoOpen            : true,
             destroyOnClose      : true,
             debug               : false
         };
$("<div>").dialogelfinder(opts);
return false;
})


$(document).on("click",".choose_file",function(){
  var name=$(this).data("name");

global_this=this;
  var param = $('meta[name=csrf-param]').attr("content");
  var token = $('meta[name=csrf-token]').attr("content");
  var rails_csrf = {};
rails_csrf[param] = token;


  var opts = {
             url : url_connector,
             lang : 'ru',
             cur:$(this),
             commandsOptions:{
                 getfile: {
                     //onlyURL: true,
                     folders: false,
                     multiple: false,
                     oncomplete: "destroy"
                 }
             },
              customData: rails_csrf,
             getFileCallback: function(file, el){

var url = document.createElement('a');
url.href = file.url;
 
               $(global_this).parent().find("a.namefile").attr("href",url.pathname);

               $(global_this).parent().find("a.namefile").html(file.name);
                $(global_this).parent().find(".choose_value_"+name).val(url.pathname);
               $(global_this).parent().find("a.namefile").show();
             },
             title               : 'Файловый менеджер',
             width               : 960,
             height              : 500,
             resizable           : false,
             rememberLastDir     : false,
             autoOpen            : true,
             destroyOnClose      : true,
             debug               : false
         };
$("<div>").dialogelfinder(opts);
return false;
})

$("body").on("click",".removefieldajax",function(){
 var id = $(this).data("id");
 $(".field_ajax_"+id).detach();
  var next=$(".addfield").data("next");

  
  
  next=parseInt(next);
  
  next=next-1;
   
  if(next==0){
   $(".btn_add_table").attr("disabled","disabled");   
  }
  $(".addfield").data("next",next);
 return false;
});



$(document).ready(function(){
  
    $( ".sidebar-nav > li" ).each( function( index, element ){
    if($(element).children("ul").length>0){
        if($(element).children("ul").children("li").length<=0){
           $(element).hide();
        }
    }
});
      $(".btnajaxadd").on("click",function(){
       var result=$($(this).data("result"));
       var newfield=$($(this).data("selector")).html();
        newfield=newfield.replaceAll("{replace}",$(this).data("name"));
        
        result.append(newfield);
        return false;
    });
  $(".allcheckbox").on("click",function(){
 
     var status=$(this).prop('checked');
  
     $(':checkbox').prop('checked',status);
 });  
    
  $(".choosetype").on("click change",function(){
      var value=$(this).val();
      if(value=="html"){
       $(".field_html").show();
       $(".field_others").hide();
      }else {
       
        $.get( path_admin+"blocks/loadtype/"+value, function( data ) {
   $(".field_html").hide();           
  $( ".result" ).html( data );
    $(".field_others").html(data);
    $(".field_others").show();
   
 if($("#editorjs").length>0){
  var saveButton = document.getElementById($('#editorjs').data("btn"));
   var const_editor_options=editor_options;
  
    
    console.log(const_editor_options);
    
    const_editor_options['onReady']=function(){
saveButton.click();  
};
 const_editor_options['onChange']=function(){
saveButton.click();  
};
const_editor_options['data']={};
const_editor_options['data']['blocks']=editorjs_value;


   const editor = new EditorJS(const_editor_options);
 
    saveButton.addEventListener('click', function () {
      editor.saver.save().then((savedData) => {
          var newval=JSON.stringify(savedData);
          console.log(savedData);
          $("#"+$("#editorjs").data("output-id")).val(newval);
  });
     
 
    });
}
});
        
        
      }
  })  
  $(".value_to_edit").on("click change",function(){
   var target=$(this).data("target");
   var val=$(this).val();
   if(val!="null"){
   $(target).val(val);
   }
   return true;
  })  
    
    
  $(".typeadminmenu").on("click change",function(){
      var icon= $('select.typeadminmenu').find(':selected').data('icon');
      var onlyroot= $('select.typeadminmenu').find(':selected').data('onlyroot');
      var nav= $('select.typeadminmenu').find(':selected').data('nav');
       var href= $('select.typeadminmenu').find(':selected').data('href');
       var title= $('select.typeadminmenu').find(':selected').data('title');
       var name_rule=$('select.typeadminmenu').find(':selected').data('name_rule');
       $(".am_icon").val(icon);
       $(".am_nav").val(nav);
       $(".am_href").val(href);
       $(".am_title").val(title);
       $(".am_name_rule").val(name_rule);
       if(onlyroot==1){
           $(".am_onlyroot").prop("checked",true);
       }else {
           $(".am_onlyroot").prop("checked",false);
       }
       return false;
       
  }); 
  $(".deleteerror").on("click",function(){
      var msg=$(this).data("msg");
       if(confirm(msg)){
          return true; 
       }else {
           return false;
       }
  });
     $(".typecontrol").on("change",function(){
       var link=$(this).children('option:selected').data('link');
       var fields=$(this).children('option:selected').data('fields');
       
          $.get( path_admin+""+fields, function( data ) {
$(".fields_list").html(data);
   
});
       $(".ajax_field_added").detach();
       $(".addfield").data("link",link);
       $(".addfield").data("next","0");
    
    });
  $(".addfield").on("click",function(){
      var value=$(".table_field").val();
      var link=$(this).data("link");
      
      if(link==undefined){
      link="content/tables/field/" ;   
      }
      var edit="0";
      if($(this).data("edit")!=undefined && $(this).data("edit")=="1"){
        edit=1;  
      }
      $.get( path_admin+""+link+""+value+"/"+edit, function( data ) {
 var next=$(".addfield").data("next");
 data = data.replace(/nid/g, next);
 next=parseInt(next);
 next=next+1;
 $(".addfield").data("next",next);
 $( ".tr_add_field" ).before( data );
 $(".btn_add_table").removeAttr("disabled");
   
});
return false;
  });
  
    
  if($(".block_need_url").length>0){
    var path=$("#pathadmin").data("path")+"routes/ajax/show?url="+$(".block_need_url").data("url");

    $.get( path, function( data ) {
    $(".block_need_url").html( data );

  });
  }
 
  $("body").on("click",".addfile",function(){
 var name=$(this).data("name");
 var sample=$(".multielfinder_"+name).html();
$(sample).insertBefore($(this));

    return false;
  });
//tinymce.PluginManager.add('example', function(editor, url) {
//    // Add a button that opens a window
//	editor.addButton('example', {
//		text: 'Отключить редактор',
//		icon: false,
//		onclick: function() {
//			// Open window
//                        tinymce.remove()
//			
//		}
//	});
//
//	// Adds a menu item to the tools menu
//	 
//});
    
 if($("#editorjs").length>0){
  var saveButton = document.getElementById($('#editorjs').data("btn"));
   var const_editor_options=editor_options;
 
    
    console.log(const_editor_options);
    
    const_editor_options['onReady']=function(){
saveButton.click();  
};
 const_editor_options['onChange']=function(){
saveButton.click();  
};
const_editor_options['data']={};
const_editor_options['data']['blocks']=editorjs_value;


   const editor = new EditorJS(const_editor_options);

    saveButton.addEventListener('click', function () {
      editor.saver.save().then((savedData) => {
          var newval=JSON.stringify(savedData);
          console.log(savedData);
          $("#"+$("#editorjs").data("output-id")).val(newval);
  });
     
 
    });
}




   editorjs_configs.forEach(function(item, i, arr) {
       console.log(editor_options);
       var editor_options_tmp=editor_options;
   var name_editor=item.name;    
 
 
  
  
    
    editor_options_tmp['holder']=name_editor;
 
 
 
    
    editor_options_tmp['onReady']=function(){
document.getElementById($("#"+name_editor).data("btn")).click();  
};
 editor_options_tmp['onChange']=function(){
document.getElementById($("#"+name_editor).data("btn")).click();  
};
editor_options_tmp['data']={};
editor_options_tmp['data']['blocks']=item.value;

 
 console.log(editor_options_tmp);
 
  item.editor = new EditorJS(editor_options_tmp);
 
    document.getElementById($("#"+name_editor).data("btn")).addEventListener('click', function () {
       item.editor.saver.save().then((savedData) => {
          var newval=JSON.stringify(savedData);
          console.log(savedData);
          $("#"+$('#editorjs_'+name_editor).data("output-id")).val(newval);
  });
     
 
    });
});
$("body").on('DOMSubtreeModified', "*", function() {
//    if($(".summernote_air").length>0){
//        console.log("is found");
//         $( ".summernote_air" ).each(function() {
//           
//   if(!($(this).hasClass("is_summer"))){
//     $(this).addClass("is_summer");
//   $(this).summernote({ 
//       shortcuts: {},
//       airMode: true,toolbar: [
//    ['style', ['style']],
//    ['font', ['bold', 'underline', 'clear']],
//    ['fontname', ['fontname']],
//    ['color', ['color','backColor']],
//    
//    ['insert', ['link']],
//    ['view', [ 'codeview', 'help']]
//  ]}); 
//   }
//});
//    }
    
    if($("textarea.p_textarea").length>0){
      
        $( "textarea.p_textarea" ).each(function() {
           
   if(!($(this).hasClass("is_summer"))){
     $(this).addClass("is_summer");
   $(this).summernote({ toolbar: [
    ['style', ['style']],
    ['font', ['bold', 'underline', 'clear']],
    ['fontname', ['fontname']],
    ['color', ['color','backColor']],
    
    ['insert', ['link']],
    ['view', [ 'codeview', 'help']]
  ]}); 
   }
});
    // 
    
    }
});
$('.tiny').trumbowyg({semantic: false});
//  tinymce.init({
//       selector : ".tiny",
//       oninit : "setPlainText",
//      file_browser_callback : elFinderBrowser,
//      height: 500,
//      theme: 'modern',
//      plugins: [
//        'example code advlist autolink lists link image charmap print preview hr anchor pagebreak',
//        'searchreplace wordcount visualblocks visualchars code fullscreen',
//        'insertdatetime media nonbreaking save table contextmenu directionality',
//        'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
//      ],
//      menubar:"tools",
//      relative_urls : false,
//  remove_script_host : false,
//  convert_urls : false,
//      allow_html_in_named_anchor:true,
//      allow_unsafe_link_target: true,
//      valid_elements : '*[*]',
//      toolbar1: 'example code undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
//      toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
//      image_advtab: true,
//      templates: [
//        { title: 'Test template 1', content: 'Test 1' },
//        { title: 'Test template 2', content: 'Test 2' }
//      ],
//      content_css: [
//        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
//        '//www.tinymce.com/css/codepen.min.css'
//      ]
//     });
 $('.tiny').trumbowyg();
$(".movebtn").on("click",function(){
    var link=$(this).data("link");
    var val=$(this).parent().children(".position").val();
    link=link+val;
    document.location.href=link;
    
    
});
$("body").on("click",".set_link",function(){
    var url=$(this).data("url");
    $("#exampleModal2").modal('hide');
    $(".url_input").val(url);
     $(".url_input").trigger( "change" );
  $(".url_input").trigger( "blur" );
  return false;

});
  $("body").on("click",".choose_link_builder",function(){
      
      $("#exampleModal2").modal();
      return false;
  });  
$(document).ready(function(){
     $(".typelog").on("click change",function(){
      var val=$(this).val();
     $(".all_types").hide();
     $(".type_"+val).show();
     
      return true;
  })  
  if($(".typelog").length>0){
     $(".typelog").click();
  }  
    
 
})

if($(".dialog_elfinder").length){
  var FileBrowserDialogue = {
    init: function() {
      // Here goes your code for setting your custom things onLoad.
    },
    mySubmit: function (URL) {
      // pass selected file path to TinyMCE
      parent.tinymce.activeEditor.windowManager.getParams().setUrl(URL);

      // force the TinyMCE dialog to refresh and fill in the image dimensions
      var t = parent.tinymce.activeEditor.windowManager.windows[0];
      t.find('#src').fire('change');

      // close popup window
      parent.tinymce.activeEditor.windowManager.close();
    }
  }

  var param = $('meta[name=csrf-param]').attr("content");
  var token = $('meta[name=csrf-token]').attr("content");
  var rails_csrf = {};
rails_csrf[param] = token;

 var url_path=$("#pathadmin").data("path")+"files/elfinder/connector/index"
  var options = {
    lang: 'ru',
    url : url_path,
    getFileCallback: function(file) { // editor callback
      // file.url - commandsOptions.getfile.onlyURL = false (default)
      // file     - commandsOptions.getfile.onlyURL = true
      FileBrowserDialogue.mySubmit(file); // pass selected file path to TinyMCE
    },
   customData: rails_csrf
  }
    var elf = $('.dialog_elfinder').elfinder(options).elfinder('instance');

}
if($(".chooseicon").length>0){
   $(".chooseicon").selectpicker({
       
       dropdownAlignRight:true,
       dropupAuto:true,
      
            
     }); 
}
var os=getMobileOperatingSystem();

 
if($(".selectpicker").length>0){
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
  $('.selectpicker').selectpicker('hide');
}

    
   
    $('.selectpicker').on('rendered.bs.select', function (e, clickedIndex, isSelected, previousValue) {
   $(".bootstrap-select > .dropdown-menu").removeClass("open");
});
    $('.selectpicker').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
  $(".bootstrap-select > .dropdown-menu").removeClass("open"); 
});

     
    $("body").on("click",".bootstrap-select > button > span",function(){
         
        $(".bootstrap-select > .dropdown-menu").addClass("open");
    });
}

  if($(".filemanager").length){
    var param = $('meta[name=csrf-param]').attr("content");
    var token = $('meta[name=csrf-token]').attr("content");
    var rails_csrf = {};
  rails_csrf[param] = token;

   var url_path=$("#pathadmin").data("path")+"files/elfinder/connector/index"
    var options = {
      lang: 'ru',
      url : url_path,
     customData: rails_csrf
    }



          var elf = $('.filemanager').elfinder(options).elfinder('instance');


  }
}) 
