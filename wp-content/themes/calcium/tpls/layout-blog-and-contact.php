<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

$blog_title = get_data('frontpage_blog_title');
$blog_posts = get_data('frontpage_blog_posts_count');

$contact_title = get_data('frontpage_contact_title');

# Latest Blog Posts
$latest_blog = new WP_Query(array('posts_per_page' => $blog_posts, 'ignore_sticky_posts' => true));

?>
<!-- Blog -->
<div class="row">
	<div class="large-8 columns">
		<div class="widget">
			<h3><?php echo $blog_title; ?></h3>
			<ul class="blog-latest">
			<?php
			if($latest_blog->have_posts()):
			
				while($latest_blog->have_posts()): $latest_blog->the_post();
				
					?>
					<li>
						<a href="<?php the_permalink(); ?>">
							<?php echo the_title(); ?> 
							<span>/ <?php the_time('d M'); ?></span>
						</a>
					</li>
					<?php
					
				endwhile;
				
				wp_reset_postdata();
				wp_reset_query();
			
			endif;
			?>
			</ul>
		</div>
	</div>
	<div class="large-4 columns">
		<div class="widget">
			<h3><?php echo $contact_title; ?></h3>
			
			<form class="widget-contact" method="post" data-check="<?php echo wp_create_nonce("contact-form"); ?>">
			
				<div class="success-message">
					<div class="alert-box success"><?php _e('Thank you for your message!', TD); ?></div>
				</div>
				
				<input type="text" name="name" autocomplete="off" placeholder="<?php _e('Name', TD); ?>:" />
				<input type="text" name="email" autocomplete="off" placeholder="<?php _e('E-mail', TD); ?>:" />
				<textarea name="message" class="autogrow" placeholder="<?php _e('Message', TD); ?>:"></textarea>
				<input type="submit" value="<?php _e('Send', TD); ?>" class="send"/>
				
	
				<div class="spinner">
					<div class="double-bounce1"></div>
					<div class="double-bounce2"></div>
				</div>
			</form>
		</div>
	</div>
</div>