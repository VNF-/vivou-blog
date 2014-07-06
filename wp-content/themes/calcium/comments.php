<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

global $comment_index;

$comment_index = 1;

if ( post_password_required() || is_attachment() )
	return;
	
	
# List Comments
if(have_comments()):
	
	# Comment List Args
	$list_args = array(
		'callback' => 'laborator_list_comments_open', 
		'end-callback' => 'laborator_list_comments_close'
	);

	$comments_number = get_comments_number('%', '%', '%');
	$comments_number = $comments_number > 9 ? $comments_number : "0{$comments_number}";

?>
<div class="comments" id="comments">

	<div class="row">
		<div class="large-3 medium-3 columns">
			<div class="comment-count">
				<?php echo $comments_number; ?>
			</div>
		</div>
		<div class="large-9 medium-9 columns">
			<h1 class="title">
				<?php _e('Comments', TD); ?> 
			
				<?php if(comments_open()): ?>
				<a href="#" class="reply reply-go-form"><?php _e('Leave a reply', TD); ?></a>
				<?php endif; ?>
			</h1>
		</div>
	</div>
	
	<?php wp_list_comments($list_args); ?>
	
	<?php	
		$comments_pagination = paginate_comments_links(array('echo' => false));
		
		if($comments_pagination)
		{
			?>
			<div class="row">
				<div class="large-9 large-offset-3 medium-9 medium-offset-3 columns">
					<div class="comments-pagination">
						<?php echo $comments_pagination; ?>
					</div>
				</div>
			</div>
			<?php
		}
	?>
	
</div>
<?php

endif;


if(comments_open()):
	
	# Comment Form Args
	$form_args = array(
		'title_reply' 			=> '<h1 class="title">' . __('Reply', TD) . '</h1>',
		'title_reply_to' 		=> '<h3>' . __('Leave a Reply to %s', TD) . '</h3>',
		
		'comment_notes_before' 	=> '',
		'comment_notes_after' 	=> '',
		
		'comment_field' 		=> '<div class="comment_text_field' . (is_user_logged_in() ? ' full_size' : '') . '"><textarea id="comment" name="comment" placeholder="' . __('Message:', TD) . '" rows="3" aria-required="true"></textarea></div>',
		'comment_notes_after' 	=> '',#'<div class="rules" style="padding-bottom: 15px">' . __('<h5>Rules of the Blog</h5><p>Do not post violating content, tags like bold, italic and underline are allowed that means HTML can be used while commenting. Lorem ipsum dolor sit amet conceur half the time you know i know what.', TD) . '</p></div>',
		
		'label_submit' 			=> __('Comment', TD)
	);
	
	add_action('comment_form', 'laborator_commenting_rules');
	
			
	add_filter('comment_form_default_fields', 'laborator_comment_fields');
	
	add_action('comment_form_before_fields', 'laborator_comment_before_fields');
	add_action('comment_form_after_fields', 'laborator_comment_after_fields');
	
	?>
	<div class="reply-form">
		<div class="row">
			<div class="large-9 medium-9 medium-offset-3 large-offset-3 columns">
				<?php 
				
				comment_form($form_args); 
				
				/*
				<h1>Reply</h1>
				<form>
					<input type="text" placeholder="Name" />
					<input type="text" placeholder="E-mail" />
	
					<div class="row collapse">
						<div class="small-12 large 12">
							<textarea placeholder="Message:" rows="3"></textarea>
						</div>
					</div>
					<input type="submit" class="button" value="Comment" />
				</form>
				
				<div class="rules">
					<h5>Rules of the blog</h5>
					<p>
						Do not post violating content, tags like bold, italic and underline are allowed that means HTML can be used while commenting. Lorem ipsum dolor sit amet conceur half the time you know i know what.
					</p>
				</div>
				*/ ?>
			</div>
		</div>
	</div>
	<?php

endif;