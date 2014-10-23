<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset='utf-8'>
    
    <!-- SET CSS -->
    <link rel='stylesheet' href='<?=base_url();?>css/default.css' type='text/css' media='screen'/>
    <link rel='stylesheet' href='<?=base_url();?>css/kasir/default.css' type='text/css' media='screen'/>
    
    <!-- SET JS -->
    <script type='text/javascript' src='<?=base_url();?>js/jquery-1.9.1.min.js'></script>
    <script type='text/javascript' src='<?=base_url();?>js/default.js'></script>

    <?php
        //SET CUSTOM CSS
        if (isset($css_list)) { foreach ($css_list as $css) {
            ?><link rel='stylesheet' href='<?=base_url();?>css/<?=$css?>.css' type='text/css' media='screen'/><?php } }
        
        //SET CUSTOM JS
        if (isset($js_list)) { foreach ($js_list as $js) {
            ?><script type='text/javascript' src='<?=base_url();?>js/<?=$js?>.js'></script><?php } }
    ?>
    
</head>
<body>
<!-- START OF CONTAINER -->
<div id='container'>