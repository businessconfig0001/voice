<?php
add_action('wp_enqueue_scripts', 'load_more_scripts');
add_action('wp_ajax_loadmore', 'loadmore_ajax_handler'); 
add_action('wp_ajax_nopriv_loadmore', 'loadmore_ajax_handler');

function load_more_scripts() {
    global $wp_query;
    
 	wp_enqueue_script('jquery');
 
	wp_register_script('loadmore', plugins_url('/public/js/loadmore.js',__FILE__), array('jquery'));
 
	wp_localize_script('loadmore', 'loadmore_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', 
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page' => $wp_query->max_num_pages
	) );
 
 	wp_enqueue_script('loadmore');
}

function loadmore_ajax_handler(){
	$args = array();
	$args['paged'] = $_POST['page'] + 1; 
	$args['post_status'] = 'publish';
 
    $args = checkFilters($args);
    
    searchOnAjax($args); //Call method to query on AJAX
	die; 
}
?>