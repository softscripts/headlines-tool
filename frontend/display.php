<?php 
/********************************
 Shortcodes Output
*********************************/
function headlines_tool( $atts, $content = null ) { 
   extract( shortcode_atts( array(
     'cat' => '',
   ), $atts ) );
	$categories = ht_get_categories();
	$ht_cat = $_REQUEST['ht_cat'];
	$entry_limit = 3;
	$ht_page_limit = 20;

	$output = '<div id="ht-main" class="ht-container">';
	if(!empty($ht_cat)) {
		$ht_page	= $_REQUEST['ht_page'];
		if(empty($ht_page)) { $ht_page = 1; }
		$ht_page_current = ($ht_page-1)*$ht_page_limit;
		$category = ht_get_category($ht_cat);
		$total_entries = count(ht_get_entries($category->cid));
		$total_pages	= round($total_entries/$ht_page_limit);
		$entries = ht_get_limited_entries($category->cid,$ht_page_current,$ht_page_limit);
		if(count($entries) > 0) {
			$output.= '<div class="link-summary">';
				$output.= '<h2 class="link-summary-title">'.stripslashes($category->title).'</h2>';
				$output.= '<div class="link-summary-content collapse in" id="ht-link-category-'.$category->cid.'">';
				foreach($entries as $entry) {
					$output.= '<p	class="link-summary-content-item">';
						$output.= '<a href="'.$entry->url.'" target="_blank" rel="nofollow" title="'.stripslashes($entry->title).'">'.stripslashes($entry->title).'</a>';
						$output.= ' - <span class="link-summary-content-date">'.date("m/d/Y", strtotime($entry->date)).'</span>';
						if($entry->comments) {
							$output.= '<span class="link-summary-content-description">'.stripslashes($entry->comments).'</span>';
						}
					$output.= '</p>';
				}
				if($total_entries > $ht_page_limit) {
				$output.= '<p	class="link-summary-content-pagination">';
				$output.= PaginationLinks::create($ht_page, $total_pages, 10, '<a href="'.ht_url('ht_cat='.$category->cid.'&ht_page=%d#ht-main').'" rel="nofollow">%d</a>');
				$output.= '</p>';
				}
				$output.= '</div>';
			$output.= '</div>';
		}

	}
	else {
		if(!empty($cat)) {
			$category = ht_get_category($cat);
			$Allentries = ht_get_entries($category->cid);
			$entries = ht_get_limited_entries($category->cid,0,$entry_limit);
			if(count($entries) > 0) {
				$output.= '<div class="link-summary">';
					$output.= '<h2 class="link-summary-title">'.stripslashes($category->title).'</h2>';
					$output.= '<div class="link-summary-content" id="ht-link-category-'.$category->cid.'">';
					foreach($entries as $entry) {
						$output.= '<p	class="link-summary-content-item">';
							$output.= '<a href="'.$entry->url.'" target="_blank" rel="nofollow" title="'.stripslashes($entry->title).'">'.stripslashes($entry->title).'</a>';
							$output.= ' - <span class="link-summary-content-date">'.date("m/d/Y", strtotime($entry->date)).'</span>';
							if($entry->comments) {
								$output.= '<span class="link-summary-content-description">'.stripslashes($entry->comments).'</span>';
							}
						$output.= '</p>';
					}
						if(count($Allentries) > $entry_limit)   {
							$output.= '<p	class="link-summary-content-read-more"><a href="'.ht_url('ht_cat='.$category->cid.'#ht-main').'" rel="nofollow">See More..</a></p>';
						}
					$output.= '</div>';
				$output.= '</div>';
			}

		}
		else {
			if(count($categories) > 0) {
				foreach($categories as $category) {
					$Allentries = ht_get_entries($category->cid);
					$entries = ht_get_limited_entries($category->cid,0,$entry_limit);
					if(count($entries) > 0) {
						$output.= '<div class="link-summary">';
							$output.= '<h2 class="link-summary-title">'.stripslashes($category->title).'</h2>';
							$output.= '<div class="link-summary-content" id="ht-link-category-'.$category->cid.'">';
							foreach($entries as $entry) {
								$output.= '<p	class="link-summary-content-item">';
									$output.= '<a href="'.$entry->url.'" target="_blank" rel="nofollow" title="'.stripslashes($entry->title).'">'.stripslashes($entry->title).'</a>';
									$output.= ' - <span class="link-summary-content-date">'.date("m/d/Y", strtotime($entry->date)).'</span>';
									if($entry->comments) {
										$output.= '<span class="link-summary-content-description">'.stripslashes($entry->comments).'</span>';
									}
								$output.= '</p>';
							}
								if(count($Allentries) > $entry_limit) { 
								$output.= '<p	class="link-summary-content-read-more"><a href="'.ht_url('ht_cat='.$category->cid.'#ht-main').'" rel="nofollow">See More..</a></p>';
								}
							$output.= '</div>';
						$output.= '</div>';
					}
				}
			}
		}
	}
	$output.= '</div>';

	return $output;
}


/*********************
 Widget Shortcode
*********************/
function headlines_tool_widget( $atts, $content = null ) { 
   extract( shortcode_atts( array(
     'limit' => '3',
     'link' => '',
   ), $atts ) );

	$output = '<div id="ht-main" class="ht-container ht-widget-container">';
		$total_entries = count(ht_get_entries());
		$entries = ht_get_limited_entries(null,0,$limit);
		if(count($entries) > 0) {
			$output.= '<div class="link-summary">';
				foreach($entries as $entry) {
					$output.= '<p	class="link-summary-content-item ht-widget-item">';
						$output.= '<a href="'.$entry->url.'" target="_blank" rel="nofollow" title="'.stripslashes($entry->title).'">'.stripslashes($entry->title).'</a>';
						$output.= ' - <span class="link-summary-content-date">'.date("m/d/Y", strtotime($entry->date)).'</span>';
						if($entry->comments) {
							$output.= '<span class="link-summary-content-description">'.stripslashes($entry->comments).'</span>';
						}
					$output.= '</p>';
				}
				if($total_entries > $limit && !empty($link)) {
				$output.= '<p	class="link-summary-content-read-more ht-widget-more">';
				$output.= '<a href="'.$link.'" rel="nofollow">See More..</a>';
				$output.= '</p>';
				}
			$output.= '</div>';
		}
	$output.= '</div>';

	return $output;
}

?>
