<?php if (IS_AJAX) return; ?>
			</div> <!-- .constrained -->
		</div> <!-- #content -->

		<?php if (!!!get_post_meta($post->ID, 'hide_meta', true)):
			if (is_active_sidebar('footer')): ?>
				<aside id="meta">
					<div class="constrained">
						<?php dynamic_sidebar('footer'); ?>
					</div> <!-- .constrained -->
				</aside>
			<?php endif;
		endif; ?>
		<footer id="footer">
			<div class="constrained">
				<section>
					<p class="footnote"><a href="<?php echo home_url(); ?>">Mozilla <?php bloginfo('name'); ?></a></p>
					<nav>
						<?php wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'fallback_cb' => false)); ?>
					</nav>
				</section>
				<section>
					<p class="support">
						Supported by
						<a href="http://www.macfound.org"><img width="90" height="75" alt="the MacArthur Foundation" src="<?php echo get_stylesheet_directory_uri(); ?>/media/images/partners/MacArthur_logo.png"></a>
					</p>
					<nav>
						<?php wp_nav_menu(array('theme_location' => 'footer', 'container' => false, 'fallback_cb' => false)); ?>
					</nav>
				</section>
			</div>
		</footer>

		<?php wp_footer(); ?>

	</body>
</html>