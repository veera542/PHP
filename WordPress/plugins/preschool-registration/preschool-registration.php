<?php
/**
 * Plugin Name: Preschool Registrations
 * Description: Custom plugin for preschool registrations.
 * Version: 1.0.0
 * Author: Veera
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Register Custom Post Type
function custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Preschool Registration', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Preschool Registration', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Preschool Registration', 'text_domain' ),
		'name_admin_bar'        => __( 'Preschool Registration', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Preschool Registration', 'text_domain' ),
		'description'           => __( 'Preschool registrations details', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
        'show_in_rest'          => true,
        'query_var'             => true,
		'capability_type'       => 'page',
        'menu_icon'             => 'dashicons-calendar-alt'
	);
	register_post_type( 'preschool-register', $args );

}
add_action( 'init', 'custom_post_type', 0 );



add_filter( 'the_content', 'preschool_register_data', 1 );

function preschool_register_data( $content ) {
    $post_id = get_the_ID();
	$start_time = $end_time = '';
    // Get school name, address, registration location
    $school_name = get_field('name_of_preschool', $post_id);
    $address = get_field('address', $post_id);
	$location_accepting = get_field('location_accepting_registrations', $post_id);
	$location_accepting = !empty($location_accepting) ? ($location_accepting == 'y' ? 'Yes' : 'No') : '';
    // Get time of registration field values
    $acf_group = get_field('time_of_registration_during_the_week', $post_id);
    $registration_timings = '';
    if (isset($acf_group) && !empty($acf_group)) {
        if (isset($acf_group['all_days_are_same_hours']) && !empty($acf_group['all_days_are_same_hours']['select_time_slots']['start_time'])) {
            // Get the same start and end time for all days
			$start_time = $acf_group['all_days_are_same_hours']['select_time_slots']['start_time'];
            $end_time = $acf_group['all_days_are_same_hours']['select_time_slots']['start_time'];
            if ($start_time && $end_time) {
                $registration_timings .= '<p>All Days: ' . $start_time . ' - ' . $end_time . '</p>';
            }
        } else {
            $registration_timings .= '<ul>';
            // forloop through each day and fetching the start and end time
            foreach ($acf_group as $day => $timings) {
                if ($day === 'choice_of_options' || $day === 'all_days_are_same' || $day == 'all_days_are_same_hours' ) {
                    continue;
                }
				if (isset($timings["select_time_slots_{$day}"])){
					$start_time = $timings["select_time_slots_{$day}"]["start_time_{$day}"];
					$end_time = $timings["select_time_slots_{$day}"]["end_time_{$day}"];
				}
                if ($start_time && $end_time) {
                    $registration_timings .= '<li>' . ucfirst($day) . ': ' . $start_time . ' - ' . $end_time . '</li>';
                } else {
                    $registration_timings .= '<li>' . ucfirst($day) . ': Closed</li>';
                }
            }

            $registration_timings .= '</ul>';
        }
    } else {
        $registration_timings .= '<p>No registration timings available.</p>';
    }

    $content .= '<h3>School Name: </h3>' . $school_name;
    $content .= '<h3>Address: </h3>' . $address;
	$content .= '<h3>Location accepting registrations?</h3>'.$location_accepting;
    $content .= '<h3>Time of registration during the week:</h3>';
    $content .= $registration_timings;

    return $content;
}
