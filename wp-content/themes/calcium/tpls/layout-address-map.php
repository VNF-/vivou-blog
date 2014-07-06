<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

$show_contact_map   = get_field('show_contact_map');
$map_location       = get_field('map_location');
$map_height			= get_field('map_height');
$map_zoom_level     = get_field('map_zoom_level');
$pin_image 			= get_field('pin_image');
$map_style			= get_field('map_style');

if( ! $show_contact_map || ! is_array($map_location) || ! $map_location['lat'] || ! $map_location['lng'])
	return;

$map_height = is_numeric($map_height) ? $map_height : 300;	
?>
<script src="//maps.googleapis.com/maps/api/js?sensor=false"></script>

<style>
#map { width:100%; height:<?php echo $map_height . 'px'; ?>; display: block; background: #f0f0f0; }

@media screen and (max-width: 768px) { #map { height: <?php echo intval($map_height * .7); ?>px; } }
@media screen and (max-width: 480px) { #map { height: <?php echo intval($map_height * .5); ?>px; } }
</style>

<div id="map"></div>

<script type="text/javascript">
function initialize()
{
	var map_canvas = document.getElementById('map'),
		
		position = new google.maps.LatLng(<?php echo $map_location['lat']; ?>, <?php echo $map_location['lng']; ?>),
		
		map_options = {
			center: position,
			zoom: <?php echo is_numeric($map_zoom_level) && $map_zoom_level > 0 ? $map_zoom_level : 8; ?>,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: false<?php if($map_style): ?>,
			styles: <?php echo html_entity_decode($map_style); ?>
			<?php endif; ?>
		};
	
	var map = new google.maps.Map(map_canvas, map_options);
	
	new google.maps.Marker({
		position: position,
		map: map<?php if($pin_image): ?>,
		icon: '<?php echo $pin_image; ?>'<?php endif; ?>
	});
	
	
	// Click Enable Scroll
	google.maps.event.addListener(map, 'click', function(event)
	{
		map.setOptions({scrollwheel: true})
	});
	
	google.maps.event.addListener(map, 'dragend', function(event)
	{
		map.setOptions({scrollwheel: true})
	})
	
	// Hover Out Disable Scroll
	map_canvas.onmouseout = function(event)
	{
		map.setOptions({scrollwheel: false})
	};
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>