<?php
/***********************
  Plugin Main Core Files
***********************/
require_once ( 'entries.php' ); // Entries
require_once ( 'shortcodes.php' ); // Plugin Settings


// Add Scripts and css in backend.
add_action( 'admin_enqueue_scripts', 'ht_admin_enqueue_scripts' );
function ht_admin_enqueue_scripts( $hook_suffix ) {
  // first check that $hook_suffix is appropriate for your admin page
	wp_enqueue_script( 'jquery-ui-datepicker' );
  wp_enqueue_script( 'ht-data-tables', HT_PLUGIN_URL . '/admin/js/jquery.dataTables.min.js', array( 'jquery' ), false, true );
  wp_enqueue_script( 'ht-admin-scripts', HT_PLUGIN_URL . '/admin/js/admin-scripts.js', array( 'jquery' ), false, true );
  wp_enqueue_style( 'ht-admin-dataTables', HT_PLUGIN_URL . '/admin/css/jquery.dataTables.css', array(), '', 'all' );
  wp_enqueue_style( 'ht-admin-datepicker', HT_PLUGIN_URL . '/admin/css/jquery.ui.datepicker.css', array(), '', 'all' );
  wp_enqueue_style( 'ht-admin-styles', HT_PLUGIN_URL . '/admin/css/admin.css', array(), '', 'all' );
  wp_enqueue_media();
}

?>
