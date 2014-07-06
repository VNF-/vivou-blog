/**
 *	Calcium WordPress Theme
 *
 *	Developed by Laborator.co - www.laborator.co
 */

var pub = pub || {};

;(function($, window, undefined)
{
	"use strict";
	
	$(document).ready(function()
	{
		// Main Content Container
		pub.$content = $('.st-content');
		
		// Autogrow
		$(".autosize, .autogrow").autoGrow();
		
		// Contact Form
		var $cf = $(".contact-form");
		
		if($cf.length && $cf.find('form').length)
		{
			var $cf_form = $cf.find('form');
			
			$cf_form.submit(function(ev)
			{
				ev.preventDefault();
				
				var fields = $cf_form.serializeArray(),
					$required = $cf_form.find('[data-required="1"]');
				
				
				// Check for required fields
				if($required.length)
				{
					var required = $required.serializeArray(),
						required_arr = [];
					
					for(var i in required)
					{
						required_arr.push(required[i].name);
					}
				}
				
				// Check For errors
				for(var i in fields.reverse())
				{
					var field = fields[i],
						$field = $cf_form.find('[name="'+field.name+'"]');
					
					// Required Field
					if($.inArray(field.name, required_arr) != -1)
					{
						
						if($.trim($field.val()) == '')
						{
							$field.addClass('has-errors').focus();
						}
						else
						{
							$field.removeClass('has-errors');
						}
					}
					
					// Email Field
					if(field.name == 'email' && $field.val().length)
					{
						if( ! validateEmail($field.val()))
						{
							$field.addClass('has-errors').focus();
						}
						else
						{
							$field.removeClass('has-errors');
						}
					}
				}
				
				
				// Send form data
				if( ! $cf_form.find('.has-errors').length && ! $cf.hasClass('is-loading') && ! $cf.data('is-done'))
				{	
					
					fields.push({name: 'action', value: 'cf_process'});
					fields.push({name: 'verify', value: $cf_form.data('check')});
					
					$cf.addClass('is-loading');
					
					$.post(ajaxurl, fields, function(resp)
					{
						if(resp.success)
						{
							var $msg = $cf.find('.success-message');
							$msg.show();
							
							var msg_height = $msg.outerHeight();
							
							TweenMax.set($msg, {css: {scale: 0.8, autoAlpha: 0, height: 0}});
							
							TweenMax.to($msg, .7, {css: {height: msg_height, scale: 1, autoAlpha: 1}});
							
							$cf.removeClass('is-loading');
							$cf.data('is-done', 1);
							
							$cf.find('[name]').fadeTo(200, .6).attr('readonly', true);
						}
						else
						{
							alert("An error occured your message cannot be send!");
						}
						
					}, 'json');
				}
			});
		}
		
		
		// Clients Carousel
		if($.isFunction( $.fn.thumbnailsCarousel ))
		{
			$(".clients-carousel").thumbnailsCarousel({
				show: 4,
				autoSwitch: 5,
				index: 0
			});
		}
		
		
		// Video Popup
		if($.isFunction($.fn.magnificPopup))
		{
			$("body").on('click', '.play-video', function(ev)
			{
				ev.preventDefault();
				return false;
				
				$.magnificPopup.open({
					items: {
						src: $(this).data('video-url'),
					},
					mainClass: 'mfp-fade',
					type: 'iframe',
					disableOn: 700,
					removalDelay: 160,
					preloader: false,
					
					fixedContentPos: false
		        });
			});
			
			$("body").on('click', '.open-image', function(ev)
			{
				ev.preventDefault();
				
				$.magnificPopup.open({
					items: {
						src: $(this).attr('href'),
					},
					mainClass: 'my-mfp-slide-bottom',
					type: 'image',
					disableOn: 700,
					removalDelay: 160,
					preloader: false,
					
					fixedContentPos: false
		        });
			});
			
			$(".open-image-info").magnificPopup({
				type: 'image'
			});
			
			
			$('.gallery-images').each(function(i, el)
			{
				$(el).magnificPopup({
					delegate: 'a:has(img)',
					type: 'image',
					tLoading: 'Loading image #%curr%...',
					mainClass: 'mfp-no-margins mfp-with-zoom',
					disableOn: 700,
					gallery: {
						enabled: true,
						navigateByImgClick: true,
						preload: [0,1]
					},
					image: {
						tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
						
						titleSrc: function(item) {
							return item.el.attr('title');
						},
						verticalFit: true
					}
				});
			});
				
			$(".portfolio-gallery").each(function(i, el)
			{
				var $this = $(el),
					$img = $this.find('a.img'),
					items = [];
				
				$img.each(function(i, el)
				{
					var href = $(el).attr('href'),
						type = 'image';
					
					if(href.match(/(vimeo\.com|youtube\.com)/i))
					{
						type = 'iframe';
					}
					
					items.push({
						src: href,
						title: el.getAttribute('title'),
						type: type
					});
				});
				
				$img.each(function(i, el)
				{
					$(el).magnificPopup({
								
						items: items,
						
						fixedContentPos: false,
						fixedBgPos: true,
						
						overflowY: 'auto',
						
						closeBtnInside: true,
						preloader: false,
						
						gallery: {
							enabled: true
						},
						
						index: i,
						
						midClick: true,
						removalDelay: 300,
						mainClass: 'my-mfp-slide-bottom',
						
						type: 'image'
					});
				});
			});
        }
		
		
		// Comment Reply
		$("#comments .reply-go-form").on('click', function(ev)
		{
			ev.preventDefault();
			
			var $commentform = $("#commentform");
			
			$(".st-content").animate({
				scrollTop: $commentform.offset().top + 100
			}, function()
			{
				$commentform.find('input, textarea').first().focus();
			});
		});
		
		
		
		// Menu
		var $main_nav = $("header nav .main-nav > li:has(ul)"),
			nav_scale = 0.7,
			hover_delay = .3,
			sub_hover_delay = 0.2;
		
		$main_nav.each(function(i, el)
		{
			var $this       = $(el),
				$sub        = $this.find('> ul'),
				$span       = $this.find('> a > span'),
				$arrow      = $sub.find('> .arrow-up'),
				parent_tm   = 0;
			
			
			// Count Heights
			$sub.addClass('visible');
			
			var $subs = $sub.find('ul');
			
			$($subs.get().reverse()).each(function(i, el)
			{
				var $s = $(el),
					height = $s.outerHeight();
				
				$s.data('height', height).css({
					height: 0
				});
			});
			
			$sub.removeClass('visible');
			
			// Level 2 or higher events
			$subs.each(function(i, el)
			{
				var	$s = $(el),
				 	$p = $s.parent(),
				 	height = $s.data('height'),
				 	sub_tm = 0;
				
				$p.hoverIntent({
					over: function()
					{
						TweenMax.to($s, sub_hover_delay, {css: {height: height}, ease: Sine.easeInOut, onComplete: function()
						{
							$s.removeClass('hidden-text');
							$s.css('height', 'auto');
						}});
					},
					
					out: function()
					{
						window.clearTimeout(sub_tm);
						
						$s.addClass('hidden-text');
						
						sub_tm = setTimeout(function()
						{
							TweenMax.to($s, sub_hover_delay, {css: {height: 0}, ease: Sine.easeInOut});
						}, 300);
					},
					
					timeout: 160
				});
			});
			
			
			// Root subs hover events
			TweenMax.set($sub, {css: {scale: nav_scale, autoAlpha: 0.7}});
			
			$this.hoverIntent({
				over: function()
				{
					window.clearTimeout(parent_tm);
					
					$sub.addClass('visible');
					
					$arrow.css({left: $span.width()/2 - 15});
					
					TweenMax.to($sub, hover_delay, {css: {scale: 1, autoAlpha: 1}, ease: Back.easeOut});
					parent_tm = setTimeout(function(){ $sub.removeClass('hidden-text'); }, 150 * hover_delay);
				},
				
				out: function()
				{
					window.clearTimeout(parent_tm);
					
					TweenMax.to($sub, hover_delay, {css: {autoAlpha: 0, scale: .9}, ease: Back.easeIn, onComplete: function()
					{
						TweenMax.set($sub, {css: {scale: nav_scale}});
						$sub.removeClass('visible');
					}});
				},
				
				timeout: 300
			});
		});
		
		
		// Search Sidebar
		var $searchform_input = $(".st-menu .searchform #s");
		
		if($searchform_input.length)
		{
			$searchform_input.on('focus', function()
			{
				$searchform_input.addClass('focused');
			});
			
			$searchform_input.on('blur', function()
			{
				if($searchform_input.val().length == 0)
					$searchform_input.removeClass('focused');
			});
			
			if($searchform_input.val().length != 0)
				$searchform_input.addClass('focused');
		}	
		
		
		// Tweets
		$(".st-menu .tweets").each(function(i, el)
		{
			var $this = $(el),
				$tweets = $this.find('li'),
				$tweets_nav = $('<div class="tweets-nav"></div>'),
				tweets = $tweets.length,
				per_page = $this.data('num');
			
			if(per_page != -1 && per_page < tweets)
			{
				for(var i=1; i<=Math.ceil(tweets/per_page); i++)
				{
					$tweets_nav.append( '<a href="#" data-index="' + ((i-1) * per_page) + '"' + (i == 1 ? ' class="active"' : '') + '>' + i + '</a>' );
				}
				
				$this.after( $tweets_nav );
				
				$tweets.hide();
				$tweets.slice(0, per_page).show();
				
				$tweets_nav.on('click', 'a', function(e)
				{
					e.preventDefault();
					
					var $a = $(this),
						index = $a.data('index'),
						offset = index + per_page;
					
					$tweets_nav.find('a').removeClass('active');
					$a.addClass('active');
					
					$tweets.filter(':visible').fadeOut(300, function()
					{
						$tweets.slice(index, offset).fadeIn(300);
					})
				});
			}
			
		});
			
		
		
		// Instagram
		$(".st-menu .instagram-gallery").each(function(i, el)
		{
			var $this = $(el),
				$images = $this.find('a'),
				$images_nav = $('<div class="instagram-nav"></div>'),
				images = $images.length,
				per_page = $this.data('num');
			
			if(per_page != -1 && per_page < images)
			{
				for(var i=1; i<=Math.ceil(images/per_page); i++)
				{
					$images_nav.append( '<a href="#" data-index="' + ((i-1) * per_page) + '"' + (i == 1 ? ' class="active"' : '') + '>' + i + '</a>' );
				}
				
				$this.after( $images_nav );
				
				$images.hide();
				$images.slice(0, per_page).show();
				
				$images_nav.on('click', 'a', function(e)
				{
					e.preventDefault();
					
					var $a = $(this),
						index = $a.data('index'),
						offset = index + per_page;
					
					$images_nav.find('a').removeClass('active');
					$a.addClass('active');
					
					$images.filter(':visible').fadeOut(300, function()
					{
						$images.slice(index, offset).fadeIn(300);
					})
				});
			}
			
		});
		
		
		// Portfolio Like
		$("section.portfolio").on('click', '.like', function(ev)
		{
			ev.preventDefault();
			
			var $this	= $(this),
				$span   = $this.find('span'),
				id      = $this.data('id'),
				nonce   = $this.data('verify'),
				like    = $this.hasClass('liked') ? 'unlike' : 'like';
			
			if($this.data('is-busy'))
			{
				return false;
			}
			
			$this.data('is-busy', true);
			TweenMax.to($this, .2, {css: {autoAlpha: .4}});	
			
			laborator_like_item(id, nonce, like, function(resp)
			{
				var tm = new TimelineMax();
				
				$this.data('is-busy', false);
				
				if(resp.errcode)
				{
					return false;
				}
				
				if(resp.status == 1)
				{	
					$this.removeClass('just-unliked');
					
					tm.append( TweenMax.to($this, .2, {css: {scale: 1.2, autoAlpha: .7}, onComplete: function()
					{
						$this.addClass('liked');
						$this[resp.likes > 0 ? 'addClass' : 'removeClass']('has-likes');
					}}) );
				}
				else
				{
					tm.append( TweenMax.to($this, .2, {css: {scale: 0.8, autoAlpha: .7}, onComplete: function()
					{
						$this.addClass('just-unliked');
						$this.removeClass('liked');
					}}) );
					
					$this[resp.likes > 0 ? 'addClass' : 'removeClass']('has-likes');
				}
				
				tm.append( TweenMax.to($this, .25, {css: {scale: 1, autoAlpha: 1}}) );
				$span.text( resp.likes );
			});
		});
		
		
		// Portfolio Isotope
		pub.$portfolio = $("section.portfolio");
		
		if(pub.$portfolio.length && $.isFunction($.fn.isotope))
		{
			var $portfolio_container = pub.$portfolio.find('> ul');

			//$portfolio_container.find('> li').addClass('hidden');
			pub.$portfolio.addClass('is-loading');
			
			$portfolio_container.preloadImages(function()
			{
				pub.$portfolio.removeClass('is-loading');
				$portfolio_container.find('> li').removeClass('hidden');
				
				// With Isotope
				if(pub.$portfolio.hasClass('with-isotope'))
				{
					$portfolio_container.isotope({
						layoutMode: 'fitRows',
						itemSelectorSelector: '> li'
					});
					
					$portfolio_container.isotope('reLayout');
				}
				
				socialNetworksInit();
				
			
				// Open portfolio item from URLHash
				var hash = window.location.hash.toString(),
					hash_matches;
					
				if(hash_matches = hash.match(/^#portfolio-([0-9]+)(-([0-9]+))?$/))
				{
					var item_id = hash_matches[1],
						item_paged = typeof hash_matches[3] != 'undefined' ? hash_matches[3] : 1,
						$item = pub.$portfolio.find('.post-' + item_id);
						
					// Exists in the current page
					if(item_paged == 1)
					{
						if($item.length)
						{
							openPortfolioItem(item_id);
							
							pub.$content.animate({
								scrollTop: $item.offset().top
							});
						}
					}
					else
					{
						loadMoreItems(pub.$portfolio.find('.load-more'), item_paged, function()
						{
							var $item = pub.$portfolio.find('.post-' + item_id);
							
							if($item.length)
							{
								openPortfolioItem(item_id);
							
								pub.$content.animate({
									scrollTop: $item.offset().top
								});
							}
						});
					}
				}
				if(hash_matches = hash.match(/^#item:(.*?)(:page:([0-9]+))??$/))
				{
					var item_name = hash_matches[1],
						item_paged = typeof hash_matches[3] != 'undefined' ? hash_matches[3] : 1,
						$item = pub.$portfolio.find('.portfolio-item[data-name="' + item_name + '"]'),
						item_id = $item.data('id');
						
					// Exists in the current page
					if(item_paged == 1)
					{
						if($item.length)
						{
							openPortfolioItem(item_id);
							
							pub.$content.animate({
								scrollTop: $item.offset().top
							});
						}
					}
					else
					{
						loadMoreItems(pub.$portfolio.find('.load-more'), item_paged, function()
						{
							var $item = pub.$portfolio.find('.portfolio-item[data-name="' + item_name + '"]'),
								item_id = $item.data('id');
							
							if($item.length)
							{
								openPortfolioItem(item_id);
							
								pub.$content.animate({
									scrollTop: $item.offset().top
								});
							}
						});
					}
					
				}
				else
				if(hash_matches = hash.match(/^#portfolio-category:(.*)$/))
				{
					var cat = "cat-" + hash_matches[1],
						$category_filtering = $('.fso-overlay nav li a, .portfolio-filter-upper a'),
						$cat = $category_filtering.filter('[data-filter="' + cat + '"]');
					
					if($cat.length)
					{
						$category_filtering.removeClass('current');
						$cat.addClass('current');
						
						$portfolio_container.preloadImages(function()
						{
							$portfolio_container.isotope({filter: '.' + cat}, calculatePortfolioRows);
						});
					}
				}
				
			});
			
			
			// Category Filtering
			var $category_filtering = $('.fso-overlay nav li a, .portfolio-filter-upper a');
			
			$category_filtering.each(function(i, el)
			{
				var $this = $(el),
					category = $this.data('filter');
				
				$this.click(function(ev)
				{
					ev.preventDefault();
					
					$category_filtering.removeClass('current');
					$this.addClass('current');
					
					if($this.data('no-fso'))
					{
						if(jQuery.isFunction(closeAllPortfolioItems))
							closeAllPortfolioItems();
					}
					else
					{
						window.fsoToggleOverlay();
					}
					
					if(category == '*')
						$portfolio_container.isotope({filter: '.columns'}, calculatePortfolioRows);
					else
						$portfolio_container.isotope({filter: '.' + category}, calculatePortfolioRows);
					
					
					// URL Hash
					var st = $(window).scrollTop();
					window.location.hash = category == '*' ? '' : ('portfolio-category:' + category.replace(/^cat-/, ''));
					$(window).scrollTop(st);
				});
			});
			
			
			
			$(window).on('keyup', function(ev)
			{
				if(ev.keyCode == 27 && typeof window.fsoToggleOverlay != 'undefined' && $(".fso-overlay.overlay-hugeinc.open").length)
				{
					window.fsoToggleOverlay();
				}
			});
			
			
			// Category Filtering via Item Details Categories
			$("body").on('click', '.item-categories a', function(ev)
			{
				ev.preventDefault();
				
				var $this = $(this),
					slug = $this.attr('href').match(/([^\/]+)\/?$/i);
				
				if(slug)
				{
					var category = 'cat-' + slug[1];
					
					$category_filtering.removeClass('current').filter('[data-filter="' + category + '"]').addClass('current');
					$portfolio_container.isotope({filter: '.' + category}, calculatePortfolioRows);
					
					
					if(jQuery.isFunction(closeAllPortfolioItems))
							closeAllPortfolioItems();
							
					// URL Hash
					var st = $(window).scrollTop();
					window.location.hash = category == '*' ? '' : ('portfolio-category:' + category.replace(/^cat-/, ''));
					$(window).scrollTop(st);
				}
			});
		}
		
		
		// Portfolio Settings
		if(pub.$portfolio.length)
		{
			var $portfolio_container = pub.$portfolio.find('> ul');
				
			// Open
			pub.$portfolio.on('click', '.show-details', function(ev)
			{
				ev.preventDefault();
				
				var $this = $(this),
					id = $this.closest('.portfolio-item').data('id');
				
				openPortfolioItem(id);
			});
			
			
			// Close
			$portfolio_container.on('click', '.close', function(ev)
			{
				ev.preventDefault();
				
				var $this = $(this);
				
				closePortfolioItem($this.closest('.project-open').prev().find('.portfolio-item').data('id'), true);
			});
			
			
			// Load More
			var $more = pub.$portfolio.find('.load-more');
			
			if($more.length)
			{
				$more.data('load-text', $more.html());
				
				$more.on('click', function(ev)
				{
					ev.preventDefault();
					
					loadMoreItems($more);
				});
			}
		}
		
		
		// Contact Widget
		var $contact_widget = $(".widget-contact");
		
		if($contact_widget.length)
		{
			var $cw_name 	= $contact_widget.find('input[name="name"]'),
				$cw_email   = $contact_widget.find('input[name="email"]'),
				$cw_message = $contact_widget.find('textarea[name="message"]');
				
			$contact_widget.submit(function(ev)
			{
				ev.preventDefault();
				
				if($contact_widget.data('done'))
					return false;
				
				var has_errors = 0;
				
				if( ! $cw_name.val().length)
				{
					$cw_name.addClass('has-errors').focus();
					has_errors++;
				}
				else
				{
					$cw_name.removeClass('has-errors');
				}
				
				if(validateEmail($cw_email.val()) == false)
				{
					$cw_email.addClass('has-errors');
					
					if(has_errors == 0)
						$cw_email.focus();
						
					has_errors++;
				}
				else
				{
					$cw_email.removeClass('has-errors');
				}
				
				if( ! $cw_message.val().length)
				{
					$cw_message.addClass('has-errors');
					
					if(has_errors == 0)
						$cw_message.focus();
						
					has_errors++;
				}
				else
				{
					$cw_message.removeClass('has-errors');
				}
				
				
				if( ! has_errors)
				{
					$contact_widget.addClass('is-loading').data('done', true).find('input, textarea').attr('readonly', true);
					
					var contact_data = {
						action: 'send_via_contact_widget',
						verify: $contact_widget.data('check'),
						name: $cw_name.val(),
						email: $cw_email.val(),
						message: $cw_message.val()
					};
					
					$.post(ajaxurl, contact_data, function(resp)
					{
						if(resp.success)
						{
							var $msg = $contact_widget.find('.success-message');
							$msg.show();
							
							var msg_height = $msg.outerHeight();
							
							TweenMax.set($msg, {css: {scale: 0.8, autoAlpha: 0, height: 0}});
							TweenMax.to($msg, .7, {css: {height: msg_height, scale: 1, autoAlpha: 1}});
							
							$contact_widget.removeClass('is-loading');
						}
					}, 'json');
				}
			});
			
			$cw_name.on('keydown', function()
			{	
				if($cw_name.val().length > 2)
				{
					if($cw_email.is(':visible') == false)
						$cw_email.show('fast');
				}
				else
				{
					if($cw_email.is(':visible') == true)
						$cw_email.hide('fast');
				}
			});
		}
	
	
		// Tabs
		$("dl.tabs").each(function(i, el)
		{
			var $tabs = $(el),
				$items = $tabs.find('dd'),
				$tabs_content = $tabs.next('.tabs-content'),
				$tabs_items = $tabs_content.find('.content');
				
			$items.on('click', function(ev)
			{
				ev.preventDefault();
				
				var $this = $(this);
				
				$items.removeClass('active');
				$this.addClass('active');
				
				$tabs_items.hide();
				$tabs_items.filter( $this.find('a').attr('href') ).fadeIn('fast');
			});
		});
		
		
		// Accordion
		$("dl.accordion").each(function(i, el)
		{
			var $accordion = $(el),
				$items = $accordion.find('> dd');
			
			$items.each(function(i, el)
			{
				var $item = $(el),
					$link = $item.find('> a'),
					$content = $item.find('> .content');
				
				
				$link.on('click', function(ev)
				{
					ev.preventDefault();
					
					$items.find('> .content').not($content).slideUp('fast');
					$content.slideDown('normal');
				});
			});
		});
		
		
		// Mobile Menu
		var $mmc_collapse = $(".mobile-menu-container .sidebar-menu button");
		
		$mmc_collapse.on('click', function(ev)
		{
			ev.preventDefault();
			
			setTimeout(function()
			{
				$("#container").removeClass('st-menu-open');
			}, 200);
		});
		
		// Language switcher in footer (WPML)
		var $lang_sel_footer = $("#lang_sel_footer");
		
		if($lang_sel_footer.length)
		{
			$("#container .st-content").append( $lang_sel_footer );
		}
		
		
		
	});
	
})(jQuery, window);


function validateEmail(email)
{
	var emailPattern = /^[a-zA-Z0-9._]+[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/;  
	return emailPattern.test(email); 
}


function laborator_like_item(id, nonce, type, callback)
{
	if(typeof window.ajaxurl == 'string')
	{
		var like_data = {
			action: 'laborator_likes',
			like_verify_key: nonce,
			post_id: id,
			type: type
		};
		
		jQuery.getJSON(window.ajaxurl, like_data, function(resp)
		{
			if(typeof callback == 'function')
			{
				callback(resp);
			}
		});
	}
	else
	{
		alert("Ajax URL is not defined!")
	}
}

function loadMoreItems($more, force_paged, callback)
{
	var paged  	  = $more.data('paged'),
		loading   = $more.data('loading'),
		rows      = $more.data('rows'),
		cols      = $more.data('cols'),
		query     = $more.data('query'),
		req_data  = {
			action: 'portfolio_get_items',
			rows: rows,
			cols: cols,
			paged: paged,
			query: query
		};
		
	$more.html( loading );
	
	if(force_paged)
	{
		paged = force_paged;
		req_data.paged = paged;
		
		$more.data('skip', paged);
	}
	else
	if($more.data('skip') == req_data.paged)
	{
		req_data.paged = req_data.paged+1;
		paged = req_data.paged;
	}
	
	jQuery.post(ajaxurl, req_data, function(resp)
	{
		if( ! resp.success)
		{
			alert("An error occoured while processing JSON");
			return;
		}
			
		if(resp.have_items)
		{
			var $new_items = jQuery(resp.items),
				$items_env = pub.$portfolio.find('> ul'),
				fn_rep = function()
				{
					window.clearTimeout(pub.pncTimeout);
					
					if(pub.$content.scrollTop() >= pub.portfolioNextCheck)
					{
						loadMoreItems($more);
						
						pub.portfolioNextCheck = -1;
						return;
					}
					
					pub.pncTimeout = setTimeout(fn_rep, 100);
				};
			
			if($items_env.filter('.isotope').length)
			{
				// IsoTope Is Applied
				$new_items.preloadImages(function()
				{
					$new_items.data('paged-id', paged);
					$new_items.append($new_items).removeClass('hidden');
					
					$items_env.isotope('insert', $new_items, function(){ 
						
						setTimeout(function(){ 
							$items_env.isotope('reLayout', socialNetworksInit);
								
						}, 300);
							
						if(typeof callback == 'function')
							callback();
						
						if(resp.have_more && ! force_paged)
						{
							pub.portfolioNextCheck = $more.offset().top - jQuery(window).height() * 0.85;
							
							if(pub.pncTimeout)
								window.clearTimeout(pub.pncTimeout);
							
							pub.pncTimeout = setTimeout(fn_rep, 100);
						}
					});
				});
			}
			else
			{
				// No Isotope
				$items_env.append( $new_items );
				
				if(resp.have_more)
				{
					setTimeout(function()
					{
						pub.portfolioNextCheck = $more.offset().top - jQuery(window).height() * 0.85;
									
						if(pub.pncTimeout)
							window.clearTimeout(pub.pncTimeout);
						
						pub.pncTimeout = setTimeout(fn_rep, 100);
						
					}, 500);
				}
			}
							
			// Update Pagination
			if( ! force_paged)
				$more.data('paged', paged+1);
				
			$more.html( $more.data('load-text') );
			
			
			if( ! resp.have_more)
			{
				$more.slideUp();
			}
		}
		else
		{
			$more.slideUp();
		}
	}, 'json');
}


function socialNetworksInit()
{
	var init = false;
	
	if(typeof twttr != 'undefined')
		twttr.widgets.load();
	
	if(typeof FB != 'undefined')
		FB.XFBML.parse();
		
	if(typeof gapi != 'undefined')
		gapi.plusone.go();
	
	if(init)
		return true;

	(function(d,s,id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=588886751123509"; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk'));
	!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
	(function() { var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true; po.src = 'https://apis.google.com/js/platform.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s); })();
	
	init = true;
}