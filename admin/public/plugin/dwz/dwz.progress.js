/*
 * jQuery Progress Bar plugin
 * Version 1.1.0 (06/20/2008)
 * @requires jQuery v1.2.1 or later
 *
 * Copyright (c) 2008 Gary Teo
 * http://t.wits.sg

USAGE:
	$(".someclass").progressBar();
	$("#progressbar").progressBar();
	$("#progressbar").progressBar(45);							// percentage
	$("#progressbar").progressBar({showText: false });			// percentage with config
	$("#progressbar").progressBar(45, {showText: false });		// percentage with config
*/
(function($) {
	$.extend({
		
		progress: new function() {

			this.defaults = {
				increment	: 2,
				speed		: 15,
				showText	: true,			// show text with percentage in next to the progressbar? - default : true
				width		: 400,			// Width of the progressbar - don't forget to adjust your image too!!!
				height		: 12,			// Height of the progressbar - don't forget to adjust your image too!!!
				boxImage	: '/platform/backend/public/theme/default/images/process/progressbar.gif',						// boxImage : image around the progress bar
				barImage	:{
								0:	'/platform/backend/public/theme/default/images/process/progressbg_red.gif',
								30: '/platform/backend/public/theme/default/images/process/progressbg_orange.gif',
								70: '/platform/backend/public/theme/default/images/process/progressbg_green.gif'
							}
				// Image to use in the progressbar. Can be a single image too: 'images/progressbg_green.gif'
			};
			
			/* public methods */
			this.construct = function(arg1, arg2) {
				var argpercentage	= null;
				var argconfig		= null;
				
				if (arg1 != null) {
					if (!isNaN(arg1)) {
						argpercentage 	= arg1;
						if (arg2 != null) {
							argconfig	= arg2; }
					} else {
						argconfig		= arg1; 
					}
				}
				
				return this.each(function(child) {
					var pb		= this;
					if (argpercentage != null && this.bar != null && this.config != null) {
						this.config.tpercentage	= argpercentage;
						if (argconfig != null)
							pb.config			= $.extend(this.config, argconfig);
					} else {
						var $this				= $(this);
						var config				= $.extend({}, $.progress.defaults, argconfig);
						var percentage			= argpercentage;
						if (argpercentage == null)
							var percentage		= $this.html().replace("%","");	// parsed percentage
						
						
						$this.html("");
						var bar					= document.createElement('img');
						var text				= document.createElement('div');
						bar.id 					= this.id + "_percentImage";
						text.id 				= this.id + "_percentText";
						bar.title				= percentage + "%";
						bar.alt					= percentage + "%";
						bar.src					= config.boxImage;
						bar.width				= config.width;
						var $bar				= $(bar);
						var $text				= $(text);
						
						this.bar				= $bar;
						this.ntext				= $text;
						this.config				= config;
						this.config.cpercentage	= 0;
						this.config.tpercentage	= percentage;
						
						$bar.css("width" ,config.width + "px");
						$bar.css("height",config.height + "px");
						$bar.css("background-image", "url(" + getBarImage(this.config.cpercentage, config) + ")");
						$bar.css("padding", "0");
						$this.append($bar);
						$this.append($text);
					}
					
					function getBarImage (percentage, config) {
						var image = config.barImage;
						if (typeof(config.barImage) == 'object') {
							for (var i in config.barImage) {
								if (percentage >= parseInt(i)) {
									image = config.barImage[i];
								}
								else{ 
									break; 
								}
							}
						}
						return image;
					}
					
					var t = setInterval(function() {
						var config		= pb.config;
						var cpercentage = parseInt(config.cpercentage);
						var tpercentage = parseInt(config.tpercentage);
						var increment	= parseInt(config.increment);
						var bar			= pb.bar;
						var text		= pb.ntext;
						var pixels		= config.width / 100;			// Define how many pixels go into 1%
						
						bar.css("background-image", "url(" + getBarImage(cpercentage, config) + ")");
						bar.css("background-position", (((config.width * -1)) + (cpercentage * pixels)) + 'px 50%');
						
						if (config.showText)
							text.html(" " + Math.round(cpercentage) + "%");
						
						if (cpercentage > tpercentage) {
							if (cpercentage - increment  < tpercentage) {
								pb.config.cpercentage = 0 + tpercentage
							} else {
								pb.config.cpercentage -= increment;
							}
						}
						else if (pb.config.cpercentage < pb.config.tpercentage) {
							if (cpercentage + increment  > tpercentage) {
								pb.config.cpercentage = tpercentage
							} else {
								pb.config.cpercentage += increment;
							}
						} 
						else {
							clearInterval(t);
						}
					}, pb.config.speed); 
				});
			};
		}
	});
		
	$.fn.extend({
		progress: $.progress.construct
	});
	
})(jQuery);