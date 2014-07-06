/**
 *	Thumbnails Carousel
 *
 *	Plugin by: Arlind Nushi
 *	www.arlindnushi.com
 *
 *	Version: 1.0
 *	Date: 2/18/14
 */

;(function($, window, undefined){
	
	$.fn.thumbnailsCarousel = function(opts)
	{
		return this.each(function(i)
		{
			var 
			// public properties
			def = {
				show: 1,
				selector: '> *',
				hiddenClass: 'hidden',
				transitionDuration: .3,
				transitionDelay: .1,
				autoSwitch: 0,
				index: 0,
			},
			// private properties
			p = {
				index: 0,
				as: {pct: 0},
				asInstance: null
			},
			methods = {
				init: function(opts)
				{
					// Extend Options
					$.extend(def, opts);
					
					// Set Container
					p.container = $(this);
					p.items = p.container.find(def.selector);
					
					p.index = methods.getIndex(def.index);
					
					// Calculate Height
					p.items.each(function(i, el)
					{
						var $this = $(el);
						
						if($this.hasClass(def.hiddenClass))
						{
							$this
							.removeClass(def.hiddenClass)
							.data('height', $this.outerHeight())
							.addClass(def.hiddenClass);
							
						}
						else
						{
							$this.data('height', $this.outerHeight());
						}
					});
					
					// Show First Row
					methods.setConfiguration(def.show, 0);
					
					
					// Auto Switch
					if(def.autoSwitch && typeof def.autoSwitch == 'number')
					{
						methods.autoswitch(def.autoSwitch);
					}
					
					// Instance
					p.container.data('thumbnailsCarousel', {options: def, functions: methods});
				},
				
				setConfiguration: function(_show, _index)
				{
					if( ! _index)
						_index = 0;
					
					if(p.items.length > _show)
					{
						_index = methods.getIndex(_index);
						
						p.items.addClass(def.hiddenClass);
						methods.getIndex(_index, true).removeClass(def.hiddenClass);
						
						def.show = _show;
						def.index = _index;
						p.index = _index;
					}
					else
					{
						p.items.removeClass(def.hiddenClass);
					}
				},
				
				getIndex: function(index, fetch_items)
				{
					var max_index = Math.ceil(p.items.length / def.show);
					
					index = Math.abs(index) % max_index;
					
					if(fetch_items)
					{
						return p.items.slice(index * def.show, index * def.show + def.show);
					}
					
					return index;
				},
				
				
				goTo: function(index)
				{
					if(index == p.index || p.container.data('is-busy'))
						return false;
					
					index = methods.getIndex(index);
						
					p.container.data('is-busy', 1);
						
					var height_method = 'outerHeight',
						$current_items = methods.getIndex(p.index, true),
						$next_items = methods.getIndex(index, true),
						i = 0,
						
						current_row_height = p.container[height_method](),
						next_row_height = 0; // Can also be outerHeight, depending in the CSS
					
					
					$current_items.addClass(def.hiddenClass);
					$next_items.removeClass(def.hiddenClass);
					
					next_row_height = p.container[height_method]();
					
					$current_items.removeClass(def.hiddenClass);
					$next_items.addClass(def.hiddenClass);
					
					TweenMax.set(p.container, {css: {height: current_row_height}});
					TweenMax.to(p.container, .5, {css: {height: next_row_height}});
					
					// Hide Current Items
					var delay_counter = 0,
						switch_delay = .1,
						total_delay = switch_delay * $current_items.length;
					
					// Upcoming Elements
					$next_items.removeClass('hidden');
					
					var ctop = $current_items.eq(0).position().top,
						ntop = $next_items.eq(0).position().top;
						
					TweenMax.set($next_items, {css: {
						zIndex: 2, 
						autoAlpha: 0,
						scale: .2
					}});
					
					if(index < p.index)
					{
						TweenMax.set($current_items, {css: {
							top: -(ctop - ntop)
						}});
					}
					else
					{
						TweenMax.set($next_items, {css: {
							top: -(ntop - ctop),
						}});
					}
					
					$current_items.each(function(i, el)
					{
						var $this = $(el);
						
						TweenMax.to($this, 0.3, {css: {autoAlpha: 0}, delay: i * switch_delay});
					});
					
					$next_items.each(function(i, el)
					{
						var $this = $(el);
						
						TweenMax.to($this, 0.3, {css: {autoAlpha: 1, scale: 1}, delay: (total_delay + def.transitionDelay) + i * switch_delay});
					});
					
					setTimeout(function()
					{
						$next_items.add($current_items).add(p.container).attr('style', '');
						$current_items.addClass(def.hiddenClass);
						
						p.index = index;
						
						p.container.data('is-busy', 0);
						
					}, methods.toMillis(def.transitionDuration) + methods.toMillis(def.transitionDelay) + methods.toMillis(total_delay * 2));
				},
				
				
				next: function(rev)
				{
					var next = p.index + 1;
					
					if(rev)
					{
						next = p.index - 1;
						
						if(next < 0)
							next = p.items.length - 1;
					}
					
					methods.goTo(next);
				},
				
				
				toMillis: function(sec)
				{
					return 1000 * sec;
				},
				
				
				autoswitch: function(length)
				{
					p.asInstance = TweenMax.to(p.as, length, {pct: 100, onComplete: function()
						{
							p.as.pct = 0;
							p.asInstance.restart();
							
							methods.next();
						}
					});
					
					p.container.hover(function()
					{
						p.asInstance.pause();
					}, 
					function()
					{
						p.asInstance.resume();
					});
					
				}
			};
			
			
			if(typeof opts == 'object')
			{				
				methods.init.apply(this, [opts]);
			}
			
		});
	}
	
})(jQuery, window);