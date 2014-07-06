<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

define("NO_HEADER", 1);
define("NO_FOOTER", 1);

get_header();

?>
<div class="row">
	<div class="large-8 large-centered columns">
		<div class="error-box">
			<div class="error-inner">
				<div class="row">
					<div class="large-9 columns">
						<h1>
							<?php _e('404 <small>page not found</small>', TD); ?>
						</h1>
					</div>
					<div class="large-3 columns alert-column">
						<a href="<?php echo home_url(); ?>">
							<i class="fi-alert size-72"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>					
</div>

<div class="row try-again">
	<div class="large-5 large-centered columns">
		<h3><?php _e('Search the site:', TD); ?></h3>
		<form role="search" method="get" class="search-form search-again" action="<?php echo esc_url(home_url('/')); ?>">
			<div class="row collapse">
				<div class="small-9 columns">
					<input type="text" name="s" placeholder="Search again...">
				</div>
				
				<div class="small-3 columns">
					<button type="submit" class="button postfix">
						<i class="fi-magnifying-glass size-16"></i>
					</button>
				</div>
			</div>					
		</form>
	</div>
</div>
<?php

get_footer();