<?php

/*
 * Meta boxes
 */

function openbadges_page_attributes_meta_box ($post) {
	if ('page' == $post->post_type) {
		$avatar = get_post_meta($post->ID, 'page_avatar', true);
		$avatar_text = get_post_meta($post->ID, 'page_avatar_text', true);
		?>
		<p><strong><?php _e('Avatar') ?></strong></p>
		<label class="screen-reader-text" for="page_avatar"><?php _e('Page Avatar'); ?></label>
		<select name="page_avatar" id="page_avatar">
			<option value=""><?php _e('(none)'); ?></option>
			<option value="boris" <?php selected($avatar, 'boris'); ?>><?php _e('Boris'); ?></option>
			<option value="dorothy" <?php selected($avatar, 'dorothy'); ?>><?php _e('Dorothy'); ?></option>
			<option value="gladis" <?php selected($avatar, 'gladis'); ?>><?php _e('Gladis'); ?></option>
			<option value="morty" <?php selected($avatar, 'morty'); ?>><?php _e('Morty'); ?></option>
		</select>
		<label class="screen-reader-text" for="page_avatar_text"><?php _e('Page Avatar Speech Bubble'); ?></label>
		<textarea name="page_avatar_text" id="page_avatar_text" style="width: 100%; margin-top: 1em;" placeholder="Speech Bubble"><?php echo $avatar_text; ?></textarea>
		<?php
	}
	page_attributes_meta_box($post);
}

function openbadges_save_page_avatar ($post_id) {
	// Bail if we're doing an auto save  
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

	$avatars = array('gladis', 'boris', 'dorothy', 'morty');

	if (isset($_POST['page_avatar'])) {
		$avatar = $_POST['page_avatar'];
		if (in_array($avatar, $avatars)) {
			update_post_meta($post_id, 'page_avatar', $avatar);
		} else if (empty($avatar)) {
			delete_post_meta($post_id, 'page_avatar');
		}
	}

	if (isset($_POST['page_avatar_text'])) {
		$text = $_POST['page_avatar_text'];
		if (empty($text)) {
			delete_post_meta($post_id, 'page_avatar_text');
		} else {
			update_post_meta($post_id, 'page_avatar_text', $text);
		}
	}
}

function openbadges_add_meta_boxes ($post_type) {
	if (post_type_supports($post_type, 'page-attributes')) {
		// add_meta_box( $id, $title, $callback, $post_type, $context, $priority, $callback_args );

		// Remove the system-defined 'Page Attributes' box
		remove_meta_box('pageparentdiv', 'page', 'side');

		// Replace it with our own 'Page Attributes' box
		add_meta_box(
			'ob-pageparentdiv',
			'page' == $post_type ? __('Page Attributes') : __('Attributes'),
			'openbadges_page_attributes_meta_box',
			null,
			'side',
			'core'
		);
	}
}

add_action('add_meta_boxes', 'openbadges_add_meta_boxes');
add_action('save_post', 'openbadges_save_page_avatar');
