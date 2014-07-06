/**
 *	Portfolio Plugin for Calcium Theme
 *
 *	Plugin by: Arlind Nushi
 *	www.arlindnushi.com
 *
 *	Version: 1.0
 *	Date: 2/26/14
 */

function closeAllPortfolioItems()
{
	// Opened Item
	var $item = pub.$portfolio.find('.portfolio-item.is-open');
	
	$item.each(function(i, el)
	{
		var id = jQuery(el).data('id');
		closePortfolioItem(id, true);
	});
}

function closePortfolioItem(id, close_container)
{
	// Close Item..
	var $ = jQuery,
		current_row = pub.$portfolio.data('current-row'),
		$item = pub.$portfolio.find('.post-' + id);
	
	if(typeof current_row == 'undefined')
		current_row = 0;
	
	if($item.length)
	{
		var $p    	 = $item.parent('li'),
			$arrow 	 = $item.find('.opened-arrow'),
			$info    = $item.data('project-info') || $p.find('.project-open'),
			$gallery = $info.find('.portfolio-gallery');
		
		$gallery.cycle('pause');
		
		$item.removeClass('is-open').css({
			marginBottom: 0
		});
		
		TweenMax.to($arrow, .4, {css: {bottom: -15, autoAlpha: 0}});
		TweenMax.to($info, .4, {css: {autoAlpha: 0}, onComplete: function()
		{
			$info.hide();
		}});
		
		pub.$portfolio.data({
			currentId: null
		});
		
		$p.data({
			isOpen: false
		});
		
		if(close_container)
		{
			setTimeout(function()
			{
				// When Using Isotope
				if(pub.$portfolio.hasClass('with-isotope'))
				{	
					pub.$portfolio.find('> ul').isotope('reLayout');
				}
				
			}, 400);
		}
	}
}

function openPortfolioItem(id)
{		
	// Open Item..
	var $ = jQuery,
		$item = pub.$portfolio.find('.post-' + id),
		current_row = pub.$portfolio.data('current-row');
	
	if($item.length)
	{
		var $p    	 = $item.parent('li'),
			$arrow 	 = $item.find('.opened-arrow'),
			$info    = $item.data('project-info') || $p.find('.project-open'),
			$gallery = $info.find('.portfolio-gallery');
			
		// Direct Link Item
		if($item.hasClass('direct-link'))
		{
			window.location.href = $item.find('a.show-details').attr('href');
			return true;
		}
		
		if(pub.$portfolio.data('currentId') == id)
		{
			return false;
		}
				
		
		if( ! $item.data('project-info'))
		{
			$item.data('project-info', $info);
		}
		
		if($gallery.find('a').length == 0)
		{
			$item.data('loaded', true);
		}
		else
		if( ! $item.data('loaded'))
		{
			var first_img = $gallery.children().first().find('img').attr('src'),
				img = new Image();
			
			img.src = first_img;
			
			img.onload = function()
			{
				$item.data('loaded', true);
				openPortfolioItem(id);
			}
			
			return true;
		}
		
		// Calculate Rows, then continue
		calculatePortfolioRows();
		
		// Calculate Height
		$info.insertAfter( $p ).show();
		
		var info_height	 = $info.outerHeight(),
			item_id      = $item.data('id'),
			item_name      = $item.data('name'),
			row_id       = $p.data('row-id'),
			row_changed	 = false;
		
		$info.hide();
		
		
		// When Using Isotope
		if(pub.$portfolio.hasClass('with-isotope'))
		{
			var $items_from_row = portfolioGetItemsFrom(-1).not($p);
			
			$items_from_row.each(function(i, el)
			{
				closePortfolioItem($(el).find('.portfolio-item').data('id'));
			});
			
			$item.css({
				marginBottom: info_height
			});
			
			pub.$portfolio.find('> ul').isotope('reLayout');
			
			var top = pub.$portfolio.data('offsets')[ row_id ],
				r_offset = $item.outerHeight() * (row_id + 1);
			
			
			$info.css({top: r_offset}).show();
			
			$item.addClass('is-open');
			
			pub.$portfolio.data({
				currentId: item_id,
				currentRow: row_id
			});
			
			$p.data({
				isOpen: true
			});
			
			TweenMax.set($info, {css: {autoAlpha: 0}});
			TweenMax.to($info, .8, {css: {autoAlpha: 1}, delay: .5});
			
			TweenMax.set($arrow, {css: {bottom: -20}});
			TweenMax.to($arrow, .8, {css: {bottom: 0, autoAlpha: 1}});
			
			socialNetworksInit();
			
			// Setup Gallery
			if($gallery.length)
			{
				if($gallery.hasClass('has-cycle'))
				{
					$gallery.cycle('resume');
				}
				else
				{
					$gallery.find('.hidden').removeClass('hidden');
					
					var sw = $gallery.data('switch-interval');
					
					if(typeof sw == 'undefined')
						sw = 0;
						
					$gallery.cycle({
						speed: 600,
						log: false,
						slides: '> a.img',
						timeout: 1000 * sw,
						pager: $gallery.find('.portfolio-gallery-pager ul'),
						next: $gallery.find('.portfolio-next'),
						prev: $gallery.find('.portfolio-prev'),
						autoHeight: 'container',
						pagerTemplate: '<li><a></a></li>',
						pagerActiveClass: 'current',
						pauseOnHover: true
					});
					
					$gallery.addClass('has-cycle');
					
					$gallery.on('cycle-before', function(event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag)
					{
						if(incomingSlideEl != null)
						{
							portfolioUpdateInfoHeight();
						}
					});
				}
			}
		}
		
		
		// URL Hash
		var st = $(window).scrollTop();
		window.location.hash = 'item:' + item_name + ($p.data('paged-id') ? (':page:' + $p.data('paged-id')) : '');
		$(window).scrollTop(st);
		
		return true;
	}
	
	return false;
}


function portfolioGetItemsFrom(row_id)
{
	return pub.$portfolio.find('> ul > li').filter(function(i, el)
	{
		var rid = jQuery(el).data('rowId');
		
		return (row_id == -1 || rid == row_id) && jQuery(el).data('isOpen');
	});
}


function calculatePortfolioRows()
{
	var $ = jQuery,
		offsets = [],
		$first_item,
		last_offset = 0,
		row_id = -1;
	
	pub.$portfolio.find('> ul > li:not(.isotope-hidden)').each(function(i, el)
	{
		var $this = $(el),
			$item = $this.find('.portfolio-item'),
			top = $this.offset().top;
		
		if( ! $first_item)
		{
			$first_item = $item;
		}
		
		if($.inArray(top, offsets) == -1)
		{
			offsets.push(top);
		}
		
		if(last_offset != top)
		{
			last_offset = top;
			row_id++;
		}
		
		$this.data('row-id', row_id);
		
		$item.css({
			marginBottom: 0
		});
	});
	
	
	if(offsets.length)
	{	
		var first_offset  	 = offsets[0],
			relative_offsets = [];
		
		offsets.forEach(function(value, key)
		{
			relative_offsets.push(value - first_offset + $first_item.outerHeight());
		});
		
		pub.$portfolio.data({
			rowsCount: offsets.length,
			offsets: offsets,
			rOffsets: relative_offsets
		});
	}
}


function portfolioUpdateInfoHeight()
{
	// Opened Item
	var $item = pub.$portfolio.find('.portfolio-item.is-open'),
		$info = $item.data('project-info');
	
	if( ! $info)
	{
		$$item.css({
			marginBottom: 0
		});
		
		// When Using Isotope
		if(pub.$portfolio.hasClass('with-isotope'))
		{	
			pub.$portfolio.find('> ul').isotope('reLayout');
		}
		return;
	}
	
	if(typeof $info != 'undefined' && $info.length)
	{
		setTimeout(function()
		{
			$item.css({
				marginBottom: parseInt($info.outerHeight())
			});
		
			// When Using Isotope
			if(pub.$portfolio.hasClass('with-isotope'))
			{	
				pub.$portfolio.find('> ul').isotope('reLayout');
			}
			
		}, 600);
	}
}