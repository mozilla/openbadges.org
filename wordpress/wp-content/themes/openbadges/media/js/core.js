(function (window, document, $) {

	$(function() {
		$('.fancybox-quiz').click(function(evt) {
			evt.preventDefault();
			var target = this.href;

			$.fancybox.showLoading();

			$.ajax(target).done(function(html) {
				var $container = $(document.createElement('div')).html(html),
				    $slides = $(document.createElement('div')).append($container.find('.inner').addClass('slide'));

				$slides.attr('id', 'slideshow');

				$.fancybox($slides, {
					autoDimensions: false,
					autoScale: false,
					width: 350,
					height: 'auto'
				});
			});
		});
	});

}(window, document, jQuery));
