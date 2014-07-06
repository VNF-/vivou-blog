<?php
/*
	Laborator Image Resizer for WordPress
	
	Developed by: Arlind Nushi
	Website: www.arlindnushi.com & www.laborator.co
	
	Note: Zebra_Image class is required in order this plugin to work.
	Visit {@link http://stefangabos.ro/php-libraries/zebra-image/} to download this class and include on your file.
	
	
	Version: 1.4
*/

# include_once('Zebra_Image.php'); // If zebra image class is missing, include it!

function laborator_img($url, $width = 0, $height = 0, $crop = 0)
{
	$upload_dir	= wp_upload_dir();
	
	$post_thumbnail_url = '';
	
	$wpurl 		= site_url();
	$baseurl 	= $upload_dir['baseurl'];
	
	# Get Predefined Image Size
	if( ! is_numeric($width))
	{
		$image_size = LaboratorImageSizes::get_img_size($width);
		extract($image_size);
	}
	
	# Get from post ID
	if(is_numeric($url))
	{
		$post_thumbnail_id = get_post_thumbnail_id($url);
		
		if($post_thumbnail_id)
		{
			$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
		}
		else
		{
			return '';
		}
	}
	else
	{
		$post_thumbnail_url = $url;
	}
	
	
	# Verify if its on this server
	if(strpos($post_thumbnail_url, $wpurl) != -1)
	{
		$relative_path 	= str_replace($wpurl, '', $post_thumbnail_url);
		$relative_path 	= ltrim($relative_path, '/');
		$absolute_path 	= ABSPATH . $relative_path;
		
		$basename 		= basename($absolute_path);
		
		if($crop && ! is_numeric($crop))
			$crop = 1;
		
		# New Image Name
		$thumbnail_name	= 'labimg_' . ($width ? "{$width}_" : '') . ($height ? "{$height}_" : '') . ($crop ? "{$crop}_" : '') . $basename;
		$thumbnail_path	= dirname($absolute_path) . '/' . $thumbnail_name;
		$thumbnail_url 	= dirname($post_thumbnail_url) . '/' . $thumbnail_name;
		
		# Check if cached
		if(file_exists($thumbnail_path))
		{
			return $thumbnail_url;
		}
		
		# Create File
		if(file_exists($absolute_path))
		{
			# Generate Img
			$img = new Zebra_Image();
			
			$img->source_path = $absolute_path;
			$img->target_path = $thumbnail_path;
			$img->enlarge_smaller_images = false;
			$img->preserve_aspect_ratio = true;
			
			# If the width or height is not specified, then autogenerate the height
			$auto_height = $auto_width = 0;
			
			if( ! $height || ! $width)
			{
				$img_size = getimagesize($absolute_path);
				$img_size_w = $img_size[0];
				$img_size_h = $img_size[1];
					
				if( ! $height)
				{
					$width_ratio = $width / $img_size_w;
					$auto_height = intval($width_ratio * $img_size_h);
				}
				else
				if( ! $width)
				{
					$height_ratio = $height / $img_size_h;
					$auto_width = intval($height_ratio * $img_size_w);
				}
			}
			
			switch($crop)
			{
				case 1:
					$img->resize($width, $height, ZEBRA_IMAGE_CROP_CENTER, '#FFF');
					break;
					
				case 2:
				
					if( ! $height)
					{
						$height = $auto_height;
					}
					else
					if( ! $width)
					{
						$width = $auto_width;
					}
					
					$img->resize($width, $height, ZEBRA_IMAGE_BOXED, '#FFF');
					break;
				
				case 3:
					$img->resize($width, $height, ZEBRA_IMAGE_CROP_TOPCENTER, '#FFF');
					break;
				
				case 4:
				
					if( ! $height)
					{
						$height = $auto_height;
					}
					else
					if( ! $width)
					{
						$width = $auto_width;
					}
					
					$img->resize($width, $height, ZEBRA_IMAGE_BOX_FIT, '#FFF');
					break;
					
				default:
					$img->resize($width, $height, ZEBRA_IMAGE_NOT_BOXED, '#FFF');
			}
			
			return $thumbnail_url;
		}
	}
	
	return strpos($url, "http") >= 0 ? $url : '';
}

function laborator_show_img($url, $width = 0, $height = 0, $crop = 0, $attrs = array())
{
	$img_path = laborator_img($url, $width, $height, $crop);
	
	if($img_path)
	{
		$extra_attrs = array();
		
		foreach($attrs as $attr_name => $attr_value)
		{
			$escaped_attr_value = esc_attr($attr_value);
			
			if($escaped_attr_value == '#nw#' || $escaped_attr_value == '#nh#')
			{
				$image_size = getimagesize( str_replace(home_url('/'), '', $img_path) );
				
				if($escaped_attr_value == '#nw#')
					$escaped_attr_value = $image_size[0];
					
				if($escaped_attr_value == '#nh#')
					$escaped_attr_value = $image_size[1];
			}
			
			$extra_attrs[] = "{$attr_name}=\"{$escaped_attr_value}\"";
		}
		
		return '<img src="' . $img_path . '" ' . (is_string($width) ? (' alt="' . $width . '"') : '') . ' ' . implode(' ', $extra_attrs) . ' />';
	}
}

function laborator_img_add_size($alias, $width = 0, $height = 0, $crop = false)
{	
	LaboratorImageSizes::add_img_size($alias, $width, $height, $crop);
}

function laborator_img_clear_cache()
{
	global $files_deleted, $files_deleted_size, $files_list;
	
	$path = wp_upload_dir();
	$uploads_dir = $path['basedir'];
	
	$files = glob($uploads_dir.'/*', GLOB_NOSORT);
	
	$files_deleted = 0;
	$files_deleted_size = 0;
	
	foreach($files as $file)
	{	
		if(is_dir($file))
		{
			laborator_img_clear_cache_recursion($file);
		}
		else
		{
			laborator_img_delete($file);
		}
	}
	
	$files_deleted_size = size_format($files_deleted_size);
	
	return array('files_deleted' => $files_deleted, 'deleted_files_size' => $files_deleted_size, 'files_list' => $files_list);
}

function laborator_img_clear_cache_recursion($path)
{
	global $files_deleted, $files_deleted_size, $files_list;
	
	$files = glob($path . '/*', GLOB_NOSORT);
	
	foreach($files as $file)
	{	
		if(is_dir($file))
		{
			laborator_img_clear_cache_recursion($file);
		}
		else
		{
			laborator_img_delete($file);
		}
	}
}

function laborator_img_delete($file)
{
	global $files_deleted, $files_deleted_size, $files_list;
	
	$name = basename($file);
	$pref = 'labimg_';
	$pref_len = strlen($pref);
	
	if(substr($name, 0, $pref_len) == $pref)
	{
		$files_deleted++;
		$files_deleted_size += filesize($file);
		$files_list[] = str_replace(ABSPATH, '', $file);
		
		@unlink($file);
	}
}


/* Class to Hold Registered Laborator Image Sizes */
class LaboratorImageSizes 
{
	public static $image_sizes = array();
	
	public static function add_img_size($alias, $width = 0, $height = 0, $crop = 0)
	{
		if( ! is_numeric($crop))
		{
			$crop = $crop ? 1 : 0;
		}
		
		self::$image_sizes[$alias] = array('width' => $width, 'height' => $height, 'crop' => $crop);
	}
	
	public static function get_img_size($alias)
	{
		return self::$image_sizes[$alias];
	}
}


/* Clear Image Cache */
if(get('lab_img_clear_cache'))
{
	$details = laborator_img_clear_cache();
	
	if(is_user_logged_in())
	{
		print_r($details);
	}
	
	exit;
}