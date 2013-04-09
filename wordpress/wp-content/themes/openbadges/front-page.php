<?php

function ob_content_after () {
?>
	<a href="#badges-101" id="get-started" class="button large right-arrow fancybox">get started</a>
	<a href="http://beta.openbadges.org" id="backpack" class="right-arrow" style="float: right; line-height: 48px;">visit your Mozilla Badge Backpack</a>
<?php
}

get_header();

if (have_posts()) {
	while (have_posts()) {
		the_post();
		get_template_part('templates/content', get_post_format());
	}
} else {
	
}

$menus = get_nav_menu_locations();
if (isset($menus['front-page'])) {
	$items = wp_get_nav_menu_items($menus['front-page']);
	if (!empty($items)) {
		echo '<ul class="featured">';
		foreach ($items as $item) {
			$class = sanitize_title($item->title);
			echo '<li class="'.$class.'"><a href="'.$item->url.'">';
			echo '<div class="badge"><span></span></div>';
			echo '<h3 class="title">'.$item->title.'</h3>';
			echo '<p>'.$item->post_excerpt.'</p>';
			echo '</a></li>';
		}
		echo '</ul>';
	}
// wp_nav_menu(array('theme_location' => 'front-page', 'container_class' => 'feature', 'fallback_cb' => false));
}

?>
<div id="badges-101">
	<div id="slides" role="main">
		<div class="slides_container">    
			<div id="intro" class="slide">
				<h1>Open Badges</h1>
				<p class="tagline">Helping learners everywhere display skills, unlock career opportunities and level up in life</p>
				<p>Let’s go through some of the basics about badges and earn your first badge in the process.</p>
				<a class="next button">Start</a>
			</div>
			<div class="lesson slide">
				<h1>Learning today happens everywhere.</h1>
				<p class="detail"> But it's often difficult to get recognition for skills and achievements that happen outside of school. Mozilla's Open Badges is working to solve that problem, making it easy for anyone to issue, earn and display badges across the web—through a shared infrastructure that's free and open to all.</p>        
				<a class="next button">Next</a>
			</div>
			<div class="lesson slide">
				<h1>Open Badge Infrastructure</h1>
				<p class="detail">The Mozilla Open Badge Infrastructure enables any organization or community to issue badges backed by their own seal of approval. Learners/users can then collect badges from different sources and share them across the web, unlocking new career and learning opportunities.</p>
				<a class="next button">Next</a>
			</div>
			<div class="quiz slide">
				<h1>Your First Badge</h1>
				<p id="quiz-intro">Now let's see how much you get badges!</p>
				<section class="question">
					<p>True or False: Learning today happens everywhere, not just in classrooms.</p>
				</section>
				<section class="options">
					<a class="true button correct">True</a>
					<a class="false button">False</a>
				</section>
				<section class="discussion">
					<p><span class="answer">Answer: True.</span> There are countless examples of learning occurring through informal channels. The web and other new learning spaces provide exciting new ways to gain skills and experiences—from online courses, learning networks and mentorship to peer learning, volunteering and after-school programs.</p>
					<a class="next button">Next</a>
				</section>
			</div>
			<div class="quiz slide">
				<h1>Your First Badge</h1>
				<section class="question">
					<p>True or False: You can understand a person’s skill set simply by looking at their degree.</p>
				</section>
				<section class="options">
					<a class="true button">True</a>
					<a class="false button correct">False</a>
				</section>
				<section class="discussion">
					<p><span class="answer">Answer: False.</span> While degrees do convey information about people’s skills, they often tend to be abstracted from the actual learning that has occurred. Two people with the same degree may have taken very different learning pathways or developed different skills. Many people without a formal degree possess a vast set of job-relevant skills. Badges help by providing a more complete picture, recognizing a more granular set of skills.</p>
					<a class="next button">Next</a>
				</section>
			</div>
			<div class="quiz slide">
				<h1>Your First Badge</h1>
				<section class="question">
					<p>True or False: Resumes are validated and evidence-based.</p>
				</section>
				<section class="options">
					<a class="true button">True</a>
					<a class="false button correct">False</a>
				</section>
				<section class="discussion">
					<p>
						<span class="answer">Answer: False.</span> Resumes are documents that people write themselves. Granular information on a resume is often difficult to validate. With digital badges, users can click on a given badge to access information about the badge’s issuer, how the badge was earned, and more. In other words, badges can go beyond traditional resumes by providing built-in evidence for validation.  
					</p>
					<a class="next button">Next</a>
				</section>
			</div>
			<div id="final" class="slide">
				<section id="incomplete">
					<p>Take the quiz to see if you get badges!</p>
				</section>
				<section id="win">
					<!-- Point to the image on github so that the backpack can access it if the user decides to send their badge there. -->
					<img id="badges101" src="https://github.com/toolness/openbadges.org/raw/master/static/img/index/101badge.png" alt="Badges 101 Badge" />
					<h1>Badges 101</h1>
					<p>Congratulations! You’ve just earned the Badges 101 badge!</p>
					<section id="nav-panel">
						<nav>
							<a id="push-to-backpack" class="backpack">Push this badge to your Mozilla backpack</a>
							<a class="navigator" href="http://toolness.github.com/hackasaurus-parable/navigator-badge/#">Go earn the Hackasaurus Navigator badge</a>
						</nav>
					</section>
					<section id="get-badge">
						<p class="instructions">If you'd like to send this badge to your Mozilla backpack, just fill out the form below.</p>
						<form>
							<label for="email">Your E-mail Address</label>
							<input type="email" id="email" placeholder="E-mail Address">
							<input type="submit" value="Send To Backpack »" id="submit">
						</form>
						<p><small>This will push your badge to the Mozilla Badge Backpack which is governed by the Mozilla Badge Backpack Terms of Use and Privacy Policy.</small></p>
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/images/ajax-loader.gif" id="throbber" style="display: none" alt="ajax throbber" >
					</section>
					<section id="after-badge">
						<nav>
							<a class="backpack" href="http://beta.openbadges.org/">Visit your Mozilla backpack</a>
							<a class="navigator" href="http://toolness.github.com/hackasaurus-parable/navigator-badge/#">Go earn the Hackasaurus Navigator badge</a>
						</nav>
					</section>
				</section>
			</div>
		</div>
	</div>
</div>
<?php

get_footer();

