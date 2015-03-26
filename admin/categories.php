<?php function ht_categories() {
global $wpdb;
$url = ht_get_url('categories'); //Current page url

/******************
 Common Requests
******************/
$step 			= 'categories'; //Reset to Step
$title 			= '';
$category 	= '';
$category_url 	= '';

$action 	= $_REQUEST['action'];
$status 	= $_REQUEST['status'];

$category_id = $_REQUEST['id'];

$categories = ht_get_categories();
									
if(!$status && !$action && count($categories)==0) {
 $status 	= 'info'; //Reset to Status for Step 
}

/**************
 Action Delete 
***************/
if($action == 'delete' && !empty($category_id)) {
	$status = ht_delete_category($category_id);
	if($status == 1) {
		ht_redirect($url.'&status=success-delete');	
	}
	else {
		$status = 'error';
	}
}


/**************
 Action Edit 
***************/
if($action == 'edit' && !empty($category_id)) {
	$category = ht_get_category($category_id);
	$title 		= $category->title;
	$category_url	= $category->url;
}


/*****************
 Create Entry Step
******************/
if(isset($_REQUEST['category_add'])) {
	if(!empty($_REQUEST['category_add'])) {
		$data = array();
		$data['title'] 		= $_POST['title'];
		$data['url'] 			= $_POST['category_url'];
		$category_id 			= ht_create_category($data);
		if($category_id) {
			ht_redirect($url.'&status=success-add');
		}
		else {
			$status = 'error';
		}
	}
}

/*****************
 Update Entry Step
******************/
if(isset($_REQUEST['category_update'])) {
	if(!empty($_REQUEST['category_update'])) {
		$data = array();
		$data['title'] 		= $_POST['title'];
		$data['url'] 			= $_POST['category_url'];
		$category_id 			= ht_update_category($category_id, $data);
		if($category_id) {
			ht_redirect($url.'&status=success-update');
		}
		else {
			$status = 'error';
		}
	}
}

?>
<div class="wrap ht_wrap">
	<h2><?php _e('Headlines Tool - Categories'); if(!$action) { ?> <a class="add-new-h2 button-primary" href="<?php echo $url; ?>&action=add"><?php _e('Add New Category'); ?></a><?php } ?></h2>
	<div class="ht_container">
		<?php ht_status_info($step,$status); ?>
		<?php if($action == 'edit' || $action == 'add') { //Form Add/Edit Area ?>
			<div class="ht_form_add">
				<form method="post" name="entry_action" class="data-form" action="" id="entry_action">
					<table id="general-tab" class="form-table ht_setting_table">
						<tr valign="top">
							<th scope="row"><?php _e('Title'); ?></th>
							<td>
								<input type="text" id="title" name="title" class="ht_input regular-text data-required" value="<?php echo $title; ?>"  />
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Category URL'); ?></th>
							<td><input type="text" id="category_url" name="category_url" class="ht_input regular-text" value="<?php echo $category_url; ?>"  /></td>
						</tr>
					</table>
					<p class="submit">
					<?php if($action == 'add') { ?><input type="submit" id="ht-submit" class="button-primary" name="category_add" value="<?php _e( 'Submit'); ?>" /><?php }
					else { ?><input type="submit" class="button-primary" id="ht-submit" name="category_update" value="<?php _e( 'Update'); ?>" /><?php } ?>
					<a class="button" href="<?php echo $url; ?>"><?php _e('Cancel'); ?></a>
					</p>
				</form>
			</div>
		<?php }
		else if(!$action) { // List of forms ?>
			<table class="table table-striped table-bordered" id="ht_dyntable">
		        <colgroup>
		            <col class="con0" />
		            <col class="con1" />
		            <col class="con0" />
		        </colgroup>
		        <thead>
		            <tr>
									<th class="head0"><?php _e('Category'); ?></th>
		              <th class="head0"><?php _e('Edit'); ?></th>
		              <th class="head1"><?php _e('Delete'); ?></th>
		            </tr>
		        </thead>
		        <tbody>
						<?php if(count($categories)) { 
										foreach($categories as $category) { ?>
		            <tr class="gradeX">
		                <td><?php echo stripslashes($category->title); ?></td>
		                <td><a href="<?php echo $url; ?>&action=edit&id=<?php echo $category->cid; ?>" class="button"><?php _e('Edit'); ?></a></td>
		                <td><a href="<?php echo $url; ?>&action=delete&id=<?php echo $category->cid; ?>" class="button ht_delete"><?php _e('Delete'); ?></a></td>
		            </tr>
							<?php } } ?>
		        </tbody>
      		</table>
		<?php } ?>			
		
	</div> <!-- end container -->
</div> <!-- end wrapper -->
<?php } ?>
