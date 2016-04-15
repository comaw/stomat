<?php
class cmsWysiwygTinymce{
	function __construct(){}
	public function displayEditor($field_id, $content=''){

        $lang = cmsConfig::get('language');
		$user = cmsUser::getInstance();
        cmsTemplate::getInstance()->addJS('wysiwyg/tinymce/tinymce.min.js');
        
        $dom_id = str_replace(array('[',']'), array('_', ''), $field_id);

       echo html_textarea($field_id, $content, array('id'=>$dom_id));
 
?><script type="text/javascript" >
$(document).ready(function(){
 	tinymce.init({mode : "exact", 
	              elements : "<?php echo $field_id; ?>",
				  language : "ru",
				 plugins: [
         "link image lists media responsivefilemanager "
   ],
    relative_urls: false,
   
    filemanager_title:"Responsive Filemanager",
    external_filemanager_path:"/filemanager/",
    external_plugins: { "filemanager" : "/filemanager/plugin.min.js"},
    
				  image_advtab: true,
   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
   toolbar2: "| responsivefilemanager | image | media | link unlink anchor | "
	   			  
				  });
				  });
</script>
<?php
	}
}
/*

			
			image_advtab: true ,
   external_filemanager_path:"filemanager/",
   filemanager_title:"Responsive Filemanager" ,
   external_plugins: { "filemanager" : "filemanager/plugin.min.js"},
	responsivefilemanager	
*/	