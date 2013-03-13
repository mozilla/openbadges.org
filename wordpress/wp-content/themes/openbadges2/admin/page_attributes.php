<?php

/*
 * Meta boxes
 */

function get_title_alignments () {
	return array(
		'left' => 'Left',
		'center' => 'Center',
		'right' => 'Right',
		'hidden' => 'Hidden',
	);
}

function openbadges_page_attributes_meta_box ($post) {
	if ('page' == $post->post_type) {
		$title_alignment = get_post_meta($post->ID, 'title_alignment', true);
		$embellished = !!get_post_meta($post->ID, 'embellish_page', true);
		$hide_meta = get_post_meta($post->ID, 'hide_meta', true);
		?>
		<p><strong><?php _e('Title Alignment') ?></strong></p>
		<label class="screen-reader-text" for="title_alignment"><?php _e('Title Placement'); ?></label>
		<select name="title_alignment" id="title_alignment">
			<option value=""><?php _e('(default)'); ?></option>
			<?php
				foreach (get_title_alignments() as $alignment => $label) {
					echo '<option value="'.$alignment.'"'.selected($title_alignment,$alignment,false).'>'._($label).'</option>';
				}
			?>
		</select>
		<p><strong><?php _e('Embellishment') ?></strong></p>
		<input type="checkbox" name="embellish_page" id="embellish_page"<?php if ($embellished): ?> checked="checked"<?php endif; ?> value="1">
			<label for="embellish_page">Show Open Badges logo at bottom</label>
		<p><strong><?php _e('Meta Block') ?></strong></p>
		<input type="checkbox" name="hide_meta" id="hide_meta"<?php if ($hide_meta): ?> checked="checked"<?php endif; ?> value="1">
			<label for="hide_meta">Hide global meta block</label>
		<?php
	}
	page_attributes_meta_box($post);
}

function openbadges_save_embellishment ($post_id) {
	// Bail if we're doing an auto save
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

	if (isset($_POST['title_alignment'])) {
		$alignments = array_keys(get_title_alignments());
		$alignment = $_POST['title_alignment'];
		if (in_array($alignment, $alignments)) {
			update_post_meta($post_id, 'title_alignment', $alignment);
		} else if (empty($alignment)) {
			delete_post_meta($post_id, 'title_alignment');
		}
	}

	if (isset($_POST['embellish_page']) && !!$_POST['embellish_page']) {
		update_post_meta($post_id, 'embellish_page', true);
	} else {
		delete_post_meta($post_id, 'embellish_page');
	}

	if (isset($_POST['hide_meta']) && !!$_POST['hide_meta']) {
		update_post_meta($post_id, 'hide_meta', true);
	} else {
		delete_post_meta($post_id, 'hide_meta');
	}
}

function openbadges_add_page_attributes_box ($post_type) {
	if (post_type_supports($post_type, 'page-attributes')) {

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

add_action('add_meta_boxes', 'openbadges_add_page_attributes_box');
add_action('save_post', 'openbadges_save_embellishment');
