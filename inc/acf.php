<?php

add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
	'key' => 'group_66ae5112a55ad',
	'title' => 'Focus Area Meta',
	'fields' => array(
		array(
			'key' => 'field_66ae5113d7529',
			'label' => 'color',
			'name' => 'color',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'red',
			'maxlength' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'area-of-focus',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );

	acf_add_local_field_group( array(
	'key' => 'group_66998c065ec7c',
	'title' => 'Timeline Fields',
	'fields' => array(
		array(
			'key' => 'field_66998c07bcfee',
			'label' => 'External Link',
			'name' => 'external_link',
			'aria-label' => '',
			'type' => 'url',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
		),
		array(
			'key' => 'field_66998dfc184f3',
			'label' => 'Priority Action Text',
			'name' => 'priority_action_text',
			'aria-label' => '',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'rows' => '',
			'placeholder' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_66bd2558e80d8',
			'label' => 'Priority Action 2',
			'name' => 'priority_action_text_2',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'timeline-item',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );
} );

add_action( 'init', function() {
	register_taxonomy( 'area-of-focus', array(
	0 => 'timeline-item',
), array(
	'labels' => array(
		'name' => 'Areas of Focus',
		'singular_name' => 'Area of Focus',
		'menu_name' => 'Areas of Focus',
		'all_items' => 'All Areas of Focus',
		'edit_item' => 'Edit Area of Focus',
		'view_item' => 'View Area of Focus',
		'update_item' => 'Update Area of Focus',
		'add_new_item' => 'Add New Area of Focus',
		'new_item_name' => 'New Area of Focus Name',
		'search_items' => 'Search Areas of Focus',
		'not_found' => 'No areas of focus found',
		'no_terms' => 'No areas of focus',
		'items_list_navigation' => 'Areas of Focus list navigation',
		'items_list' => 'Areas of Focus list',
		'back_to_items' => '← Go to areas of focus',
		'item_link' => 'Area of Focus Link',
		'item_link_description' => 'A link to a area of focus',
	),
	'public' => true,
	'hierarchical' => true,
	'show_in_menu' => true,
	'show_in_rest' => true,
) );
} );

add_action( 'init', function() {
	register_post_type( 'timeline-item', array(
	'labels' => array(
		'name' => 'Timeline Items',
		'singular_name' => 'Timeline Item',
		'menu_name' => 'Timeline Item',
		'all_items' => 'All Timeline Items',
		'edit_item' => 'Edit Timeline Item',
		'view_item' => 'View Timeline Item',
		'view_items' => 'View Timeline Items',
		'add_new_item' => 'Add New Timeline Item',
		'add_new' => 'Add New Timeline Item',
		'new_item' => 'New Timeline Item',
		'parent_item_colon' => 'Parent Timeline Item',
		'search_items' => 'Search Timeline Items',
		'not_found' => 'No Timeline Items found',
		'not_found_in_trash' => 'No Timeline Items found in Trash',
		'archives' => 'Timeline Item Archives',
		'attributes' => 'Timeline Item Attributes',
		'insert_into_item' => 'Insert into Timeline Item',
		'uploaded_to_this_item' => 'Uploaded to this Timeline Item',
		'filter_items_list' => 'Filter Timeline Item list',
		'filter_by_date' => 'Filter Timeline Items by date',
		'items_list_navigation' => 'Timeline Item list navigation',
		'items_list' => 'Timeline Items list',
		'item_published' => 'Timeline Item published.',
		'item_published_privately' => 'Timeline Item published privately.',
		'item_reverted_to_draft' => 'Timeline Item reverted to draft.',
		'item_scheduled' => 'Timeline Item scheduled.',
		'item_updated' => 'Timeline Item updated.',
		'item_link' => 'Timeline Item Link',
		'item_link_description' => 'A link to a Timeline Item.',
	),
	'public' => true,
	'show_in_rest' => true,
	'menu_icon' => 'dashicons-admin-post',
	'supports' => array(
		0 => 'title',
		1 => 'excerpt',
		2 => 'thumbnail',
		3 => 'custom-fields',
	),
	'delete_with_user' => false,
) );
} );

