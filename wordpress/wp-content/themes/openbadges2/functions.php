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
 * Remove other silly WordPress hooks
 */

remove_filter('the_content', 'wpautop');


/*
 * Add stylesheets and scripts required by Open Badges
 */

function openbadges_styles () {
	$theme = wp_get_theme();
	$local = get_stylesheet_directory_uri() . '/media/css';

	$styles = array(
		'tabzilla' => array('src'=>'//www.mozilla.org/tabzilla/media/css/tabzilla.css', 'enqueue'=>true),
		'core' => $local.'/core{.min}.css',
		'fancybox' => array('src'=>$local.'/jquery.fancybox.css'),
		'badges-101' => array('src'=>$local.'/badges-101.css'),
	);

	foreach ($styles as $style => $config) {
		if (is_null($config)) {
			wp_enqueue_style($style);
		} else {
			if (!is_array($config)) {
				$config = array(
					'src' => strval($config),
					'version' => $theme->version,
					'enqueue' => true,
				);
			}

			$src = @$config['src'];
			if (WP_DEBUG) {
				$src = preg_replace('/{[^}]*}/', '', $src);
			} else {
				$src = preg_replace('/[{}]/', '', $src);
			}

			wp_register_style(
				$style,
				$src,
				isset($config['dependencies']) ? (array) $config['dependencies'] : array(),
				isset($config['version']) ? $config['version'] : null,
				isset($config['media']) ? $config['media'] : 'all'
			);

			if (@$config['enqueue']) wp_enqueue_style($style);
		}
	}
}

function openbadges_scripts () {
	$theme = wp_get_theme();
	$local = get_stylesheet_directory_uri() . '/media/js';

	$scripts = array(
		'tabzilla' => array('src'=>'//www.mozilla.org/tabzilla/media/js/tabzilla.js', 'enqueue'=>true),
		'fancybox' => array('src'=>$local.'/jquery.fancybox.js', 'dependencies'=>array('jquery')),
		'slides' => array('src'=>$local.'/jquery.slides.min.js', 'dependencies'=>array('jquery')),
		'quickbadge' => array('src'=>$local.'/quickbadge.js'),
		'sha256' => array('src'=>$local.'/sha256.js'),
		'issuer' => array('src'=>"http://beta.openbadges.org/issuer.js"),
		'badges-101' => array('src'=>$local.'/badges-101.js', 'dependencies'=>array('fancybox','slides','quickbadge','sha256','issuer')),
	);

	foreach ($scripts as $script => $config) {
		if (is_null($config)) {
			wp_enqueue_script($script);
		} else {
			if (!is_array($config)) {
				$config = array(
					'src' => strval($config),
					'version' => $theme->version,
					'enqueue' => true,
				);
			}

			$src = @$config['src'];
			if (WP_DEBUG) {
				$src = preg_replace('/{[^}]*}/', '', $src);
			} else {
				$src = preg_replace('/[{}]/', '', $src);
			}

			wp_register_script(
				$script,
				$src,
				isset($config['dependencies']) ? (array) $config['dependencies'] : array(),
				isset($config['version']) ? $config['version'] : null,
				isset($config['top']) ? !!!$config['top'] : true
			);

			if (@$config['enqueue']) wp_enqueue_script($script);
		}
	}
}

add_action('wp_enqueue_scripts', 'openbadges_styles');
add_action('wp_enqueue_scripts', 'openbadges_scripts');

function openbadges_check_content_for_requirements ($content) {
	$map = array(
		'quickstart' => array(
			'styles' => array('fancybox','badges-101'),
			'scripts' => array('badges-101'),
		),
		'fancybox' => array(
			'styles' => array('fancybox'),
			'scripts' => array('fancybox'),
		)
	);

	foreach ($map as $search => $dependencies) {
		if (preg_match('/<\w+ [^>]*class=(["\'])(?:[^\1]+ +| *)?'.preg_quote($search).'(?:[^\1]+ +| *)?\1[^>]*>/', $content)) {
			$styles = (array) @$dependencies['styles'];
			array_walk($styles, 'wp_enqueue_style');
			$scripts = (array) @$dependencies['scripts'];
			array_walk($scripts, 'wp_enqueue_script');
		}
	}

	return $content;
}

add_filter('the_content', 'openbadges_check_content_for_requirements');


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
		'primary' => __('Main Menu', 'openbadges'),
		'footer' => __('Secondary Footer Menu', 'openbadges'),
	));
}

add_action('after_setup_theme', 'openbadges_setup_menus');


/*
 * Set up admin config
 */

function openbadges_admin_init () {
	require_once(dirname(__FILE__).'/admin/init.php');
}

add_action('admin_init', 'openbadges_admin_init');