<?php
/*
 * Add my new menu to the Admin Control Panel
 */
 
function scfw_menu(){
  add_menu_page('SCFW - Order List', 'SCFW', 'manage_options', 'scfw-options', 'scfw_orders_list');
  add_submenu_page( 'scfw-options', 'Settings page title', 'Teste Ajax', 'manage_options', 'scfw-op-settings', 'scfw_theme_func_settings');
  add_submenu_page( 'scfw-options', 'FAQ page title', 'FAQ menu label', 'manage_options', 'scfw-op-faq', 'scfw_theme_func_faq');
}
add_action('admin_menu', 'scfw_menu');
 
function scfw_orders_list(){
	require_once plugin_dir_path(__FILE__) . '../order/list/scfw-list.php';
}
function scfw_theme_func_settings(){
	//echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
	//<h2>Settings</h2></div>';
	require_once plugin_dir_path(__FILE__) . '../testeajax/single.php';
}
function scfw_theme_func_faq(){
	echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
	<h2>FAQ</h2></div>';
}



function download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}