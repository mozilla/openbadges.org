<article>
	<?php
		$title_alignment = get_post_meta($post->ID, 'title_alignment', true);
		if (empty($title_alignment)) {
			$title_class = '';
		} else {
			$title_class = ' class="text-'.$title_alignment.'"';
		}
		echo '<h2'.$title_class.'>'.get_the_title().'</h2>';

		the_content();
	?>
</article>