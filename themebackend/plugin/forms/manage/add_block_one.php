<h4><?php echo __("backend/forms.main_setup_block"); ?></h4>

<table class="table">

    <tr>
        <td><?php echo __("backend/forms.postfix"); ?> </td>
        <td>
            <input type="text" name="{param}[postfix_template]" value="<?php echo $params['postfix_template']; ?>" class="form-control"/> 
        </td>

    </tr>
</table>
<h4><?php echo __("backend/forms.template_form"); ?></h4>
<div class="row">
    <div class="col-md-4">
        <div class="widget-content themed-background-info text-light">
            <i class="fa fa-fw fa-sticky-note"></i> <strong><?php echo __("backend/forms.hints"); ?></strong>
        </div> 
        <?php
        if (count($form['fields'])) {
            if ($form['type'] == "mysql") {
                foreach ($form['fields'] as $key => $field) {
                    $var = '{%' . $key . '_input%}';
                    $html = '<input type="text" name="' . $key . '" >';
                    $html = htmlspecialchars($html);
                    ?>
                    <div class="block" >
                        <div class="block-title">
                            <h2 style="text-transform: lowercase;"><?php echo $var; ?></h2>
                        </div>
                        <p><?php echo __("backend/forms.field"); ?> <?php echo $field['title']; ?> </p>
                        <p><?php echo __("backend/forms.type"); ?> \content\fields\<?php echo $field['type']; ?></p>
                        <p><?php echo __("backend/forms.path_template"); ?></p>
                        <p style="word-wrap:break-word;"><?php echo $path_fields; ?><?php echo strtolower($field['type']); ?>.php </p>
                        <blockquote><?php echo $html; ?></blockquote>
                    </div>
                    <?php
                }
            } else {
                foreach ($form['fields'] as $key => $field) {
                    $var = '{%' . $key . '_input%}';
                    ?>
                    <div class="block" >
                        <div class="block-title">
                            <h2 style="text-transform: lowercase;"><?php echo $var; ?></h2>
                        </div>
                        <p><?php echo __("backend/forms.field"); ?> <?php echo $field['title']; ?> </p>
                        <p><?php echo __("backend/forms.type"); ?> \mg\fields\<?php echo $field['type']; ?></p>
                        <p><?php echo __("backend/forms.path_template"); ?></p>
                        <p style="word-wrap:break-word;"><?php echo $path_fields; ?><?php echo strtolower($field['type']); ?>.php </p>
                    </div>
                    <?php
                }
            }
        }
        ?>



    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="widget-content themed-background text-light-op">
                <i class="fa fa-fw fa-pencil"></i> <strong><?php echo $path_template; ?></strong>
            </div> 
            <textarea class="form-control" rows="20" readonly="readonly"><?php echo $template2; ?></textarea>
        </div>
        <div class="row"><?php echo __("backend/forms.or"); ?></div>
        <div class="row">
            <div class="widget-content themed-background text-light-op">
                <i class="fa fa-fw fa-pencil"></i> <strong><?php echo $path_template; ?></strong>
            </div> 
            <textarea class="form-control" rows="20" readonly="readonly"><?php echo $template; ?></textarea>
        </div>

        <div class="row">
            <div class="widget-content themed-background text-light-op">
                <i class="fa fa-fw fa-pencil"></i> <strong><?php echo __("backend/forms.js_file"); ?></strong>
            </div> 
            <textarea class="form-control" rows="20" readonly="readonly">$(&quot;.formsend&quot;).submit(function(){
 var iframe;
var $form=$(&quot;.formsend&quot;);
$form.attr(&quot;action&quot;,$form.data(&quot;action&quot;));
    if (!$form.attr('target'))
    {
        //create a unique iframe for the form
        iframe = $(&quot;&lt;iframe&gt;&lt;/iframe&gt;&quot;).attr('name', 'ajax_form_' + Math.floor(Math.random() * 999999)).hide().appendTo($('body'));
       $form.attr('target', iframe.attr('name'));
 
    }
  

   
        iframe = iframe || $('iframe[name=&quot; ' + $form.attr('target') + ' &quot;]');
        iframe.on("load",function ()
        {
            //get the server response
            var response = iframe.contents().find('body').text();
            var obj=JSON.parse(response);
                    
                    if(obj.type==&quot;success&quot;){
                    $(&quot;.notify&quot;).html(&quot;&lt;div class='alert alert-success'&gt;&lt;p&gt;&quot;+obj.message+&quot;&lt;/p&gt;&lt;/div&gt;&quot;)  
                      $form.trigger( 'reset' );
                    }else {
                   $(&quot;.notify&quot;).html(&quot;&lt;div class='alert alert-danger'&gt;&lt;p&gt;&quot;+obj.message+&quot;&lt;/p&gt;&lt;/div&gt;&quot;)    
    
                    }
                    $(&quot;.notify&quot;).show(); 
        });
        
       
})</textarea>
        </div>

    </div>

</div>