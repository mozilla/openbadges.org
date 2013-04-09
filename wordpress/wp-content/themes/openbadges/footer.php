<?php if (IS_AJAX) return; ?>
				</div> <!-- .constrained -->
			</div> <!-- #content -->
		</div> <!-- #main -->

		<div id="footer">
			<?php if (is_active_sidebar('footer')): ?>
				<aside>
					<div class="constrained">
						<?php dynamic_sidebar('footer'); ?>
					</div> <!-- .constrained -->
				</aside>
			<?php endif; ?>
			<footer>
				<div class="constrained">
					<p>
						Supported by
						<a href="http://www.macfound.org"><img width="90" height="75" alt="MacArthur Foundation" src="<?php echo get_stylesheet_directory_uri(); ?>/media/images/partners/MacArthur_logo.png"></a>
					</p>
					<?php wp_nav_menu(array('theme_location' => 'footer', 'container' => false, 'fallback_cb' => false)); ?>
				</div>
			</footer>
		</div> <!-- #footer -->

		<?php wp_footer(); ?>

	</body>
</html>