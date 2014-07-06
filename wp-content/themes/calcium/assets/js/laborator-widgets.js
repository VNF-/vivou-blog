;(function($, window, undefined)
{
	$(document).ready(function()
	{
		var laborator_widgets = $(".widgets-sortables");//$("#laborator_widgets");
		
		// Show/Hide Options
		laborator_widgets.on('click', 'a[data-more]', function(ev)
		{
			ev.preventDefault();
			
			var $this = $(this),
				$opts_group = $this.next();
			
			var og_link = $(this),
				options_group = og_link.next();
			
		
			if(options_group.is(':visible'))
			{
				options_group.find('input[name="og_visible"]').val(0);
				options_group.stop(true, true).slideUp('normal');
				og_link.html( og_link.data('more') );
			}
			else
			{
				options_group.find('input[name="og_visible"]').val(1);
				options_group.stop(true, true).slideDown('normal');
				og_link.html( og_link.data('less') );
			}
		});
		
		
		// Video Image Select
		var selected_att;
		
		laborator_widgets.on('click', '.select_video_image_btn', function(ev)
		{
			ev.preventDefault();
			
			var select_img 			= $(this),
				widget 				= select_img.parent().parent(),
				video_thumbnail 	= widget.find('input[name="video_thumbnail"]'),
				attachment_preview 	= widget.find('.attachment_preview');
			
						
			var opts = {
				title: 'Select Video Thumbnail',
				multiple: false,
				library: {
					type: 'image'
				},
				button : { text : 'Set as Video Thumbnail' }
			};
			
			var frame = wp.media.frames.videoSelector = wp.media(opts);
			
			frame.on('open', function()
			{	
				var selection = frame.state().get('selection');
				
				attachment = wp.media.attachment(video_thumbnail.val());
				attachment.fetch();
				
				selection.add( attachment ? [ attachment ] : [] )
			});
			
			frame.on('select', function(props, attachment) 
			{
				var attachments = frame.state().get('selection').models;
				
				_.each(attachments, function(attachment)
				{
					selected_att = attachment;
				});
				
				video_thumbnail.val(selected_att.id);
				updateSelectedAttachment(video_thumbnail, attachment_preview, selected_att);
			});
			
			frame.open();
		});
		
		
		// Remove Current Image
		laborator_widgets.on('click', '.attachment_preview a.rem', function(ev)
		{
			var $this = $(this),
				widget = $this.parent().parent().parent(),
				video_thumbnail 	= widget.find('input[name="video_thumbnail"]'),
				attachment_preview 	= widget.find('.attachment_preview');
					
					
			if(confirm('Remove Thumbnail?'))
			{	
				selected_att = null;
				
				video_thumbnail.val('');
				attachment_preview.html('').hide();
			}
		});
		
		
		function updateSelectedAttachment(video_thumbnail, attachment_preview, selected_att)
		{
			if( ! selected_att)
			{
				if(video_thumbnail.val().length)
				{							
					selected_att = wp.media.attachment(video_thumbnail.val());
		            selected_att.fetch();
		            
		            if(video_thumbnail.data('thumbnail'))
		            {
						attachment_preview.html( $('<img src="' + video_thumbnail.data('thumbnail') + '" /> <a href="#" class="rem">Remove</a>') );
						attachment_preview.show();
		            }
		            return;
				}
				else
				{
					attachment_preview.hide();
					return;
				}
			}

			attachment_preview.html( $('<img src="' + selected_att.get('sizes').thumbnail.url + '" />  <a href="#" class="rem">Remove</a>') );
			attachment_preview.show();
		}
		
	});
	
})(jQuery, window);