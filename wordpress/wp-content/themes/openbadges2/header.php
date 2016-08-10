<?php if (IS_AJAX) return; ?>
<?php $stylesheetDir = get_stylesheet_directory_uri(); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
		<link rel="icon" type="image/x-icon" href="<?php echo $stylesheetDir; ?>/media/images/favicon.ico"/>
		<link rel="icon" type="image/png" href="<?php echo $stylesheetDir; ?>/media/images/favicon.png"/>
		<!--[if lt IE 9]><script src="<?php echo $stylesheetDir; ?>/media/js/html5shiv.js"></script><![endif]-->
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>

		<header id="header">
			<div class="constrained">
				<h1><a href="http://www.mozilla.org/" id="tabzilla">Mozilla</a> <a href="<?php echo home_url(); ?>" id="home"><?php bloginfo('name'); ?></a></h1>
				<nav id="navigation">
					<?php wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'fallback_cb' => false)); ?>
				</nav>
			</div> <!-- .constrained -->
		</header> <!-- #header -->

		<div id="content" role="main"><div id="ribbon"><p>proudly<br>participating in<br><strong><a target="_blank" href="http://www.2mbetterfutures.org/">2MBETTERFUTURES</a></strong></p></div>
			<div class="constrained">
