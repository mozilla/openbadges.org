<?php

// $headers = getallheaders();
// 
// echo '<pre>'.print_r($headers,1).'</pre>';
// 
// exit();

get_header();

if (have_posts()) {
	while (have_posts()) {
		the_post();
		get_template_part('templates/content', get_post_format());
	}
} else {
	
}

get_footer();

