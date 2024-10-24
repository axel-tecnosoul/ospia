/**
 * @class  elFinder command "back"
 * Open last visited folder
 *
 * @author Dmitry (dio) Levashov
 **/
(elFinder.prototype.commands.back = function() {
	"use strict";
	this.alwaysEnabled  = true;
	this.updateOnSelect = false;
	this.shortcuts      = [{
		pattern     : 'ctrl+left backspace'
	}];
	
	this.getstate = function() {
		return this.fm.history.canBack() ? 0 : -1;
	};
	
	this.exec = function() {
		return this.fm.history.back();
	};

}).prototype = { forceLoad : true }; // this is required command
