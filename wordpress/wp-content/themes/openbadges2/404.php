<?php

function add_body_classes ($classes) {
	$classes[] = 'narrow';
	return $classes;
}

add_filter('body_class','add_body_classes');

get_header();

?>
<article>
	<h2>Oh noes!</h2>
	<p>Looks like that page doesn't exist.</p>
</article>
<?php

get_footer();
