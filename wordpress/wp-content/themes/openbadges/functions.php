<?php

$headers = getallheaders();
define('IS_AJAX', isset($headers['X-Requested-With']) && $headers['X-Requested-With'] === 'XMLHttpRequest');

/*
 * Remove default WordPress header hooks
 */

remove_action('wp_head', 'feed_links_extra',                 3   );
remove_action('wp_head', 'rsd_link'                              );
remove_action('wp_head', 'wlwmanifest_link'                      );
remove_action('wp_head', 'noindex',                          1   );
remove_action('wp_head', 'wp_generator'                          );
remove_action('wp_head', 'wp_shortlink_wp_head',            10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);


/*
 * Add stylesheets and scripts required by Open Badges
 */

function openbadges_styles () {
	$theme = wp_get_theme();

	$styles = array(
		'normalise' => get_stylesheet_directory_uri() . '/media/css/normalise.css',
		'core' => get_stylesheet_directory_uri() . '/media/css/core{.min}.css',
		'tabzilla' => array('src'=>'//www.mozilla.org/tabzilla/media/css/tabzilla.css'),
		'fancybox' => get_stylesheet_directory_uri() . '/media/css/jquery.fancybox.css'
	);

	if (get_post_meta(get_the_ID(), 'page_avatar')) {
		$styles['avatars'] = get_stylesheet_directory_uri() . '/media/css/avatars{.min}.css';
	}

	if (is_front_page()) {
		$styles += array(
			'badges101' => get_stylesheet_directory_uri() . '/media/css/badges101.css'
		);
	}

	foreach ($styles as $style => $config) {
		if (is_null($config)) {
			wp_enqueue_style($style);
		} else {
			if (!is_array($config)) {
				$config = array(
					'src' => strval($config),
					'version' => $theme->version
				);
			}

			$src = @$config['src'];
			if (WP_DEBUG) {
				$src = preg_replace('/{[^}]*}/', '', $src);
			} else {
				$src = preg_replace('/[{}]/', '', $src);
			}

			wp_enqueue_style(
				$style,
				$src,
				isset($config['dependencies']) ? (array) $config['dependencies'] : array(),
				isset($config['version']) ? $config['version'] : null,
				isset($config['media']) ? $config['media'] : 'all'
			);
		}
	}
}

function openbadges_scripts () {
	$theme = wp_get_theme();

	$scripts = array(
		'tabzilla' => array('src'=>'//www.mozilla.org/tabzilla/media/js/tabzilla.js', 'top'=>true)
	);

	if (is_front_page()) {
		$scripts += array(
			'fancybox' => array('src'=>get_stylesheet_directory_uri() . '/media/js/jquery.fancybox.js', 'dependencies'=>array('jquery')),
			'slides' => array('src'=>get_stylesheet_directory_uri() . '/media/js/slides.min.jquery.js', 'dependencies'=>array('jquery')),
			'quickbadge' => array('src'=>get_stylesheet_directory_uri() . '/media/js/quickbadge.js'),
			'badge_issuer' => array('src'=>'http://beta.openbadges.org/issuer.js'),
			'quiz' => array('src'=>get_stylesheet_directory_uri() . '/media/js/quiz.js', 'dependencies'=>array('jquery')),
			'sha256' => array('src'=>get_stylesheet_directory_uri() . '/media/js/sha256.js'),
			'main' => array('src'=>get_stylesheet_directory_uri() . '/media/js/main.js', 'dependencies'=>array('fancybox')),
		);
	}

	foreach ($scripts as $script => $config) {
		if (!is_array($config)) {
			$config = array(
				'src' => strval($config),
				'version' => $theme->version
			);
		}

		if (is_null($config)) {
			wp_enqueue_script($script);
		} else {
			wp_enqueue_script(
				$script,
				@$config['src'],
				isset($config['dependencies']) ? (array) $config['dependencies'] : array(),
				isset($config['version']) ? $config['version'] : null,
				isset($config['top']) ? !!!$config['top'] : true
			);
		}
	}
}

add_action('wp_enqueue_scripts', 'openbadges_styles');
add_action('wp_enqueue_scripts', 'openbadges_scripts');


/*
 * Clean up WordPress generated tags, which have a propensity to use single quotes!
 */

function openbadges_clean_tag ($tag) {
	$tag = preg_replace('|=\'([^\']*)\'( +)?|', '="$1" ', $tag);
	$tag = preg_replace('|\s+/?(>\s*)$|', '$1', $tag);
	return $tag;
}

add_action('style_loader_tag', 'openbadges_clean_tag', 1);


/*
 * Set up widgets
 */

function openbadges_setup_widgets () {
	register_sidebar(array(
		'name' => __('Footer', 'openbadges'),
		'id' => 'footer',
		'description' => __('Appears at the bottom of every page', 'openbadges'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
}

add_action('widgets_init', 'openbadges_setup_widgets');

/*
 * Set up menus
 */

function openbadges_setup_menus () {
	register_nav_menus(array(
		'header' => __('Header Menu', 'openbadges'),
		'footer' => __('Footer Menu', 'openbadges'),
		'front-page' => __('Front Page', 'openbadges')
	));
}

add_action('after_setup_theme', 'openbadges_setup_menus');

/*
 * Set up admin config
 */

function openbadges_admin_init () {
	require_once(dirname(__FILE__).'/admin.php');
}

add_action('admin_init', 'openbadges_admin_init');