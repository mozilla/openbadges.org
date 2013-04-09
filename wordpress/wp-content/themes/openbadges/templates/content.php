<?php

$title_parts = explode('%', get_the_title());
$title = array();

while (count($title_parts)) {
	$title[] = array_shift($title_parts);
	if (count($title_parts)) {
		$title[] = '<span class="reduce">'.array_shift($title_parts).'</span>';
	}
}

$avatar = get_post_meta($post->ID, 'page_avatar', true);

if ($avatar) {
	echo '<article class="has-avatar">';
} else {
	echo '<article>';
}

echo '<div class="content">';
echo '<h2>'.implode('', $title).'</h2>';
echo '<div class="inner">';

$content = get_the_content();
$section_parts = preg_split('#(<section(?: .+)?>|</section>)#', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
$in_section = false;
$sections = array();
$section = array();
$first = true;

foreach ($section_parts as $part) {
	if (strpos($part, '<section') === 0) {
		if (!empty($section)) {
			$sections[] = implode('', $section);
		}
		if ($first) {
			$first = false;
			$tag = preg_split('#( +\w+="[^"]*")#', $part, -1, PREG_SPLIT_DELIM_CAPTURE);
			$meta = array();
			$class = 'first no-top';
			$found = false;
			for ($i = 1; $i <= count($tag); $i += 2) {
				if (!empty($tag[$i])) {
					list($attr, $value) = explode('=', $tag[$i], 2);
					if (trim($attr) === 'class') {
						$found = true;
						$value = trim($value, ' "');
						$meta[] = ' class="'.$value.' '.$class.'"';
					} else {
						$meta[] = ' '.trim($tag[$i]);
					}
				}
			}
			if (!$found) {
				$meta[] = ' class="'.$class.'"';
			}
			$part = '<section'.implode('', $meta).'>';
		}
		$section = array($part);
		$in_section = true;
	} else if (strpos($part, '</section>') === 0) {
		$section[] = '<a href="#" class="top">Return to top</a>';
		$section[] = $part;
		$sections[] = implode('', $section);
		$section = array();
		$in_section = false;
	} else {
		$trimmed = trim($part);
		if (!empty($trimmed)) {
			$section[] = $part;
		}
	}
}

if (!empty($section)) $sections[] = implode('', $section);

echo implode('', $sections);

if (function_exists('ob_content_after')) {
	ob_content_after();
}

echo '</div>'; // .inner
echo '</div>'; // .content

if ($avatar) {
	$bubble = get_post_meta($post->ID, 'page_avatar_text', true);
	$class = array('avatar', $avatar);
	if ($bubble) $class[] = 'has-bubble';

	echo '<div class="'.implode(' ', $class).'">';
	echo '<span class="badge"></span>';
	if ($bubble) {
		echo '<div class="bubble"><div class="inner">'.$bubble.'</div></div>';
	}
	echo '</div>';
}

global $numpages, $page;
if ($numpages > 1) {
	echo '<ul class="pagination">';
	foreach (range(1, $numpages) as $index) {
		$text = __('Page '.$index);
		echo '<li class="page">';
		if ($page === $index) {
			echo '<span class="current"><span>'.$text.'</span></span>';
		} else {
			echo _wp_link_page($index).'<span>'.$text.'</span></a>';
		}
		echo '</li>';
	}
	echo '<li class="next">';
	if ($page !== $numpages) {
		echo _wp_link_page($page+1).__('Next').' &raquo;</a>';
	} else {
		echo __('Next').' &raquo;';
	}
	echo '</li>';
	echo '</ul>';
}
// echo $numpages;
// wp_link_pages(array(
// 	'before' => '<ul class="pagination">',
// 	'after' => '</ul>',
// 	'pagelink' => '<span>Page %</span>'
// ));

echo '</article>';
