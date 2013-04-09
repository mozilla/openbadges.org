<?php

function add_body_classes($classes) {
	global $post;

	$extra = array();
	if (!!get_post_meta($post->ID, 'embellish_page', true)) {
		$extra[] = 'embellished';
	}

	if (function_exists('get_additional_body_classes')) {
		$extra = array_merge($extra, (array) get_additional_body_classes());
	} else {
		$extra[] = 'narrow';
	}

	return array_merge($classes, $extra);
}

add_filter('body_class','add_body_classes');

get_header();

if (have_posts()) {
	while (have_posts()) {
		the_post();
		get_template_part('templates/content', get_post_format());
	}
}

get_footer();
