<?php 
/***************************
 Get Plugin Backend URL
 :- Args: Data String
****************************/
function ht_get_url($page) {
	if($page) {
		return get_admin_url(get_current_blog_id(),'admin.php?page=ht_'.$page);
	}
}

/***********************
 Status cases
 :- Args: Data Strings
************************/
function ht_status_info($step,$status) {
	$status_msg = "";
	switch($step) {
		case 'entries':
			switch($status) {
				case 'info':
		    	$status_msg = '<strong>Welcome!</strong> Start creating headlines.';
				break;
				case 'alert':
		    	$status_msg = '<strong>Alert!</strong> There are no headlines.';
				break;
				case 'success-add':
		    	$status_msg = '<strong>Success!</strong> You have created headline.';
				break;
				case 'success-update':
		    	$status_msg = '<strong>Success!</strong> You have updated headline.';
				break;
				case 'success-delete':
		    	$status_msg = 'Headline deleted.';
				break;
				case 'error':
		    	$status_msg = '<strong>Error!</strong> Something went wrong. Please try again';
				break;
			} 
		break;
		case 'categories':
			switch($status) {
				case 'info':
		    	$status_msg = '<strong>Welcome!</strong> Start creating categories.';
				break;
				case 'alert':
		    	$status_msg = '<strong>Alert!</strong> There are no categories.';
				break;
				case 'success-add':
		    	$status_msg = '<strong>Success!</strong> You have created new category.';
				break;
				case 'success-update':
		    	$status_msg = '<strong>Success!</strong> You have updated category.';
				break;
				case 'success-delete':
		    	$status_msg = 'Category deleted.';
				break;
				case 'error':
		    	$status_msg = '<strong>Error!</strong> Something went wrong. Please try again';
				break;
			} 
		break;
	}
	
	$status = str_replace('-add','',$status);
	$status = str_replace('-update','',$status);
	$status = str_replace('-delete','',$status);

	if($status) {
		echo '<div class="alert alert-'.$status.'">
		  			<button type="button" class="close" data-dismiss="alert">x</button>
		      	'.$status_msg.'
		  		</div>';
	}
}


/********************************
 HT Debug String/Array
 :- Args: Label, Value
*********************************/
function ht_debug($label, $data) {
	return "<div style=\"margin-left: 40px;background-color:#eeeeee;\"><u><h3>".$label."</h3></u><pre style=\"border-left:2px solid #000000;margin:10px;padding:4px;\">".print_r($data, true)."</pre></div>";
}


/********************************
 HT Redirect String
 :- Args: Value
*********************************/
function ht_redirect($url) {
	if($url) {
		echo "<script>location.href='".$url."';</script>";
	}
}

/********************************
 HT Settings
 :- Args: Key
*********************************/
function ht_options($key) {
$settings = get_option( 'ht_settings_options' );
	if($key) {
		return $settings[$key];
	}
	else {
		return $settings;
	}
}


/********************************
 HT Generate URL
 :- Args: Value

*********************************/
function ht_url($atts = '') {
	$pageURL = get_permalink();
	if($atts) {
		if ( get_option('permalink_structure') ) {
			$pageURL = $pageURL.'?'.$atts;
		}
		else {
			$pageURL = $pageURL.'&'.$atts;
		}
	}
	return $pageURL;
}


/********************************
 HT serialize Children
 :- Args: Array (2)
*********************************/
function ht_serialize($child_names, $child_dobs) {
	if(count($child_names) > 0) {
		foreach($child_names as $key=>$child_name) {
			$child_array[] = array('name'=>$child_name, 'dob'=>$child_dobs[$key]); 
		}
	}
	return $children = serialize($child_array);
}


/****************************************
 Check and Insert Entry and return ID
 :- Args : Data Array
******************************************/
function ht_create_entry($data) {
	global $wpdb;
	$table = HT_ENTRIES_TABLE;
	if(!empty($data['title'])) { // Checking
		$wpdb->insert( $table, $data );
		$entry_id = $wpdb->insert_id;
	}
	return $entry_id;
}


/****************************************
 Check and Update Entry and return ID
 :- Args : Data Array
******************************************/
function ht_update_entry($entry_id,$data) {
	global $wpdb;
	$table = HT_ENTRIES_TABLE;
	$where = array('id'=>$entry_id);
	if(!empty($data['title'])) { // Checking
		$wpdb->update($table, $data, $where);
	}
	return $entry_id;
}

/****************************************
 Delete Entry
 :- Args : Entry ID
******************************************/
function ht_delete_entry($entry_id) {
	global $wpdb;
	$status = 0;
	$table = HT_ENTRIES_TABLE;
	$where = array('id'=>$entry_id);
	if(!empty($entry_id)) { // Checking
		$wpdb->delete($table, $where);
		$status = 1;
	}
	return $status;
}

/*************************
 Get Entries 
 :- Args : Data Number
*************************/
function ht_get_entries($cat=null) {
	global $wpdb;
	$table = HT_ENTRIES_TABLE;
	$dataQuery = "";
	if(!empty($cat)) {
		$dataQuery = "WHERE cid=".$cat;	
	}
	$output = $wpdb->get_results( "SELECT * FROM $table $dataQuery ORDER BY date DESC" );
	return $output;
}

/*************************
 Get Limited Entries 
 :- Args : Data Number
*************************/
function ht_get_limited_entries($cat=null,$start=0,$limit=5) {
	global $wpdb;
	$table = HT_ENTRIES_TABLE;
	$dataQuery = "";
	if(!empty($cat)) {
		$dataQuery = "WHERE cid=".$cat;	
	}
	$output = $wpdb->get_results( "SELECT * FROM $table $dataQuery ORDER BY date DESC LIMIT $start, $limit" );
	return $output;
}

/******************************
 Get Single Entry 
 :- Args : Data Number ID
*******************************/
function ht_get_entry($entry_id) {
	global $wpdb;
	$table = HT_ENTRIES_TABLE;
	$output = $wpdb->get_row( "SELECT * FROM $table WHERE id=$entry_id" );
	return $output;
}


/****************************************
 Check and Insert Category and return ID
 :- Args : Data Array

******************************************/
function ht_create_category($data) {
	global $wpdb;
	$table = HT_CATEGORY_TABLE;
	if(count($data) > 0) { // Checking
		$wpdb->insert( $table, $data );
		$cat_id = $wpdb->insert_id;
	}
	return $cat_id;
}


/****************************************
 Check and Update Category and return ID
 :- Args : Data Array
******************************************/
function ht_update_category($cat_id,$data) {
	global $wpdb;
	$table = HT_CATEGORY_TABLE;
	$where = array('cid'=>$cat_id);
	if(count($data) > 0) { // Checking
		$wpdb->update($table, $data, $where);
		return $cat_id;
	}
}

/****************************************
 Delete Category
 :- Args : Cat ID
******************************************/
function ht_delete_category($cat_id) {
	global $wpdb;
	$status = 0;
	$table = HT_CATEGORY_TABLE;
	$where = array('cid'=>$cat_id);
	if(!empty($cat_id)) { // Checking
		$wpdb->delete($table, $where);
		$status = 1;
	}
	return $status;
}

/*************************
 Get Categories 
 :- Args : none
*************************/
function ht_get_categories() {
	global $wpdb;
	$table = HT_CATEGORY_TABLE;
	$output = $wpdb->get_results( "SELECT * FROM $table" );
	return $output;
}

/******************************
 Get Single Category 
 :- Args : Data Number ID
*******************************/
function ht_get_category($cat_id) {
	global $wpdb;
	$table = HT_CATEGORY_TABLE;
	$output = $wpdb->get_row( "SELECT * FROM $table WHERE cid=$cat_id" );
	return $output;
}

/******************************
 Get Single Category Title
 :- Args : Data Number ID
*******************************/
function ht_get_category_title($cat_id) {
	$category = ht_get_category($cat_id);
	return $category->title;
}

/*********************************************
	Get Lat and Lng of address from Google map.
 :- Args : Data String-Address
**********************************************/
function ht_get_lat_lng($address) {
	if($address) {
		$output = array();
		$google_map = simplexml_load_file('http://maps.googleapis.com/maps/api/geocode/xml?address='.$address.'&sensor=true');
		$output['latitude'] = $google_map->result->geometry->location->lat;
		$output['longitude'] = $google_map->result->geometry->location->lng;
		return $output;
	}
}

?>
