<?php function ht_shortcodes() {
global $wpdb;

/******************
 Common Requests
******************/
$url = ht_get_url('shortcodes'); //Current page url

/***************
 Load Categories 
****************/
$categories = ht_get_categories();


?>
<div class="wrap ht_wrap">
	﻿<div class="add_new"><div id="icon-edit-pages" class="icon32"><br></div><h2><?php _e('Headlines Tool Shortcodes'); ?></h2></div>
	<div class="ht_container">
			<div class="ht_form_add">
				<form method="post" name="shortcodes_form" action="" id="shortcodes_form_default" class="shortcodes_form">
					<table class="form-table ht_setting_table" width="50%">
						<tr valign="top">
							<th scope="row"><?php _e('Select Category'); ?></th>
							<td>
								<select id="shortcode_category" class="ht_input regular-text" name="shortcode_category">
									<option value=""><?php echo esc_attr( __( 'All Categories' ) ); ?></option>
									<?php if(count($categories) > 0) {
									foreach($categories as $category) {  ?>
									<option value="<?php echo $category->cid; ?>"><?php echo $category->title; ?></option>
									<?php } } ?>
								</select>
							</td>
							<td>
								<input type="submit" id="generate_shortcode" class="button-primary" name="generate_shortcode" value="<?php _e( 'Generate'); ?>" />
							</td>
						</tr>
						</tr>
					</table>
					<p align="center"><input type="text" id="ht_shortcode" class="ht_shortcode" title="Copy shortcode" name="ht_shortcode" value="[headlines-tool]" /></p>
				</form>
			</div>		
			<hr />
			<div class="ht_form_add">
				<h3>Shortcode for widget</h2>
				<form method="post" name="shortcodes_form_widget" action="" id="shortcodes_form_widget" class="shortcodes_form">
					<table class="form-table ht_setting_table" width="50%">
						<tr valign="top">
							<th scope="row"><?php _e('View all link'); ?></th>
							<td colspan="2">
								<input type="text" id="shortcode_widget_link" style="width: 21em" class="ht_input regular-text" name="shortcode_widget_link" value="" />
							</td>
						</tr>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Number of headlines'); ?></th>
							<td>
								<input type="text" id="shortcode_widget_limit" class="ht_input" name="shortcode_widget_limit" value="3" />
							</td>
							<td>
								<input type="submit" id="generate_shortcode_widget" class="button-primary" name="generate_shortcode_widget" value="<?php _e( 'Generate'); ?>" />								
							</td>
						</tr>
					</table>
					<p align="center"><input type="text" id="ht_shortcode_widget" class="ht_shortcode" title="Copy shortcode" name="ht_shortcode_widget" value="[headlines-tool-widget limit=3]" /></p>
				</form>
			</div>	

	</div> <!-- end container -->
</div> <!-- end wrapper -->
<?php } ?>
