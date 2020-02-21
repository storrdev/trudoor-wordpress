(function ($) {

	var CloudFw_SEOYoast = function () {
		YoastSEO.app.registerPlugin('CloudFw_SEOYoast', {status: 'ready'});

		var _init = this;
		_init.fetchData();
	};

	CloudFw_SEOYoast.prototype.fetchData = function () {
		var _self = this;
		var textarea = jQuery('#cloudfw-composer-output');
		if ( textarea.length ) {
			_self.extra_content = textarea.val();
			YoastSEO.app.pluginReady('CloudFw_SEOYoast');
			YoastSEO.app.registerModification('content', $.proxy(_self.getContent, _self), 'CloudFw_SEOYoast', 5);
		}
	};

	CloudFw_SEOYoast.prototype.getContent = function (content) {
			var the_content = this.extra_content ? ( this.extra_content ) : content;
			return the_content;
	};

	/**
	 * YoastSEO content analysis integration
	 */
	$(window).on('YoastSEO:ready', function () {
		new CloudFw_SEOYoast();
	});

}) (jQuery);