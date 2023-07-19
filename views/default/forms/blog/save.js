/**
 * Blog save form
 */
define(['jquery', 'elgg/Ajax'], function($, Ajax) {
	// preview button clicked
	$(document).on('click', '.elgg-form-blog-save button[name="preview"]', function(event) {
		event.preventDefault();
		
		var ajax = new Ajax();
		var formData = ajax.objectify('form.elgg-form-blog-save');
		
		if (!(formData.get('description') && formData.get('title'))) {
			return false;
		}
		
		// @todo check this in Elgg 5.1
		formData.append('preview', 1);
		
		// open preview in blank window
		ajax.action('blog/save', {
			data: formData,
			success: function(data) {
				$('form.elgg-form-blog-save').find('input[name=guid]').val(data.guid);
				window.open(data.url, '_blank').focus();
			}
		});
	});
});
