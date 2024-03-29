/* global wp, jQuery */
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

function hexToRgbA(hex, opacity) {
	var color;
	if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
		color = hex.substring(1).split('');
		if (color.length == 3) {
			color = [color[0], color[0], color[1], color[1], color[2], color[2]];
		}
		color = '0x' + color.join('');
		return 'rgba(' + [(color >> 16) & 255, (color >> 8) & 255, color & 255].join(',') + ',' + opacity + ' )';
	}
	throw new Error('Bad Hex');
}
function striphasfromhex(hex) {
	return hex.slice(1);
}
/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 * 
 * It controls the pseudo code as well
 */
function triphub_colors_live_update(thememod, selector, property, rgb) {

	wp.customize(thememod, function (value) {
		value.bind(function (newval) {

			var color = '';
				
			if ( newval[0] === '#') {
				color = newval;
			} else { //change rgba to hex
				const rgba = newval.replace(/^rgba?\(|\s+|\)$/g, '').split(',');
				color = `#${((1 << 24) + (parseInt(rgba[0]) << 16) + (parseInt(rgba[1]) << 8) + parseInt(rgba[2])).toString(16).slice(1)}`;
			}

			//get rgb values
			var rgbVal = color.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i
							,(m, r, g, b) => '#' + r + r + g + g + b + b)
				.substring(1).match(/.{2}/g)
				.map(x => parseInt(x, 16))
				.toString()
			
			if (jQuery('style#' + thememod + property).length) {
				jQuery('style#' + thememod + property).html(selector + '{' + property + ':' + newval + ';}');
				if (rgb !== undefined ){
					jQuery('style#' + thememod + property + '-rgb').html(selector + '{' + rgb + ':' + rgbVal + ';}');
				} 
			} else {
				jQuery('head').append('<style id="' + thememod + property + '">' + selector + '{' + property + ':' + newval + '}</style>');
				setTimeout(function () {
					jQuery('style#' + thememod + property).not(':last').remove();
				}, 1000);
				if (rgb !== undefined ){
					jQuery('head').append('<style id="' + thememod + property + '-rgb">' + selector + '{' + rgb + ':' + rgbVal + '}</style>');
					setTimeout(function () {
						jQuery('style#' + thememod + property +'-rgb').not(':last').remove();
					}, 1000);
				} 
			}
		});
	});
}

function triphub_width_live_update(thememod, selector, property) {
	wp.customize(thememod, function (value) {
		value.bind(function (newval) {
			jQuery(selector).css(property, newval + 'px');
		});
	});
}

function triphub_sync_root_variable(thememod, selector, property) {
	wp.customize(thememod, function (value) {
		value.bind(function (newval) {
			jQuery(selector).css(property, newval);
		});
	});
}

// TripHub Font Family Update
function triphub_typo_update_font_family_css(control, selector, cssProperty = 'font-family' ) {
	wp.customize(control, function (value) {
		value.bind(function (value, oldValue) {

			var link = '';

			var fontName = value.split(",")[0];
			fontName = fontName.replace(/'/g, '');

			if (value === 'System Stack') {
				value = triphub_view_port.systemfonts;
			}

			// Remove <style> first!
			control = control.replace('[', '-');
			control = control.replace(']', '');

			jQuery('style#' + control + '-' + cssProperty).remove();

			var fontName = fontName.split(' ').join('+');

			jQuery('link#' + control).remove();
			link = '<link id="' + control + '" href="https://fonts.googleapis.com/css?family=' + fontName + '"  rel="stylesheet">';

			// Concat and append new <style> and <link>.
			jQuery('head').append(
				'<style id="' + control + '-' + cssProperty + '">'
				+ selector + '	{ ' + cssProperty + ': ' + value + ' }'
				+ '</style>'
				+ link
			);
		});
	});
}

//TripHub Font Weight and others update 
function triphub_typography_live_update(id, responsive, selector, property, unit, settings) {
	settings = typeof settings !== 'undefined' ? settings : '';
	
	var media = 'desktop' === responsive ? triphub_view_port.desktop
				: 'tablet' === responsive ? triphub_view_port.tablet
				: 'mobile' === responsive ? triphub_view_port.mobile
				: undefined;

	// Check if media query
	var media_query = typeof media !== 'undefined' ? ' media="' + media + '"' : '';

	var responsive_id = '' !== responsive ? `[${responsive}]` : ''; //Responsive should be empty for Font Weight and Text Transform
	wp.customize(settings + responsive_id + '[' + id + ']', function (value) {	
		value.bind(function (newval) {
			// Get our unit if applicable
			unit = typeof unit !== 'undefined' ? unit : '';
			jQuery('head').append('<style id="' + responsive + id + settings + '" ' + settings + media_query + '>' + selector + '{' + property + ':' + newval + unit + ';}' + '</style>');
			setTimeout(function () {
				jQuery('style#' + responsive + id + settings).not(':last').remove();
			}, 500);

		});
	});
}
//TripHub partial refresh for slider customizer settings
function triphub_slider_live_update(settings, responsive, selector, property, unit) {
	settings = typeof settings !== 'undefined' ? settings : '';
	
	var media = 'desktop' === responsive ? triphub_view_port.desktop
				: 'tablet' === responsive ? triphub_view_port.tablet
				: 'mobile' === responsive ? triphub_view_port.mobile
				: undefined;

	// Check if media query
	var media_query = typeof media !== 'undefined' ? ' media="' + media + '"' : '';

	wp.customize(settings, function (value) {	
		value.bind(function (newval) {
			// Get our unit if applicable
			unit = typeof unit !== 'undefined' ? unit : '';
			jQuery('head').append('<style id="triphub_' + settings + '" ' + media_query + '>' + selector + '{' + property + ':' + newval + unit + ';}' + '</style>');
			setTimeout(function () {
				jQuery('style#triphub_' + settings).not(':last').remove();
			}, 500);

		});
	});
}

//TripHub partial refresh for spacing customizer settings
function triphub_spacing_live_update(settings, responsive, selector, property, unit) {
	settings = typeof settings !== 'undefined' ? settings : '';
	
	var media = 'desktop' === responsive ? triphub_view_port.desktop
				: 'tablet' === responsive ? triphub_view_port.tablet
				: 'mobile' === responsive ? triphub_view_port.mobile
				: undefined;

	// Check if media query
	var media_query = typeof media !== 'undefined' ? ' media="' + media + '"' : '';

	wp.customize(settings + '[top]', function (value) {	
		value.bind(function (newval) {
			unit = typeof unit !== 'undefined' ? unit : '';
			jQuery('head').append('<style id="triphub_' + settings + 'top" ' + media_query + '>' + selector + '{' + property + '-top:' + newval + unit + ';}' + '</style>');
			setTimeout(function () {
				jQuery('style#triphub_' + settings + 'top').not(':last').remove();
			}, 500);
		})
	});

	wp.customize(settings + '[right]', function (value) {	
		value.bind(function (newval) {
			unit = typeof unit !== 'undefined' ? unit : '';
			jQuery('head').append('<style id="triphub_' + settings + 'right" ' + media_query + '>' + selector + '{' + property + '-right:' + newval + unit + ';}' + '</style>');
			setTimeout(function () {
				jQuery('style#triphub_' + settings + 'right').not(':last').remove();
			}, 500);
		})
	});

	wp.customize(settings + '[bottom]', function (value) {	
		value.bind(function (newval) {
			unit = typeof unit !== 'undefined' ? unit : '';
			jQuery('head').append('<style id="triphub_' + settings + 'bottom" ' + media_query + '>' + selector + '{' + property + '-bottom:' + newval + unit + ';}' + '</style>');
			setTimeout(function () {
				jQuery('style#triphub_' + settings + 'bottom').not(':last').remove();
			}, 500);
		})
	});

	wp.customize(settings + '[left]', function (value) {	
		value.bind(function (newval) {
			unit = typeof unit !== 'undefined' ? unit : '';
			jQuery('head').append('<style id="triphub_' + settings + 'left" ' + media_query + '>' + selector + '{' + property + '-left:' + newval + unit + ';}' + '</style>');
			setTimeout(function () {
				jQuery('style#triphub_' + settings + 'left').not(':last').remove();
			}, 500);
		})
	});
}

(function ($) {
	// Site title and description.
	wp.customize('blogname', function (value) {
		value.bind(function (to) {
			$('.site-title a').text(to);
		});
	});
	wp.customize('blogdescription', function (value) {
		value.bind(function (to) {
			$('.site-description').text(to);
		});
	});

	wp.customize('hide_title', function (value) {
		value.bind(function (to) {
			if (to) {
				$('.site-title').css({
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute',
				});
			} else {
				$('.site-title').css({
					clip: 'auto',
					position: 'relative',
				});
			}
		});
	});

	wp.customize('hide_tagline', function (value) {
		value.bind(function (to) {
			if (to) {
				$('.site-description').css({
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute',
				});
			} else {
				$('.site-description').css({
					clip: 'auto',
					position: 'relative',
				});
			}
		});
	});


	/**********************
	Typography Font Family
	***********************/
	/**
	 * Site Title Font Family
	 */
	triphub_typo_update_font_family_css('site_title[family]','.site-branding .site-title a');
	/**
	 * Primary Font Family
	 */
	 triphub_typo_update_font_family_css('primary_font[family]', ':root', '--triphub-primary-font-family');
	/**
	 * Button Font Family
	 */
	triphub_sync_root_variable('button[family]', ':root', '--triphub-btn-font-family');
	/**
	 * Heading One Family
	 */
	triphub_typo_update_font_family_css('heading_one[family]', 'h1');
	/**
	 * Heading Two Family
	*/
	triphub_typo_update_font_family_css('heading_two[family]', 'h2');
	/**
	 * Heading Three Family
	*/
	triphub_typo_update_font_family_css('heading_three[family]', 'h3');
	/**
	 * Heading Four Family
	*/
	triphub_typo_update_font_family_css('heading_four[family]', 'h4');
	/**
	 * Heading Five Family
	*/
	triphub_typo_update_font_family_css('heading_five[family]', 'h5');
	/**
	 * Heading Six Family
	*/
	triphub_typo_update_font_family_css('heading_six[family]', 'h6');
	

	/**********************************
			Typography Font Weight
	***********************************/
	/**
	 * Site Title Font Weight 
	*/
	triphub_typography_live_update( 'weight', '', '.site-branding .site-title a', 'font-weight', '', 'site_title' );
	/**
	 * Primary Font Weight 
	*/
	triphub_typography_live_update( 'weight', '', ':root', '--triphub-primary-font-weight', '', 'primary_font' );
	/**
	 * Button Font Weight 
	*/
	triphub_typography_live_update( 'weight', '', ':root', '--triphub-btn-font-weight', '', 'button' );
	/**
	 * Heading One Font Weight 
	*/
	triphub_typography_live_update( 'weight', '', 'h1', 'font-weight', '', 'heading_one' );
	/**
	 * Heading Two Font Weight 
	*/
	triphub_typography_live_update( 'weight', '', 'h2', 'font-weight', '', 'heading_two' );
	/**
	 * Heading Three Font Weight 
	*/
	triphub_typography_live_update( 'weight', '', 'h3', 'font-weight', '', 'heading_three' );
	/**
	 * Heading Four Font Weight 
	*/
	triphub_typography_live_update( 'weight', '', 'h4', 'font-weight', '', 'heading_four' );
	/**
	 * Heading Five Font Weight 
	*/
	triphub_typography_live_update( 'weight', '', 'h5', 'font-weight', '', 'heading_five' );
	/**
	 * Heading Six Font Weight 
	*/
	triphub_typography_live_update( 'weight', '', 'h6', 'font-weight', '', 'heading_six' );

	/**********************************
			Typography Text Transform
	***********************************/
	/**
	 * Site Title Text Transform 
	*/
	triphub_typography_live_update( 'transform', '', '.site-branding .site-title a', 'text-transform', '', 'site_title' );
	/**
	 * Primary Font Text Transform 
	*/
	triphub_typography_live_update( 'transform', '', ':root', '--triphub-primary-font-transform', '', 'primary_font' );
	/**
	 * Btton Font Text Transform 
	*/
	triphub_typography_live_update( 'transform', '', ':root', '--triphub-btn-font-transform', '', 'button' );
	/**
	 * Heading One Text Transform 
	*/
	triphub_typography_live_update( 'transform', '', 'h1', 'text-transform', '', 'heading_one' );
	/**
	 * Heading Two Text Transform 
	*/
	triphub_typography_live_update( 'transform', '', 'h2', 'text-transform', '', 'heading_two' );
	/**
	 * Heading Three Text Transform 
	*/
	triphub_typography_live_update( 'transform', '', 'h3', 'text-transform', '', 'heading_three' );
	/**
	 * Heading Four Text Transform 
	*/
	triphub_typography_live_update( 'transform', '', 'h4', 'text-transform', '', 'heading_four' );
	/**
	 * Heading Five Text Transform 
	*/
	triphub_typography_live_update( 'transform', '', 'h5', 'text-transform', '', 'heading_five' );
	/**
	 * Heading Six Text Transform 
	*/
	triphub_typography_live_update( 'transform', '', 'h6', 'text-transform', '', 'heading_six' );

	/**********************************
			Typography Font Size
	***********************************/

	/**
	 * Site Title Font Size 
	*/
	//Desktop
	triphub_typography_live_update( 'font_size', 'desktop', '.site-header .site-branding .site-title a', 'font-size', 'px', 'site_title' );
	//Tablet
	triphub_typography_live_update( 'font_size', 'tablet', '.mobile-header .site-branding .site-title a', 'font-size', 'px', 'site_title' );
	//Mobile
	triphub_typography_live_update( 'font_size', 'mobile', '.mobile-header .site-branding .site-title a', 'font-size', 'px', 'site_title' );

	/**
	 * Primary Font Size 
	*/
	//Desktop
	triphub_typography_live_update( 'font_size', 'desktop', ':root', '--triphub-primary-font-size', 'px', 'primary_font' );
	//Tablet
	triphub_typography_live_update( 'font_size', 'tablet', ':root', '--triphub-primary-font-size', 'px', 'primary_font' );
	//Mobile
	triphub_typography_live_update( 'font_size', 'mobile', ':root', '--triphub-primary-font-size', 'px', 'primary_font' );

	/**
	 * Button Font Size 
	*/
	//Desktop
	triphub_typography_live_update( 'font_size', 'desktop', ':root', '--triphub-btn-font-size', 'px', 'button' );
	//Tablet
	triphub_typography_live_update( 'font_size', 'tablet', ':root', '--triphub-btn-font-size', 'px', 'button' );
	//Mobile
	triphub_typography_live_update( 'font_size', 'mobile', ':root', '--triphub-btn-font-size', 'px', 'button' );

	/**
	 * Heading One Font Size 
	*/
	//Desktop
	triphub_typography_live_update( 'font_size', 'desktop', 'h1', 'font-size', 'px', 'heading_one' );
	//Tablet
	triphub_typography_live_update( 'font_size', 'tablet', 'h1', 'font-size', 'px', 'heading_one' );
	//Mobile
	triphub_typography_live_update( 'font_size', 'mobile', 'h1', 'font-size', 'px', 'heading_one' );

	/**
	 * Heading Two Font Size 
	*/
	//Desktop
	triphub_typography_live_update( 'font_size', 'desktop', 'h2', 'font-size', 'px', 'heading_two' );
	//Tablet
	triphub_typography_live_update( 'font_size', 'tablet', 'h2', 'font-size', 'px', 'heading_two' );
	//Mobile
	triphub_typography_live_update( 'font_size', 'mobile', 'h2', 'font-size', 'px', 'heading_two' );

	/**
	 * Heading Three Font Size 
	*/
	//Desktop
	triphub_typography_live_update( 'font_size', 'desktop', 'h3', 'font-size', 'px', 'heading_three' );
	//Tablet
	triphub_typography_live_update( 'font_size', 'tablet', 'h3', 'font-size', 'px', 'heading_three' );
	//Mobile
	triphub_typography_live_update( 'font_size', 'mobile', 'h3', 'font-size', 'px', 'heading_three' );

	/**
	 * Heading Four Font Size 
	*/
	//Desktop
	triphub_typography_live_update( 'font_size', 'desktop', 'h4', 'font-size', 'px', 'heading_four' );
	//Tablet
	triphub_typography_live_update( 'font_size', 'tablet', 'h4', 'font-size', 'px', 'heading_four' );
	//Mobile
	triphub_typography_live_update( 'font_size', 'mobile', 'h4', 'font-size', 'px', 'heading_four' );

	/**
	 * Heading Five Font Size 
	*/
	//Desktop
	triphub_typography_live_update( 'font_size', 'desktop', 'h5', 'font-size', 'px', 'heading_five' );
	//Tablet
	triphub_typography_live_update( 'font_size', 'tablet', 'h5', 'font-size', 'px', 'heading_five' );
	//Mobile
	triphub_typography_live_update( 'font_size', 'mobile', 'h5', 'font-size', 'px', 'heading_five' );

	/**
	 * Heading Six Font Size 
	*/
	//Desktop
	triphub_typography_live_update( 'font_size', 'desktop', 'h6', 'font-size', 'px', 'heading_six' );
	//Tablet
	triphub_typography_live_update( 'font_size', 'tablet', 'h6', 'font-size', 'px', 'heading_six' );
	//Mobile
	triphub_typography_live_update( 'font_size', 'mobile', 'h6', 'font-size', 'px', 'heading_six' );


	/**********************************
			Typography Line Height
	***********************************/

	/**
	 * Site Title Line Height 
	*/
	//Desktop
	triphub_typography_live_update( 'line_height', 'desktop', '.site-header .site-branding .site-title a', 'line-height', 'em', 'site_title' );
	//Tablet
	triphub_typography_live_update( 'line_height', 'tablet', '.mobile-header .site-branding .site-title a', 'line-height', 'em', 'site_title' );
	//Mobile
	triphub_typography_live_update( 'line_height', 'mobile', '.mobile-header .site-branding .site-title a', 'line-height', 'em', 'site_title' );
	
	/**
	 * Primary Font Line Height 
	*/
	//Desktop
	triphub_typography_live_update( 'line_height', 'desktop', ':root', '--triphub-primary-font-height', 'em', 'primary_font' );
	//Tablet
	triphub_typography_live_update( 'line_height', 'tablet', ':root', '--triphub-primary-font-height', 'em', 'primary_font' );
	//Mobile
	triphub_typography_live_update( 'line_height', 'mobile', ':root', '--triphub-primary-font-height', 'em', 'primary_font' );

	/**
	 * Button Font Line Height 
	*/
	//Desktop
	triphub_typography_live_update( 'line_height', 'desktop', ':root', '--triphub-btn-font-height', 'em', 'button' );
	//Tablet
	triphub_typography_live_update( 'line_height', 'tablet', ':root', '--triphub-btn-font-height', 'em', 'button' );
	//Mobile
	triphub_typography_live_update( 'line_height', 'mobile', ':root', '--triphub-btn-font-height', 'em', 'button' );
	
	/**
	 * Heading One Line Height 
	*/
	//Desktop
	triphub_typography_live_update( 'line_height', 'desktop', 'h1', 'line-height', 'em', 'heading_one' );
	//Tablet
	triphub_typography_live_update( 'line_height', 'tablet', 'h1', 'line-height', 'em', 'heading_one' );
	//Mobile
	triphub_typography_live_update( 'line_height', 'mobile', 'h1', 'line-height', 'em', 'heading_one' );
	
	/**
	 * Heading Two Line Height 
	*/
	//Desktop
	triphub_typography_live_update( 'line_height', 'desktop', 'h2', 'line-height', 'em', 'heading_two' );
	//Tablet
	triphub_typography_live_update( 'line_height', 'tablet', 'h2', 'line-height', 'em', 'heading_two' );
	//Mobile
	triphub_typography_live_update( 'line_height', 'mobile', 'h2', 'line-height', 'em', 'heading_two' );
	
	/**
	 * Heading Three Line Height 
	*/
	//Desktop
	triphub_typography_live_update( 'line_height', 'desktop', 'h3', 'line-height', 'em', 'heading_three' );
	//Tablet
	triphub_typography_live_update( 'line_height', 'tablet', 'h3', 'line-height', 'em', 'heading_three' );
	//Mobile
	triphub_typography_live_update( 'line_height', 'mobile', 'h3', 'line-height', 'em', 'heading_three' );
	/**
	 * Heading Four Line Height 
	*/
	//Desktop
	triphub_typography_live_update( 'line_height', 'desktop', 'h4', 'line-height', 'em', 'heading_four' );
	//Tablet
	triphub_typography_live_update( 'line_height', 'tablet', 'h4', 'line-height', 'em', 'heading_four' );
	//Mobile
	triphub_typography_live_update( 'line_height', 'mobile', 'h4', 'line-height', 'em', 'heading_four' );
	
	/**
	 * Heading Five Line Height 
	*/
	//Desktop
	triphub_typography_live_update( 'line_height', 'desktop', 'h5', 'line-height', 'em', 'heading_five' );
	//Tablet
	triphub_typography_live_update( 'line_height', 'tablet', 'h5', 'line-height', 'em', 'heading_five' );
	//Mobile
	triphub_typography_live_update( 'line_height', 'mobile', 'h5', 'line-height', 'em', 'heading_five' );
	
	/**
	 * Heading Six Line Height 
	*/
	//Desktop
	triphub_typography_live_update( 'line_height', 'desktop', 'h6', 'line-height', 'em', 'heading_six' );
	//Tablet
	triphub_typography_live_update( 'line_height', 'tablet', 'h6', 'line-height', 'em', 'heading_six' );
	//Mobile
	triphub_typography_live_update( 'line_height', 'mobile', 'h6', 'line-height', 'em', 'heading_six' );


	/**********************************
		Typography Letter Spacing
	***********************************/

	/**
	 * Site Title Letter Spacing 
	*/
	//Desktop
	triphub_typography_live_update( 'letter_spacing', 'desktop', '.site-header .site-branding .site-title a', 'letter-spacing', 'px', 'site_title' );
	//Tablet
	triphub_typography_live_update( 'letter_spacing', 'tablet', '.mobile-header .site-branding .site-title a', 'letter-spacing', 'px', 'site_title' );
	//Mobile
	triphub_typography_live_update( 'letter_spacing', 'mobile', '.mobile-header .site-branding .site-title a', 'letter-spacing', 'px', 'site_title' );
	
	/**
	 * Primary Font Letter Spacing 
	*/
	//Desktop
	triphub_typography_live_update( 'letter_spacing', 'desktop', ':root', '--triphub-primary-font-spacing', 'px', 'primary_font' );
	//Tablet
	triphub_typography_live_update( 'letter_spacing', 'tablet', ':root', '--triphub-primary-font-spacing', 'px', 'primary_font' );
	//Mobile
	triphub_typography_live_update( 'letter_spacing', 'mobile', ':root', '--triphub-primary-font-spacing', 'px', 'primary_font' );
	
	/**
	 * Button Font Letter Spacing 
	*/
	//Desktop
	triphub_typography_live_update( 'letter_spacing', 'desktop', ':root', '--triphub-btn-font-spacing', 'px', 'button' );
	//Tablet
	triphub_typography_live_update( 'letter_spacing', 'tablet', ':root', '--triphub-btn-font-spacing', 'px', 'button' );
	//Mobile
	triphub_typography_live_update( 'letter_spacing', 'mobile', ':root', '--triphub-btn-font-spacing', 'px', 'button' );
	
	/**
	 * Heading One Letter Spacing 
	*/
	//Desktop
	triphub_typography_live_update( 'letter_spacing', 'desktop', 'h1', 'letter-spacing', 'px', 'heading_one' );
	//Tablet
	triphub_typography_live_update( 'letter_spacing', 'tablet', 'h1', 'letter-spacing', 'px', 'heading_one' );
	//Mobile
	triphub_typography_live_update( 'letter_spacing', 'mobile', 'h1', 'letter-spacing', 'px', 'heading_one' );
	
	/**
	 * Heading Two Letter Spacing 
	*/
	//Desktop
	triphub_typography_live_update( 'letter_spacing', 'desktop', 'h2', 'letter-spacing', 'px', 'heading_two' );
	//Tablet
	triphub_typography_live_update( 'letter_spacing', 'tablet', 'h2', 'letter-spacing', 'px', 'heading_two' );
	//Mobile
	triphub_typography_live_update( 'letter_spacing', 'mobile', 'h2', 'letter-spacing', 'px', 'heading_two' );
	
	/**
	 * Heading Three Letter Spacing 
	*/
	//Desktop
	triphub_typography_live_update( 'letter_spacing', 'desktop', 'h3', 'letter-spacing', 'px', 'heading_three' );
	//Tablet
	triphub_typography_live_update( 'letter_spacing', 'tablet', 'h3', 'letter-spacing', 'px', 'heading_three' );
	//Mobile
	triphub_typography_live_update( 'letter_spacing', 'mobile', 'h3', 'letter-spacing', 'px', 'heading_three' );
	/**
	 * Heading Four Letter Spacing 
	*/
	//Desktop
	triphub_typography_live_update( 'letter_spacing', 'desktop', 'h4', 'letter-spacing', 'px', 'heading_four' );
	//Tablet
	triphub_typography_live_update( 'letter_spacing', 'tablet', 'h4', 'letter-spacing', 'px', 'heading_four' );
	//Mobile
	triphub_typography_live_update( 'letter_spacing', 'mobile', 'h4', 'letter-spacing', 'px', 'heading_four' );
	
	/**
	 * Heading Five Letter Spacing 
	*/
	//Desktop
	triphub_typography_live_update( 'letter_spacing', 'desktop', 'h5', 'letter-spacing', 'px', 'heading_five' );
	//Tablet
	triphub_typography_live_update( 'letter_spacing', 'tablet', 'h5', 'letter-spacing', 'px', 'heading_five' );
	//Mobile
	triphub_typography_live_update( 'letter_spacing', 'mobile', 'h5', 'letter-spacing', 'px', 'heading_five' );
	
	/**
	 * Heading Six Letter Spacing 
	*/
	//Desktop
	triphub_typography_live_update( 'letter_spacing', 'desktop', 'h6', 'letter-spacing', 'px', 'heading_six' );
	//Tablet
	triphub_typography_live_update( 'letter_spacing', 'tablet', 'h6', 'letter-spacing', 'px', 'heading_six' );
	//Mobile
	triphub_typography_live_update( 'letter_spacing', 'mobile', 'h6', 'letter-spacing', 'px', 'heading_six' );


	/*********** 
	Theme Colors
	************/	
	triphub_colors_live_update( 'primary_color', ':root', '--triphub-primary-color', '--triphub-primary-color-rgb' );
	triphub_colors_live_update( 'secondary_color', ':root', '--triphub-secondary-color', '--triphub-secondary-color-rgb' );
	triphub_colors_live_update( 'body_font_color', ':root', '--triphub-body-font-color', '--triphub-body-font-color-rgb' );
	triphub_colors_live_update( 'heading_color', ':root', '--triphub-heading-color', '--triphub-heading-color-rgb' );
	triphub_colors_live_update( 'section_bg_color', ':root', '--triphub-section-bg-color', '--triphub-section-bg-color-rgb' );
	triphub_colors_live_update( 'site_bg_color', ':root', '--triphub-background-color', '--triphub-background-color-rgb' );
	triphub_colors_live_update( 'site_title_color', '.site-branding .site-title a', 'color', undefined );
	triphub_colors_live_update( 'site_tagline_color', '.site-branding .site-description', 'color', undefined );

	/*******************************
		Additional Color Settings
	********************************/
	/**
	 * Notification Bar Background Color
	 */
	triphub_colors_live_update( 'notification_bg_color', '.notification-bar', '--triphub-bg-color', undefined );
	/**
	 * Notification Bar Text Color
	 */
	triphub_colors_live_update( 'notification_text_color', '.notification-bar', '--triphub-text-color', undefined);
	/**
	 * Global Button Colors
	 */
	triphub_colors_live_update( 'btn_text_color_initial', ':root', '--triphub-btn-text-initial-color', undefined );
	triphub_colors_live_update( 'btn_text_color_hover', ':root', '--triphub-btn-text-hover-color', undefined );
	triphub_colors_live_update( 'btn_bg_color_initial', ':root', '--triphub-btn-bg-initial-color', undefined );
	triphub_colors_live_update( 'btn_bg_color_hover', ':root', '--triphub-btn-bg-hover-color', undefined );
	triphub_colors_live_update( 'btn_border_color_initial', ':root', '--triphub-btn-border-initial-color', undefined );
	triphub_colors_live_update( 'btn_border_color_hover', ':root', '--triphub-btn-border-hover-color', undefined );

	/**
	 * Header Button Color
	 */
	triphub_colors_live_update( 'header_btn_text_color', '.site-header', '--triphub-btn-text-initial-color', undefined );
	triphub_colors_live_update( 'header_btn_text_hover_color', '.site-header', '--triphub-btn-text-hover-color', undefined );
	triphub_colors_live_update( 'header_btn_bg_color', '.site-header', '--triphub-btn-bg-initial-color', undefined );
	triphub_colors_live_update( 'header_btn_bg_hover_color', '.site-header', '--triphub-btn-bg-hover-color', undefined );

	/**
	 * Header Button Color
	 */
	triphub_colors_live_update( 'top_header_bg_color', '.header-layout-1 .header-m', '--triphub-top-header-bg-color', undefined );
	triphub_colors_live_update( 'top_header_text_color', '.header-layout-1 .header-m', '--triphub-top-header-text-color', undefined );

	/** 
	 * Footer Color
	 */ 
	triphub_colors_live_update( 'upper_footer_text_color', '.site-footer', '--triphub-uf-text-color', undefined );
	triphub_colors_live_update( 'upper_footer_bg_color', '.site-footer', '--triphub-uf-bg-color', undefined );
	triphub_colors_live_update( 'upper_footer_link_hover_color', '.site-footer', '--triphub-uf-link-hover-color', undefined );
	triphub_colors_live_update( 'upper_footer_widget_heading_color', '.site-footer', '--triphub-uf-widget-heading-color', undefined );
	triphub_colors_live_update( 'bottom_footer_text_color', '.site-footer', '--triphub-bf-text-color', undefined );
	triphub_colors_live_update( 'bottom_footer_bg_color', '.site-footer', '--triphub-bf-bg-color', undefined );
	triphub_colors_live_update( 'bottom_footer_link_initial_color', '.site-footer', '--triphub-bf-link-initial-color', undefined );
	triphub_colors_live_update( 'bottom_footer_link_hover_color', '.site-footer', '--triphub-bf-link-hover-color', undefined );


	/************************ 
	Navigation Menu Settings
	 ************************/
	//Desktop - Menu items spacing
	triphub_slider_live_update('header_items_spacing', 'desktop', '.primary-menu-wrapper', '--triphub-menu-items-spacing', 'px');
	//Desktop - Header dropdown width
	triphub_slider_live_update('header_dropdown_width', 'desktop', '.primary-menu-wrapper', '--triphub-menu-dropdown-width', 'px');
	
	//Desktop - Stretch menu
	wp.customize( 'header_strech_menu',function( value ){
		value.bind( function( newval ){
			var siteMenu = jQuery("nav.primary-navigation");		
			if(newval === true){
				siteMenu.attr('data-stretch', 'yes')
			} else {
				siteMenu.attr('data-stretch', 'no')
			}	
		});
	} );

	//Header Width Layout
	wp.customize( 'header_width_layout',function( value ){
		value.bind( function( newval ){
			var containerObj = {
				"boxed" : {
					"remove"  : "container-full",
					"add" : "container"
				},
				"fullwidth" : {
					"remove"  : "container",
					"add" : "container-full"
				}
			}
			$.each(containerObj, function(key, props) {
				if (newval === key){
					var container = jQuery("#masthead ." + props.remove)
					$.each(container, function(index, value) {
						$(value).removeClass(props.remove)
						$(value).addClass(props.add)
					})
				}
			});
		} );
	} );

	/****************** 
	Container Width
	*******************/
	//Desktop
	triphub_slider_live_update('container_width', 'desktop', ':root', '--triphub-container-width', 'px');
	//Tablet
	triphub_slider_live_update('tablet_container_width', 'tablet', ':root', '--triphub-container-width', 'px');
	//mobile
	triphub_slider_live_update('mobile_container_width', 'mobile', ':root', '--triphub-container-width', 'px');


	/************************
	Fullwidth Centered Width
	*************************/
	//Desktop
	triphub_slider_live_update('fullwidth_centered', 'desktop', ':root', '--triphub-centered-maxwidth', 'px')
	//Tablet
	triphub_slider_live_update('tablet_fullwidth_centered', 'tablet', ':root', '--triphub-centered-maxwidth', 'px')
	//Mobile
	triphub_slider_live_update('mobile_fullwidth_centered', 'mobile', ':root', '--triphub-centered-maxwidth', 'px')


	/**************
	Logo Width
	***************/
	//Desktop
	triphub_slider_live_update( 'logo_width', 'desktop', '.site-header .custom-logo', 'width', 'px' );
	//Tablet
	triphub_slider_live_update( 'tablet_logo_width', 'tablet', '.site-branding .custom-logo-link img', 'width', 'px' );
	//Mobile
	triphub_slider_live_update( 'mobile_logo_width', 'mobile', '.site-branding .custom-logo-link img', 'width','px' );


	/**********************************
		Scroll to top icon size
	***********************************/
	//Desktop
	triphub_slider_live_update('scroll_top_size', 'desktop', '.to_top', '--triphub-scroll-to-top-size', 'px');
	//Tablet
	triphub_slider_live_update('tablet_scroll_top_size', 'tablet', '.to_top', '--triphub-scroll-to-top-size', 'px');
	//Mobile
	triphub_slider_live_update('mobile_scroll_top_size', 'mobile', '.to_top', '--triphub-scroll-to-top-size', 'px');


	/**********************************
		Sidebar Width
	***********************************/
	//Desktop
	triphub_slider_live_update('sidebar_width', 'desktop', '.main-content-wrapper', '--triphub-sidebar-width', '%');
	//Tablet
	triphub_slider_live_update('tablet_sidebar_width', 'tablet', '.main-content-wrapper', '--triphub-sidebar-width', '%');


	/**********************************
		Sidebar Widget Spacing
	***********************************/
	//Desktop
	triphub_slider_live_update('widgets_spacing', 'desktop', 'aside.widget-area', '--triphub-widget-spacing', 'px');
	//Tablet
	triphub_slider_live_update('tablet_widgets_spacing', 'tablet', 'aside.widget-area', '--triphub-widget-spacing', 'px');
	//Mobile
	triphub_slider_live_update('mobile_widgets_spacing', 'mobile', 'aside.widget-area', '--triphub-widget-spacing', 'px');


	/**********************************
		Breadcrumb separator icon
	***********************************/
	wp.customize( 'separator_icon',function( value ){
		value.bind( function( newval ){
			var icon = newval === 'three' ? triphub_view_port.breadcrumb_sep_three
				: newval === 'two' ? triphub_view_port.breadcrumb_sep_two
				: triphub_view_port.breadcrumb_sep_one;		
			var separator = jQuery(".travel-monster-breadcrumb-main-wrap span.separator")
			$.each(separator, function(index, value) {
				$(value).html(icon)		
			})
		} );
	} );

	/**************************** 
		Global Button Settings
	*****************************/
	//Button Roundness
	triphub_spacing_live_update('btn_roundness', '', ':root', '--triphub-btn-roundness', 'px' );
	//Button Padding
	triphub_spacing_live_update('button_padding', '', ':root', '--triphub-btn-padding', 'px' );


	/**************************** 
		Alignment Settings
	*****************************/
	//Page Title Alignment
	wp.customize( 'page_alignment',function( value ){
		value.bind( function( newval ){		
			var pageTitle = jQuery("#primary article")
			pageTitle.attr('data-alignment', `title-${newval}`)
		} );
	} );

	//Blog Page Title Alignment
	wp.customize( 'blog_alignment',function( value ){
		value.bind( function( newval ){
			var pageTitle = jQuery(".page-header-top .page-header-wrap")
			pageTitle.attr('data-alignment', `title-${newval}`)
		} );
	} );

	//Archive Title Alignment
	wp.customize( 'archive_alignment',function( value ){
		value.bind( function( newval ){		
			var pageTitle = jQuery(".page-header-top .page-header-wrap")
			pageTitle.attr('data-alignment', `title-${newval}`)
		} );
	} );

}(jQuery));
