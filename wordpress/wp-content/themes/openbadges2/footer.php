<?php if (IS_AJAX) return; ?>
			</div> <!-- .constrained -->
		</div> <!-- #content -->

		<footer id="footer">
			<div class="constrained">
				<p class="footnote"><a href="<?php echo home_url(); ?>">Mozilla <?php bloginfo('name'); ?></a></p>
				<nav>
					<?php wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'fallback_cb' => false)); ?>
				</nav>
			</div>
		</footer>

		<?php wp_footer(); ?>

	</body>
</html>