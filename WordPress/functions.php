<?php

/* Add below block of code in functions.php */
/*preschool-registration REST API query parameter */

add_filter( 'rest_query_vars', function ( $valid_vars ) {
    return array_merge( $valid_vars, array( 'time_of_registration', 'meta_query' ) );
} );

add_filter( 'rest_preschool-register_query', function( $args, $request ) {
    $date_time   = $request->get_param( 'registration_time' );
	$time = '00:00:00'; //default value of time
	if(!empty($date_time)) {
		$split_param = explode("T", $date_time);
		$date = $split_param[0];
		if(!empty($date)) {
			$timestamp = strtotime($date);
			$day = date('l', $timestamp);
		}
		if(!empty($split_param) && isset($split_param[1])) {
			$time = $split_param[1];
		}
		$register_names = return_timings( $day, $time );
		if(count($register_names) != 0) {
			if ( isset( $args['meta_query'] ) ) {
				$meta_query = $args['meta_query'];
			}
			if (count($register_names)  > 1) {
			$meta_query['relation'] = 'AND';
			foreach($register_names as $register_name) {
				if ( ! empty( $id ) ) {
					$args['meta_query'] = array(
						array(
							'key'     => 'name_of_preschool',
							'value'   => $register_name,
							'compare' => '=',
						)
				);
				}
			} 
			$args['meta_query'] = $meta_query;
			} elseif(count($register_names)  == 1) {
				if ( ! empty( $register_names[0] ) ) {
					$args['meta_query'] = array(
						array(
							'key'     => 'name_of_preschool',
							'value'   => $register_names[0],
							'compare' => '=',
						)
					);
				}	
			}
		} 
		else{
			$args['meta_query'] = array(
				array(
					'key'     => 'name_of_preschool',
					'value'   => '',
					'compare' => '=',
				)
			);	
		}
	} else{
		$args['meta_query'] = array(
			array(
				'key'     => 'name_of_preschool',
				'value'   => '',
				'compare' => '=',
			)
		);
	}
	
    return $args;
}, 10, 2 );

function return_timings($day = null, $time = null) {
	$acf_day = strtolower($day);
	$args = array(
		'post_type' => 'preschool-register',
		'posts_per_page' => -1
	);
	$register_names = [];
	$posts = get_posts($args);
	foreach ($posts as $post) {
		// Get the ACF group field values
		$acf_group = get_field('time_of_registration_during_the_week', $post->ID);
		if ($acf_group) {
			foreach ($acf_group as $day => $data) {
				if ($day !== 'choice_of_options' && $day !== 'all_days_are_same_hours' && $day == $acf_day) {
					$startTime = $data["select_time_slots_{$day}"]["start_time_{$day}"];
					$endTime = $data["select_time_slots_{$day}"]["end_time_{$day}"];
					if (strtotime($time) >= strtotime($startTime) && strtotime($time) <= strtotime($endTime)) {
						$register_names[] = get_field('name_of_preschool', $post->ID);
					}
				} elseif( $day == 'all_days_are_same_hours'){
					
					$startTime = $data["select_time_slots"]["start_time"];
					$endTime = $data["select_time_slots"]["end_time"];
					if (strtotime($time) >= strtotime($startTime) && strtotime($time) <= strtotime($endTime)) {
						$register_names[] = get_field('name_of_preschool', $post->ID);
					}	
				}
			}	
		}
	}
	return $register_names;


}

/*preschool-registration REST API query parameter end */
