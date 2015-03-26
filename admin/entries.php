<?php function ht_entries() {
global $wpdb;
$url = ht_get_url('entries'); //Current page url

/******************
 Common Requests
******************/
$step 			= 'entries'; //Reset to Step$title 		= '';
$category 	= '';
$entry_url 	= '';
$comments 	= '';
$date 			= '';
$entry_status 	= '';

$action 	= $_REQUEST['action'];
$status 	= $_REQUEST['status'];

$entry_id = $_REQUEST['id'];

$entries = ht_get_entries();
									
if(!$status && !$action && count($entries)==0) {
 $status 	= 'info'; //Reset to Status for Step 
}

/**************
 Action Delete 
***************/
if($action == 'delete' && !empty($entry_id)) {
	$status = ht_delete_entry($entry_id);
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
if($action == 'edit' && !empty($entry_id)) {
	$entry 		= ht_get_entry($entry_id);
	$title 		= $entry->title;
	$entry_category = $entry->cid;
	$entry_url 			= $entry->url;
	$comments = $entry->comments;
	$date 		= $entry->date;
	$entry_status 	= $entry->status;
}


/*****************
 Create Entry Step
******************/
if(isset($_REQUEST['entry_add'])) {
	if(!empty($_REQUEST['entry_add'])) {
		$category_new 		= $_POST['category_new'];
		if(empty($_POST['category'])) {			
			$cat_id	 				= ht_create_category(array('title'=>$category_new));
		}
		else {
			$cat_id					= $_POST['category'];
		}
		$data = array();
		$data['title'] 		= $_POST['title'];
		$data['cid'] 			= $cat_id;
		$data['comments'] = $_POST['comments'];
		$data['url'] 			= $_POST['entry_url'];
		$data['date'] 		= $_POST['date'];
		$data['status'] 	= $_POST['entry_status'];
		$entry_id 				= ht_create_entry($data);
		if($entry_id) {
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
if(isset($_REQUEST['entry_update'])) {
	if(!empty($_REQUEST['entry_update'])) {
		$category_new 		= $_POST['category_new'];
		if(empty($_POST['category'])) {			
			$cat_id	 				= ht_create_category(array('title'=>$category_new));
		}
		else {
			$cat_id					= $_POST['category'];
		}		
		$data = array();
		$data['title'] 		= $_POST['title'];
		$data['cid'] 			= $cat_id;
		$data['comments'] = $_POST['comments'];
		$data['url'] 			= $_POST['entry_url'];
		$data['date'] 		= $_POST['date'];
		$data['status'] 	= $_POST['entry_status'];
		$entry_id 				= ht_update_entry($entry_id, $data);
		if($entry_id) {
			ht_redirect($url.'&status=success-update');
		}
		else {
			$status = 'error';
		}
	}
}

/***************
 Load Categories 
****************/
$categories = ht_get_categories();


?>
<div class="wrap ht_wrap">
	<h2><?php _e('Headlines Tool'); if(!$action) { ?> <a class="add-new-h2 button-primary" href="<?php echo $url; ?>&action=add"><?php _e('Add New Headline'); ?></a><?php } ?></h2>
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
							<th scope="row"><?php _e('URL to story'); ?></th>
							<td><input type="text" id="entry_url" name="entry_url" class="ht_input regular-text data-required" value="<?php echo $entry_url; ?>"  /></td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Comments'); ?></th>
							<td><textarea id="comments" name="comments" class="ht_input regular-text"><?php echo $comments; ?></textarea></td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( 'Category'); ?></th>
							<td>
								<select id="category" class="ht_input regular-text" name="category">
									<option value=""><?php echo esc_attr( __( 'Select' ) ); ?></option>
									<?php if(count($categories) > 0) {
									foreach($categories as $category) {  ?>
									<option value="<?php echo $category->cid; ?>" <?php if($category->cid == $entry_category) { echo 'selected="selected"'; } ?>><?php echo $category->title; ?></option>
									<?php } } ?>
								</select>
								<a href="#" class="button add-new-category">Add New</a>
							</td>
						</tr>
						<tr valign="top" style="display: none;" class="new-category">
							<th scope="row"></th>
							<td><input type="text" id="category_new" name="category_new" class="ht_input regular-text" value=""  /></td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Date'); ?></th>
							<td><input type="text" id="entry_date" name="date" class="ht_input regular-text data-required" value="<?php echo $date; ?>"  /></td>
						</tr>
					</table>
					<p class="submit">
						<input type="hidden" id="entry_status" name="entry_status" class="ht_input" value="1" />
					<?php if($action == 'add') { ?><input type="submit" id="ht-submit" class="button-primary" name="entry_add" value="<?php _e( 'Submit'); ?>" /><?php }
					else { ?><input type="submit" class="button-primary" id="ht-submit" name="entry_update" value="<?php _e( 'Update'); ?>" /><?php } ?>
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
		            <col class="con1" />
		            <col class="con0" />
		        </colgroup>
		        <thead>
		            <tr>
	                <th class="head0"><?php _e('Headline'); ?></th>
									<th class="head0"><?php _e('Category'); ?></th>
		              <th class="head1"><?php _e('Date'); ?></th>
		              <th class="head0"><?php _e('Edit'); ?></th>
		              <th class="head1"><?php _e('Delete'); ?></th>
		            </tr>
		        </thead>
		        <tbody>
						<?php if(count($entries)) { 
										foreach($entries as $entry) { ?>
		            <tr class="gradeX">
		                <td><?php echo stripslashes($entry->title); ?></td>
			 					    <td><?php echo stripslashes(ht_get_category_title($entry->cid)); ?></td>
		                <td><?php echo date("m/d/Y", strtotime($entry->date)); ?></td>
		                <td><a href="<?php echo $url; ?>&action=edit&id=<?php echo $entry->id; ?>" class="button"><?php _e('Edit'); ?></a></td>
		                <td><a href="<?php echo $url; ?>&action=delete&id=<?php echo $entry->id; ?>" class="button ht_delete"><?php _e('Delete'); ?></a></td>
		            </tr>
							<?php } } ?>
		        </tbody>
      		</table>
		<?php } ?>			
		
	</div> <!-- end container -->
</div> <!-- end wrapper -->
<?php } ?>
