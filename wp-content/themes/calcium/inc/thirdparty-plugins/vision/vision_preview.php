<?php
// loads wordpress
require_once('get_wp.php'); // loads wordpress stuff

//prevent direct access to file, only log in user can access.
if(!is_user_logged_in()){
wp_die("Can't load this file directly");
}

// gets shortcode
$shortcode = stripslashes(trim( $_GET['sc'] )) ;

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="all" />
<?php wp_head(); ?>
<style type="text/css">
html {
	margin: 0 !important;
}
body {
padding: 20px 15px;
min-width:160px !important;
background:#FFF !important;
border:0 !important;
}
.tt-icon {
padding:5px 0 40px 55px !important;
}

.notification {
width:87% !important;	
}

.closeable-x {
background: url(images/shortcodes/notification-closeable-x.png) 96% 8px no-repeat !important;
}

.vision-pullquote-1,
.vision-pullquote-2,
.vision-pullquote-3,
.vision-pullquote-4{
width:60%;
}

#vision-sc-preview .vision-icon {
padding: 4px 0 35px 55px !important;
}
</style>
</head>
<body>
<?php echo do_shortcode( $shortcode ); ?>
</body>
</html>