(function (window, document, $) {

	var winPanel = (function() {
		function init () {
			/**
			 * Badges 101 badge acceptance panel
			 *
			 * 0. If user skips to end, sees #incomplete panel
			 * 1. User "wins", sees #win panel with badge and backpack/navigator badge links
			 * 2. Clicks backpack, sees #get-badge subpanel with email submission form
			 * 3. Submits email, sees #after-badge subpanel with external links
			 */

			$('#incomplete').show();
			$('#win').hide();
			$('#get-badge').hide();
			$('#after-badge').hide();

			$('#push-to-backpack').one('click', function(){
				$('#nav-panel').hide();
				$('#get-badge').fadeIn();
			}); 

			$("#get-badge form").submit(function() {
				var email = $(this).find("input#email").val().trim();
				if (QuickBadge.validateEmail(email)) {
					var baseURI = $('<a href="./"></a>')[0].href;
					var hashedEmail = 'sha256$' + sha256_digest(email);
					var publish = QuickBadge.publish({
						service: "http://hackpub.hackasaurus.org/publish",
						assertion: {
							"recipient": hashedEmail,
							"badge": {
								"version": "0.5.0",
								"name": "Badges 101",
								"image": $("#badges101")[0].src,
								"description": "You really get badges!",
								"criteria": "http://badges-101.openbadges.org/",
								"issuer": {
									"origin": "http://www.openbadges.org",
									"name": "Open Badges",
									"org": "Mozilla Foundation",
									"contact": "hai2u@openbadges.org"
								}
							}
						}
					});
					$("#get-badge form").fadeOut(function() {
						$("#throbber").fadeIn(function() {
							publish.fail(function() {
								alert("Sorry, an error occurred. Please try again later.");
								$("#get-badge form").show();
								$("#throbber").hide();
							});
							publish.done(function(url) {
								$("#throbber").fadeOut();
								QuickBadge.issue(url).done(function(errors, successes) {
									if (successes.length) {
										$("#get-badge").hide();
										$("#after-badge").show();
									}
									else {
										$("#get-badge form").show();
										$("#throbber").hide();
									}
									console.log("errors", errors, "successes", successes);
								});
							});
						});
					});
				} else {
					alert("Please provide a valid e-mail address.");
				}
				return false;
			});
		}

		function show () {
			$('#incomplete').hide();
			$('#win').show();
		}

		return {
			init: init,
			show: show
		}
	})();

	var quiz = (function() {
		var questions, answered;

		function init () {
			var $quizzes = $('#badges-101 .quiz');

			questions = $quizzes.length;
		    answered = 0;

			$quizzes.find('.discussion').hide();
			$quizzes.each(function() {
				var discussion = $('.discussion', this);

				/* Show the discussion when they click the right answer */
				$('.options', this).one('click', function(evt) {
					if ($(evt.target).hasClass('correct')) {
						$('.answer', discussion).text("That's right!");
					} else {
						$('.answer', discussion).text("That's wrong!");
					}

					discussion.fadeIn();          
					answered++;

					if (answered == questions) {
						winPanel.show();
					}
				});
			})
		}

		return {
			init: init
		}
	})();

	$(function() {
		var cheat = false,
		    startSlide = 0;

		$('a.quickstart').fancybox({
			type: 'ajax',
			afterShow: function() {
				var base = this.element.href,
				    basePath = this.element.pathname;
				// Old IE bug
				if (basePath.charAt(0) != '/') basePath = '/' + basePath

				winPanel.init();
				quiz.init();

				$('#badges-101')
					.css('visibility','visible')
					.find('a[href^="'+base+'"], a[href^="'+basePath+'"]').each(function() {
						var $link = $(this),
						target;

						if (!$link.hasClass('next') && !$link.hasClass('prev')) {
							if (target = /\/(\d+)\/?$/.exec(this.href)) {
								this.href = '#' + target[1];
								$link.addClass('link');
							}
						}
					});

				if (cheat) {
					winPanel.show();
					startSlide = $('#slides .slide').length;
				}

				$('#slides').slides({
					start: startSlide
				});
			}
		})
	});

}(window, document, jQuery));