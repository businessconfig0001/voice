<?php

function cptui_register_my_cpts_voz() {

	/**
	 * Post Type: Vozes.
	 */

	$labels = array(
		"name" => __( "Vozes", "storefront" ),
		"singular_name" => __( "Voz", "storefront" ),
		"add_new" => __( "Adicionar nova voz", "storefront" ),
		"add_new_item" => __( "Adicionar nova voz", "storefront" ),
		"edit_item" => __( "Editar voz", "storefront" ),
		"new_item" => __( "Nova voz", "storefront" ),
	);

	$args = array(
		"label" => __( "Vozes", "storefront" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => false,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "voz", "with_front" => true ),
		"query_var" => true,
		"taxonomies" => array( "category", "post_tag" ),
	);

	register_post_type( "voz", $args );
}

add_action( 'init', 'cptui_register_my_cpts_voz' );


if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5c76c7ce83b56',
	'title' => 'Atributos de Voz',
	'fields' => array(
		array(
			'key' => 'field_5c76ca0fff41f',
			'label' => 'Nome',
			'name' => 'nome',
			'type' => 'text',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5c76c7ebac5da',
			'label' => 'Gênero',
			'name' => 'genero',
			'type' => 'radio',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'Feminino' => 'Feminino',
				'Masculino' => 'Masculino',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'default_value' => '',
			'layout' => 'vertical',
			'return_format' => 'value',
			'save_other_choice' => 0,
		),
		array(
			'key' => 'field_5c76c831ac5db',
			'label' => 'Data de Nascimento',
			'name' => 'data_de_nascimento',
			'type' => 'date_picker',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'd/m/Y',
			'return_format' => 'd/m/Y',
			'first_day' => 1,
		),
		array(
			'key' => 'field_5c76ca2eff420',
			'label' => 'Linguagens',
			'name' => 'linguagens',
			'type' => 'checkbox',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'Espanhol' => 'Espanhol',
				'Francês' => 'Francês',
				'Inglês UK' => 'Inglês UK',
				'Inglês USA' => 'Inglês USA',
				'Italiano' => 'Italiano',
				'Japonês' => 'Japonês',
				'Mandarim' => 'Mandarim',
				'Português' => 'Português',
				'Português do Brasil' => 'Português do Brasil',
				'Alemão' => 'Alemão',
				'Angolano' => 'Angolano',
				'Outro' => 'Outro',
			),
			'allow_custom' => 0,
			'default_value' => array(
			),
			'layout' => 'vertical',
			'toggle' => 0,
			'return_format' => 'value',
			'save_custom' => 0,
		),
		array(
			'key' => 'field_5c7d92ca4f242',
			'label' => 'Biografia',
			'name' => 'biografia',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5c76caaeff421',
			'label' => 'Comercial',
			'name' => 'comercial',
			'type' => 'file',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'library' => 'all',
			'min_size' => '',
			'max_size' => '',
			'mime_types' => 'mp3',
		),
		array(
			'key' => 'field_5c76cb2404e83',
			'label' => 'informativo',
			'name' => 'informativo',
			'type' => 'file',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'library' => 'all',
			'min_size' => '',
			'max_size' => '',
			'mime_types' => 'mp3',
		),
		array(
			'key' => 'field_5c76cb2304e82',
			'label' => 'Personagem',
			'name' => 'personagem',
			'type' => 'file',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'library' => 'all',
			'min_size' => '',
			'max_size' => '',
			'mime_types' => 'mp3',
		),
		array(
			'key' => 'field_5c76cb2104e81',
			'label' => 'Vídeo',
			'name' => 'video',
			'type' => 'file',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'library' => 'all',
			'min_size' => '',
			'max_size' => '',
			'mime_types' => 'mp4',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'voz',
			),
		),
	),
	'menu_order' => -1,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;
?>