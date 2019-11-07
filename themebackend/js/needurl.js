$(document).ready(function(){
    if($(".block_need_url").length>0){
    var path=$("#pathadmin").data("path")+"routes/ajax/show?url="+$(".block_need_url").data("url");

    $.get( path, function( data ) {
    $(".block_need_url").html( data );

  });
  }
});
$(document).on("submit",".route_update",function(){
  var url=$(this).data("url");
  $(".block_csrf_need").val($('meta[name=csrf-token]').attr("content"));
  var iframe;
var $form=$(".route_update");
    $form.attr("action",$("#pathadmin").data("path")+"routes/ajax/save?url="+url);
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
