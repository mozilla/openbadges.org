<?php if (IS_AJAX) return; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>

		<div id="main">
			<div id="header">
				<div class="constrained">
					<header>
						<h1>
							<a href="http://www.mozilla.org" id="tabzilla">Mozilla</a>
							<a href="<?php echo home_url(); ?>" class="logo">Open Badges</a>
						</h1>
					</header>
					<nav>
						<?php wp_nav_menu(array('theme_location' => 'header', 'container' => false, 'fallback_cb' => false)); ?>
					</nav>
				</div> <!-- .constrained -->
			</div> <!-- #header -->

			<div id="content">
				<div class="constrained">
