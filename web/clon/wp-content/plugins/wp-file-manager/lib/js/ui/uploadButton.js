/**
 * @class  elFinder toolbar's button tor upload file
 *
 * @author Dmitry (dio) Levashov
 **/
jQuery.fn.elfinderuploadbutton = function(cmd) {
	"use strict";
	return this.each(function() {
		var fm = cmd.fm,
			button = jQuery(this).elfinderbutton(cmd)
				.off('click'), 
			form = jQuery('<form></form>').appendTo(button),
			input = jQuery('<input type="file" multiple="true" title="'+cmd.fm.i18n('selectForUpload')+'"/>')
				.on('change', function() {
					var _input = jQuery(this);
					if (_input.val()) {
						fm.exec('upload', {input : _input.remove()[0]}, void(0), fm.cwd().hash);
						input.clone(true).appendTo(form);
					} 
				})
				.on('dragover', function(e) {
					e.originalEvent.dataTransfer.dropEffect = 'copy';
				}),
			tm;

		form.append(input.clone(true));
				
		cmd.change(function() {
			tm && cancelAnimationFrame(tm);
			tm = requestAnimationFrame(function() {
				var toShow = cmd.disabled();
				if (form.is('visible')) {
					!toShow && form.hide();
				} else {
					toShow && form.show();
				}
			});
		})
		.change();
	});
};
