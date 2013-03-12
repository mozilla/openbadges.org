<?php

/*
 * Template Name: QuickStart
 */

if (!IS_AJAX && $page > 1 && strpos(@$_SERVER['HTTP_REFERER'], get_permalink()) !== 0) {
	// Send people to the start of the quiz, if they weren't refered internally to this page
	header('Location: '.$base);
	exit();
}

function quickstart_dependencies () { 
	wp_enqueue_style('badges-101');
}

add_action('wp_enqueue_scripts', 'quickstart_dependencies');

function add_body_classes ($classes) {
	$classes[] = 'narrow';
	return $classes;
}

add_filter('body_class','add_body_classes');

global $post, $page;

function question_formatting ($matches) {
	$buttons = array();
	$body = $matches[3];
	preg_match_all('#(<(\w+) [^>]*class="([^"]*)answer([^"]*)"[^>]*>)(.*?)(</\2>)#', $body, $options, PREG_SET_ORDER);

	foreach ($options as $option) {
		$classes = array(preg_replace('#[^\w]#', '_', trim(strToLower($option[5]))), 'button');
		if (strpos($option[3].' '.$option[4], 'correct') > -1) {
			$classes[] = 'correct';
		}
		$buttons[] = '<a class="'.implode(' ', $classes).'">'.$option[5].'</a>';
	}

	return implode('', array(
		$matches[1],
		$body,
		'<p class="options">' . implode(' ', $buttons) . '</p>',
		$matches[4]
	));
}

get_header();

if (have_posts()) {
	while (have_posts()) {
		the_post();

		if (IS_AJAX) {
			echo '<div id="badges-101" class="inline">';

			$question_search_re = 'class="[^"]*question[^"]*"';
			$question_re = '#(<(\w+) [^>]*'.$question_search_re.'[^>]*>)(.*?)(</\2>)#s';
		
			echo '<div id="slides" role="main">';
			echo '<div class="slides_container">';
			$pages = explode('<!--nextpage-->', $post->post_content);
			foreach ($pages as $index => $page) {
				$classes = array('slide');
				if (preg_match('#'.$question_search_re.'#', $page)) {
					$classes[] = 'quiz';
					$page = preg_replace_callback($question_re, 'question_formatting', $page);
				}
				echo '<div id="quickstart-page-'.($index+1).'" class="'.implode(' ', $classes).'">';
				echo preg_replace('/(<a [^>]*class=")(button[^"]*")/', '$1 next $2', $page);
				echo '</div>';
			}
			echo '</div>';
			echo '</div>';
			echo '</div>';
		} else {
			get_template_part('templates/content', 'quickstart');
		}
	}
}

get_footer();
