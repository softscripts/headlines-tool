<?php
require_once ( 'display.php' ); // Load Frontend
add_shortcode('headlines-tool', 'headlines_tool');
add_shortcode('headlines-tool-widget', 'headlines_tool_widget');
add_filter('widget_text', 'do_shortcode');

add_action('wp_enqueue_scripts', 'ht_enqueue_scripts' );
function ht_enqueue_scripts(){
  // first check that $hook_suffix is appropriate for your admin page
  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'ht-scripts', HT_PLUGIN_URL . '/frontend/js/scripts.js', array( 'jquery' ), false, false );
  wp_enqueue_style( 'ht-styles', HT_PLUGIN_URL . '/frontend/css/styles.css', array(), '', 'all' );
}

?>
