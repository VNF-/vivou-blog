<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

global $post, $_author_name, $_posts_count;
	
$post_id = $post->ID;
$user_id = $post->post_author;

$author = new WP_User($user_id);

if( ! $author)
	return;

$_author_name = $author->display_name;


$_user_url = $author->user_url;
$_bio = $author->description;

$posts_url = get_author_posts_url(get_the_author_meta( 'ID' ));

if( ! $_user_url)
	$_user_url = $posts_url;

$nickname = $author->nickname;


# Author Full Name
$first_name = $author->first_name;
$last_name = $author->last_name;
	
if($first_name || $last_name)
{
	$_author_name = "{$first_name} {$last_name}";
}

	
$author_info_to_show = 'post_author'; // sub title
$_posts_count = count_user_posts($user_id);

?>
<div class="author-page">
	<div class="row">
		<div class="large-3 medium-3 columns">
			<div class="image">
				<a href="<?php echo $_user_url; ?>"><?php echo get_avatar($user_id); ?></a>
			</div>
		</div>
		<div class="large-9 medium-9 columns">
			<div class="author-content">
				<h3><?php is_author() ? _e('All posts by:', TD) : _e('Author:', TD); ?></h3>
				<h1>
					<a href="<?php echo $posts_url; ?>">
					<?php echo $_author_name . (is_author() ? " <span>({$_posts_count})</span>" : ''); ?></a>
				</h1>
				
				<?php echo $_bio ? wpautop($_bio) : wpautop(__('No other information about this author.', TD)); ?>
			</div>
		</div>
	</div>
</div><!-- end: Author -->