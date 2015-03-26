<?php /*
  Plugin Name: Headlines Tool
  Description: Create custom headlines with links and categories and display in accordion style using shortcode.
  Author: Softscripts
  Author URI: http://www.softscripts.net
  Version: 1.0
 */
global $wpdb;
$siteurl = get_bloginfo('url');
/* Define WPSF TABLES */
define('HT_PLUGIN_URL', WP_PLUGIN_URL.'/headlines-tool');
define("HT_CATEGORY_TABLE", $wpdb->prefix . "ht_categories");
define("HT_ENTRIES_TABLE", $wpdb->prefix . "ht_entries");

/* Load all functions */
require_once ( 'functions/functions.php' ); // Load Utility Functions
require_once ( 'functions/class.PaginationLinks.php' ); // Load Frontend
require_once ( 'admin/index.php' ); // Load Backend Modules
require_once ( 'frontend/index.php' ); // Load Frontend Display

add_action('admin_menu','ht_backend_menu');

function ht_backend_menu() {
	add_menu_page('Headlines Tool','Headlines Tool','manage_options','ht_entries','ht_entries', 'dashicons-menu', 24);
	add_submenu_page('ht_entries','Categories','Categories','manage_options','ht_categories','ht_categories');
	add_submenu_page('ht_entries','Shortcodes','Shortcodes','manage_options','ht_shortcodes','ht_shortcodes');
}

// this hook will cause our creation function to run when the plugin is activated
register_activation_hook( __FILE__, 'ht_plugin_install' );

function ht_plugin_install() {
	global $wpdb; // do NOT forget this global
 
	if($wpdb->get_var("show tables like '". HT_CATEGORY_TABLE) != HT_CATEGORY_TABLE)  {
			$wpdb->query("CREATE TABLE IF NOT EXISTS `". HT_CATEGORY_TABLE . "` (`cid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY , `title` VARCHAR( 250 ) NOT NULL, `url` TEXT NOT NULL, `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)");
		}
		if($wpdb->get_var("show tables like '". HT_ENTRIES_TABLE) != HT_ENTRIES_TABLE)  {
			$wpdb->query("CREATE TABLE IF NOT EXISTS `". HT_ENTRIES_TABLE . "` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY , `cid` INT NOT NULL, `title` VARCHAR( 250 ) NOT NULL, `comments` TEXT NOT NULL, `url` VARCHAR( 250 ) NOT NULL, `date` VARCHAR( 250 ) NOT NULL, `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, `status` VARCHAR( 200 ) NOT NULL)");
		}
	update_option('disable_ht_admin_message',1);

}

function ht_admin_messages() {
	//If we're editing the events page show hello to new user
	$dismiss_link_joiner = ( count($_GET) > 0 ) ? '&amp;':'?';
	
	if( current_user_can('activate_plugins') ){
		//New User Intro
		if (isset ( $_GET ['disable_ht_admin_message'] ) && $_GET ['disable_ht_admin_message'] == 'true'){
			// Disable Hello to new user if requested
			update_option('disable_ht_admin_message',0);
		}elseif ( get_option ( 'disable_ht_admin_message' ) ) {
			
			$advice = sprintf( __("<p><strong>Headlines Tool</strong> plugin is ready to go! <a href='%s'>Click here</a> to start adding data. <a href='%s' title='Don't show this advice again' style='margin-left: 50px;'>Dismiss</a></p>", 'ht'), ht_get_url('entries'),  $_SERVER['REQUEST_URI'].$dismiss_link_joiner.'disable_ht_admin_message=true');
			?>
			<div id="message" class="updated">
				<?php echo $advice; ?>
			</div>
			<?php
		}
	}
}

add_action ( 'admin_notices', 'ht_admin_messages', 100 );

// Add settings link on plugin page
function ht_settings_link($links) { 
  $forms_link = '<a href="'.ht_get_url('entries').'">Headlines</a>';
  array_unshift($links, $forms_link);
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'ht_settings_link' );


// this hook will cause our creation function to run when the plugin is deactivated
register_deactivation_hook( __FILE__,'ht_plugin_uninstall');

function ht_plugin_uninstall() {
	global $wpdb; // do NOT forget this global
 	delete_option('disable_ht_admin_message');
	delete_option('ht_settings_options');
   //$wpdb->query("DROP TABLE IF EXISTS ".HT_CATEGORY_TABLE);
   //$wpdb->query("DROP TABLE IF EXISTS ".HT_ENTRIES_TABLE);
}
?>
