<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

global $post, $id, $comments_count, $has_thumb, $post_class, $more;

$blog_view_more = get_data('blog_view_more');
	
$id             = get_the_id();
$title			= get_the_title();
$comments_count = get_comments_number('%', '%', '%');
$has_thumb      = get_data('blog_thumbnails') && has_post_thumbnail();
$post_format 	= get_post_format();
$permalink 		= get_permalink();
$content 		= $blog_view_more ? get_the_content() : get_the_excerpt();
$content_full 	= get_the_content();

if( ! $title)
	$title = __('(No title)', TD);

$post_class 	= array("row", "blog-post");
$target			= "_self";

$post_y			= get_the_time("Y");
$post_M			= get_the_time("M");
$post_d			= get_the_time("d");
$single			= is_single();


if($single)
{
	$post_class[] = 'blog-single';
	$content = $content_full;
}


if(!$has_thumb && !in_array($post_format, array('quote','video','audio','image')))
	$post_class[] = 'no-thumbnail';
	
if(has_post_format('video') && ($video_info = extract_video_link($content_full)) && $video_info['type'] != 'unknown')
{
	$post_class[] = 'external-video';
	
	wp_enqueue_script('magnific-popup');
	wp_enqueue_style('magnific-popup');
}
else
if(has_post_format('audio'))
{
	$post_class[] = 'audio-media-post';
}
?>
<div <?php echo post_class(implode(' ', $post_class)); ?>>

	<div class="large-12 medium-12 columns">
		
		<?php 
		switch($post_format):
			
			case "quote":
			
				$content = get_the_content();
				$quote = extract_quote_text( $content );
				
				$content = wp_trim_words($content, apply_filters('excerpt_length', $content));
				
				?>
				<div class="quote">
					<div class="row">
						<div class="large-9 large-offset-3 columns">
							<?php echo $quote; ?>
						</div>
					</div>
				</div>
				<?php
				
				break;
			
			case "video":
				
				#$content = $content;
				
				$video_info = extract_video_link($content_full, true);
				$video_shortcode = extract_custom_shortcode($post, 'video');
				
				if($video_info['type'] != 'unknown')
				{
					if($has_thumb)
					{
						?>
						<div class="image">
							<a href="<?php echo $permalink; ?>" class="play-video" data-video-url="<?php echo $video_info['source']; ?>" target="<?php echo $target; ?>">
								<?php echo laborator_show_img($id, 'blog-thumb-1'); ?>
							</a>
						</div>
						<?php
					}
					else
					{
						laborator_show_video_frame($video_info);
						
						if($single)
							$content = str_replace($video_info['source'], '', $content_full);
					}
				}
				else
				if($video_shortcode)
				{
					if($single)
						$content = str_replace($video_shortcode, '', $content_full);
					
					?>
					<div class="hosted-video">
						<div class="row">
							<div class="large-12 columns">
								<?php
								echo do_shortcode($video_shortcode);
								?>
							</div>
						</div>
					</div>
					<?php
				}
				break;
			
			case "audio":
				
				if(has_post_format('audio'))
				{
					$audio_shortcode = extract_custom_shortcode($post, 'audio');
					echo '<div class="audio-shortcode-container">' . do_shortcode($audio_shortcode) . '</div>';
					
					if($single)
						$content = str_replace($audio_shortcode, '', $content_full);
				}
				
				break;
			
			case "image":
				
				$image = extract_post_image($content_full);
				
				if( ! $image && $has_thumb)
				{
					$image = laborator_img($id, 'blog-thumb-2');
				}
				else
				{
					if($single)
					{
						$content = $content_full;
					}
				}
				
				if($image):
					
					$image = preg_replace("/\?.*?$/", "", $image);
					
					wp_enqueue_style('magnific-popup');
					wp_enqueue_script('magnific-popup');
				?>
				<div class="image">
					<a href="<?php echo $image; ?>" class="open-image">
						<?php echo laborator_show_img($image, 790, 0, 3); ?>
					</a>
				</div>
				<?php
				endif;
				
				break;
				
			default:

				wp_enqueue_style('magnific-popup');
				wp_enqueue_script('magnific-popup');
				
				# Link Format
				if(has_post_format('link')):
					
					$content = get_the_content();
					$link = extract_first_link($content);
					
					if($link)
					{
						$title = '<i class="entypo-link"></i>' . $title;
						$permalink = $link;
						
						if( ! stristr($permalink, home_url()))
						{
							$target = "_blank";
						}
					}
					
				endif;
			
				if($has_thumb): ?>
				<div class="image">
					<a href="<?php 
					if($single)
					{					
						$post_thumbnail_id = get_post_thumbnail_id($id);
						$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
						
						echo $post_thumbnail_url;
					}
					else
					{	
						echo $permalink;
					}
					?>" title="<?php echo esc_attr($title); ?>" target="<?php echo $target; ?>"<?php echo $single ? ' class="open-image-info"' : ''; ?>>
						<?php echo laborator_show_img($id, 'blog-thumb-1'); ?>
						
						<?php if( ! $single): ?>
						<span class="hover">
							<em><?php _e('Read more', TD); ?></em>
							<i></i>
						</span>
						<?php else: ?>
						<span class="zoom-hover">
							<i class="entypo-resize-full"></i>
						</span>
						<?php endif; ?>
					</a>
					
					<?php
					if(has_post_format('gallery')):
						
						$gallery_images = extract_gallery_images($id);
						
						if(count($gallery_images))
						{	
							?>
							<div class="gallery-images">
							<?php
							foreach($gallery_images as $img):
							
								$caption = $img->post_title;
								
								?>
								<a href="<?php echo $img->guid; ?>" title="<?php echo esc_attr($caption); ?>">
									<?php echo laborator_show_img($img->guid, 'gallery-thumb-1'); ?>
								</a>
								<?php
								
							endforeach;
							?>
							</div>
							<?php
						}
						
					endif;
					?>
				</div>
				<?php
				endif; 
				
		endswitch; 
		?>
		
	</div>
	
	<div class="large-3 medium-3 columns">
		<div class="date">
			<span class="month"><?php 
				echo strtoupper($post_M);
				
				if(date("Y") != $post_y) 
					echo '<br />' . $post_y; 
			?></span>
			
			<span class="day"><?php echo $post_d; ?></span>
		</div>
		<div class="post-info">
			<?php if(get_data('blog_category') && has_category()): ?>
			<div class="category">
				<?php the_category(', '); ?>
			</div>
			<?php endif; ?>
			
			<?php if(get_data('blog_tags') && $single && has_tag()): ?>
			<div class="category">
				<?php the_tags(''); ?>
			</div>
			<?php endif; ?>
			
			<?php if( ! has_post_format('link') && ($comments_count || comments_open($id))): ?>
			<a class="comments" href="<?php echo $permalink; ?>#comments" target="<?php echo $target; ?>" title="<?php echo esc_html(sprintf(_n("0 comments", "%d comments", $comments_count), $comments_count)); ?>"><?php echo $comments_count; ?></a>
			<?php endif; ?>

		</div>
	</div>
	<div class="large-9 medium-9 columns">
		<div class="post-content">
			<h1>
				<a href="<?php echo $permalink; ?>" target="<?php echo $target; ?>" title="<?php echo esc_attr(strip_tags($title)); ?>">
					<?php echo $title; ?>
				</a>
			</h1>
			
			<div class="post-content-full formatted-content">
				<?php echo $single || $blog_view_more ? apply_filters('the_content', $content) : apply_filters('the_excerpt', $content); ?>
			</div>
			
			<?php 
			if($single):
				
				wp_link_pages(array(
					'before' => '<div class="post_pagination">' . __('<strong>Page:</strong>', TD),
					'after' => '</div>',
					'pagelink' => '<span class="current">%</span>'
				));
			endif; 
			?>
		</div>
	</div>
</div>