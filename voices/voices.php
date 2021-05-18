<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://businessconfig.com
 * @since             1.0.0
 * @package           Voices
 *
 * @wordpress-plugin
 * Plugin Name:       Voices
 * Plugin URI:        https://businessconfig.com
 * Description:       Voices List and Search
 * Version:           1.0.0
 * Author:            Business Config
 * Author URI:        https://businessconfig.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       voices
 * Domain Path:       /languages
 */

include 'config.php';
add_action('wp_enqueue_scripts', 'registerScripts');
add_action('init', 'registerShortcodes');

include 'loadmore.php';
include 'select_from_metadata.php';
include 'show_item.php';
include 'filters.php';
include 'quote.php';
include 'favorites_checkout.php';

add_action('admin_init', 'removeTitleAndEditorFromVoice', 10);
add_action('admin_init', 'registerOptions');

add_action("wp_ajax_sendRequest", "sendRequest");
add_action("wp_ajax_nopriv_sendRequest", "sendRequest");

add_action("wp_ajax_voiceSearch", "voiceSearch");
add_action("wp_ajax_nopriv_voiceSearch", "voiceSearch");

add_filter('manage_voz_posts_columns','voiceColumnHeaders');
add_filter('manage_voz_posts_custom_column','voiceColumnData',1,2);

include_once( plugin_dir_path( __FILE__ ) . 'cpt/voz.php');

// Include ACF
add_filter('acf/settings/path', 'acf_settings_path');
function acf_settings_path( $path ) {
    $path = plugin_dir_path( __FILE__ ) . 'lib/advanced-custom-fields/';
    return $path;
}
add_filter('acf/settings/dir', 'acf_settings_dir');
  function acf_settings_dir( $path ) {
    $dir = plugin_dir_url( __FILE__ ) . 'lib/advanced-custom-fields/';
    return $dir;
}
//add_filter('acf/settings/show_admin', '__return_false');
include_once( plugin_dir_path( __FILE__ ) .'lib/advanced-custom-fields/acf.php' );

add_filter('acf/settings/save_json', 'my_acf_json_save_point');
function my_acf_json_save_point( $path ) {
    $path = plugin_dir_url( __FILE__ ) . 'acf-json';
    return $path;
}
// END Include ACF

add_action('admin_menu', 'adminMenus');
function adminMenus() {
	$top_menu_item = 'voicesDashboardAdminPage';
	add_menu_page( '', 'Vozes', 'manage_options', 'voicesDashboardAdminPage', 'voicesDashboardAdminPage', 'dashicons-megaphone');
    
    add_submenu_page( $top_menu_item, '', __( "Configurações", "voices" ), 'manage_options', $top_menu_item, $top_menu_item );
    add_submenu_page( $top_menu_item, '', __( "Vozes", "voices" ), 'manage_options', 'edit.php?post_type=voz');
}

add_action( 'plugins_loaded', 'voices_load_textdomain' );
function voices_load_textdomain() {
    load_plugin_textdomain('voices', false, basename(dirname( __FILE__ )).'/languages/' );
}

define("PLUGIN_OPTIONS_NAME", 'voz_plugin_options');
function voicesDashboardAdminPage() {
    $options = getCurrentOptions();
	
	echo('<div class="wrap">
		<h2>'.__( "Voices List and Search", "voices" ).'</h2>
		<form action="options.php" method="post">');
		
			settings_fields(PLUGIN_OPTIONS_NAME);
			@do_settings_fields('voz_plugin','voz_plugin_options_section');
			
			echo('<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="voz_show_per_page">'.__( "Quantidade de registros por página", "voices" ).'</label></th>
						<td>
							<input type="number" name="voz_show_per_page" value="'.$options['voz_show_per_page'].'" class="" />
							<p class="description" id="voz_show_per_page-description">'.__( "Quantidade de registros buscados por vez", "voices" ).'</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="voz_checkout_page">'.__( "Página de checkout", "voices" ).'</label></th>
						<td>
							<input type="text" name="voz_checkout_page" value="'.$options['voz_checkout_page'].'" class="" />
							<p class="description" id="voz_checkout_page-description">'.__( "Página para a qual o usuário será direcionado para fazer o pedido de cotação", "voices" ).'</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="voz_admin_email">'.__( "E-mail do administrador", "voices" ).'</label></th>
						<td>
							<input type="email" name="voz_admin_email" value="'.$options['voz_admin_email'].'" class="" />
							<p class="description" id="voz_admin_email-description">'.__( "Este e-mail irá receber os pedidos de cotação", "voices" ).'</p>
						</td>
					</tr>
				</tbody>
			</table>');
			@submit_button();
		echo('</form>
	</div>');
}
function registerOptions() {
	register_setting(PLUGIN_OPTIONS_NAME, 'voz_show_per_page');
	register_setting(PLUGIN_OPTIONS_NAME, 'voz_checkout_page');
	register_setting(PLUGIN_OPTIONS_NAME, 'voz_admin_email');
}
function getCurrentOptions() {
    return array(
			'voz_show_per_page'=> getOption('voz_show_per_page'),
			'voz_checkout_page'=> getOption('voz_checkout_page'),
			'voz_admin_email'=> getOption('voz_admin_email'));
}
function getOption($option_name) {
    if (get_option($option_name)){
        return get_option($option_name);
    }
    return getDefaultOptions()[$option_name];
}
function getDefaultOptions() {
	return array(
			'voz_show_per_page'=>5,
			'voz_checkout_page'=>"/",
			'voz_admin_email'=>"");
}
function voiceColumnHeaders($columns) {
	$columns = array(
		'cb'=>'<input type="checkbox" />',
		'nome'=>__('Nome', "voices"),
		'genero'=>__('Gênero', "voices"),
		'linguagens'=>__('Linguagens', "voices"),
	);
	return $columns;
}
function voiceColumnData($column, $post_id) {
	$output = '';
	switch( $column ) {
		case 'linguagens':
			$output .= implode(", ", get_field('linguagens',$post_id));
			break;
		default:
			$output .= get_field($column, $post_id);
			break;
	}
	echo $output;
}
function removeTitleAndEditorFromVoice() {
    remove_post_type_support('voz', 'title');
    remove_post_type_support('voz', 'editor');
}
function calculateAge($post_id){
    $data = get_post_meta($post_id, 'data_de_nascimento', true);
    $date = DateTime::createFromFormat('Ymd', $data);
    $now = date("Y");
    return intval(date("Y")) - intval($date->format("Y"));
}
function voiceSearch(){
    $args = checkFilters(NULL);
    searchOnAjax($args);
    exit;
}
function checkFilters($args){
    $args['meta_query'] = array('relation' => 'AND');
    
    if(strcmp($_POST['language'], __( "Todos", "voices" )) !== 0){
        $args = addMeta($args, $_POST['language'].'";}', 'linguagens');
    }
    if(strcmp($_POST['gender'], __( "Todos", "voices" )) !== 0){
        $args = addMeta($args, $_POST['gender'], 'genero');
    }
    if(strcmp($_POST['category'], __( "Todos", "voices" )) !== 0){
        $args['cat'] = $_POST['category'];
    }
    if(strcmp($_POST['age'], "") !== 0){
        $args = addAges($args, $_POST['age']);
    }
    if(strcmp($_POST['name'], "") !== 0){
        $args = addMeta($args, $_POST['name'], 'nome');
    }
    return $args;
}
function addAges($args, $ages){
    $ageArray = array();
    
    $intervalArray = explode(";",$ages);
    foreach ($intervalArray as $inteval) {
        if(strcmp($inteval, "") !== 0){
            addAge($ageArray[], $inteval);
        }
    }
    $ageArray['relation'] = 'OR';
    $args['meta_query'][] = $ageArray;
    
    return $args;
}
function addAge(&$args, $age){
    //$args['relation'] = 'AND';
    $args[] = array(
                'key' => 'idades',
                'value' => $age,
                'compare' => 'LIKE'
            );
}
function calculateData($age){
    $now = date("Y");
    $date = strtotime($now.' -'.$age.' year');
    return date('Ymd', $date);
}
function addIntervalStart(&$args, $start){
    $args['relation'] = 'AND';
    $args[] = array(
                'key' => 'data_de_nascimento',
                'value' => $start,
                'compare' => '<='
            );
}
function addInterval(&$args, $start, $end){
    $args['relation'] = 'AND';
    $args[] = array(
                'key' => 'data_de_nascimento',
                'value' => $start,
                'compare' => '<='
            );
    $args[] = array(
                'key' => 'data_de_nascimento',
                'value' => $end,
                'compare' => '>='
            );
}
function addMeta($args, $value, $metaKey){
    $args['meta_query'][] = array(
		'key' => $metaKey,
		'value' => $value,
		'compare' => 'LIKE'
    );
    return $args;
}
function registerScripts(){
	wp_register_script('scripts_public', plugins_url('/public/js/search.js',__FILE__), array('jquery'),'',true);
	wp_enqueue_script('scripts_public');
}
function registerShortcodes() {
    add_shortcode('voices', 'showVoicesAndSearch');
    add_shortcode('get_quote', 'showGetAQuote');
    add_shortcode('favorites_checkout', 'showFavoritesCheckout');
}
function showVoicesAndSearch($atts, $content="") {
	$html = "<div class='voices_main'>";
    $html .= showFilters();
    $html .= showVoices();
    $html .= "<div class='loader hidden'></div>";
	$html .= "</div>";
	return $html;
}
function showResultCount(){
    return "<div class='voices_count'>".__( "Resultados", "voices" ).": <span id='result_count'>".getOption('voz_show_per_page')."</span></div>";
}
function searchOnAjax($args){
    $loop = getQuery($args);
    
    echo showVoicesList($loop);
}
function getQuery($args){
    $args['post_type'] = SEARCH_CUSTOM_POST_TYPE;
    $args['posts_per_page'] = getOption('voz_show_per_page');
    // var_dump($args);
    return new WP_Query($args);
}
function showVoices(){
    $args['paged'] = max(1, get_query_var('paged'));
    $loop = getQuery($args);
    
    //$html = showResultCount();
    
    $html = "<div id='voice_main' class='voices_list'>";
    $html .= showVoicesList($loop);
    $html .= "</div>";
    return $html;
}
function showVoicesList($loop){
    $html = '';
    while ($loop->have_posts()) : $loop->the_post();
        $html .= showItem();
    endwhile;
    
    wp_reset_query();
    wp_reset_postdata();
    
    return $html;
}


// get all the local field groups 
$field_groups = acf_get_local_field_groups();

// loop over each of the gield gruops 
foreach( $field_groups as $field_group ) {

	// get the field group key 
	$key = $field_group['key'];

	// if this field group has fields 
	if( acf_have_local_fields( $key ) ) {
	
      	// append the fields 
		$field_group['fields'] = acf_get_local_fields( $key );

	}

	// save the acf-json file to the acf-json dir by default 
	acf_write_json_field_group( $field_group );

}