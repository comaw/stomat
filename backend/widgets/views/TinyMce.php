<?php
/**
 * powered by php-shaman
 * TinyMce.php 04.01.2016
 * Naturalniy kamen
 */
?>

<?php
$jsView = <<<HTML
tinymce.init({
    language:"ru",
    selector: '.myTinyMce',
     height : 300,
     plugins: "textcolor, advlist, anchor, autolink, autoresize, autosave, code, codesample, contextmenu, emoticons, " +
     "fullscreen, hr, image, imagetools, importcss, insertdatetime, layer, legacyoutput, link, lists, media, nonbreaking, noneditable," +
     "pagebreak, paste, preview, save, searchreplace, spellchecker, tabfocus, table, textpattern, visualblocks, visualchars, wordcount, responsivefilemanager",
     toolbar: "forecolor backcolor, anchor, code, codesample, link image inserttable | cell row column deletetable, ltr rtl, emoticons, " +
     "fullscreen, image, insertdatetime, link, media, nonbreaking, pagebreak, paste, preview, save, searchreplace, spellchecker, table, visualblocks," +
     "visualchars, responsivefilemanager",
     menubar: "insert, tools, file, view, format, edit, table",
     relative_urls: true,
     remove_script_host : false,
     browser_spellcheck : false ,
     image_advtab: true,
     convert_urls : false,
     filemanager_title:"Responsive Filemanager",
     external_filemanager_path:"/filemanager/",
     external_plugins: { "filemanager" : "/admin/tinymce/filemanager/plugin.js"}
  });
HTML;

?>

<?php $this->registerJsFile('admin/tinymce/js/tinymce/tinymce.min.js', ['depends' => ['yii\web\YiiAsset', 'yii\bootstrap\BootstrapAsset']]); ?>
<?php $this->registerJs($jsView); ?>
