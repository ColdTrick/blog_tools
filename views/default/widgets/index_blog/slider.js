define(function(require) {
	
	var $ = require('jquery');
	
	function slider() {
		
		var that = this;
		var timer;
		var $widget_content;
		var $navigator;
		var $container;
		
		this.init = function(widget_guid) {
			$widget_content = $('#elgg-widget-content-' + widget_guid);
			$navigator = $widget_content.find('.blog-tools-widget-items-navigator');
			$container = $widget_content.find('.blog-tools-widget-items-container');
			
			$navigator.on('click', 'li', this.clickNavigator);
			timer = setTimeout(that.rotateItems, 10000);
		};
		
		this.clickNavigator = function() {
			clearTimeout(timer);
			
			var $li = $(this);
			var guid = $li.find('> span').eq(0).attr('rel');
			
			$navigator.find('li').removeClass('elgg-state-selected');
			$li.addClass('elgg-state-selected');
			
			$container.find('.elgg-item').hide();
			$container.find('#elgg-object-' + guid).show();
			
			timer = setTimeout(that.rotateItems, 10000);
		};
		
		this.rotateItems = function() {
			if ($navigator.find('li.elgg-state-selected').next().length) {
				$navigator.find('li.elgg-state-selected').next().click();
			} else {
				$navigator.find('li:first').click();
			}
		};
	};
	
	return slider;
});
