<?php
/**
 * Plugin Name: Facebook Page Feed (Graph API)
 * Plugin URI: https://cameronjones.x10.mx/projects/facebook-page-plugin
 * Description: Display the Facebook Page Plugin from the Graph API. 
 * Version: 1.0.1
 * Author: Cameron Jones
 * Author URI: http://cameronjones.x10.mx
 * License: GPLv2
 
 * Copyright 2015  Cameron Jones  (email : cameronjonesweb@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function facebook_page_plugin($filter) {
	$return = NULL;
	$a = shortcode_atts( array(
        'href' => NULL,
        'width' => NULL,
		'height' => NULL,
		'cover' => NULL,
		'facepile' => NULL,
		'posts' => NULL
    ), $filter );
	if(isset($a['href']) && !empty($a['href'])){
		$return .= '<div id="fb-root"></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&appId=191521884244670&version=v2.3";fjs.parentNode.insertBefore(js, fjs);	}(document, \'script\', \'facebook-jssdk\'));</script>';
		$return .= '<div class="fb-page" data-href="http://facebook.com/' . $a["href"] . '" ';
		if(isset($a['width']) && !empty($a['width'])){
			$return .= ' data-width="' . $a['width'] . '"';
		}
		if(isset($a['height']) && !empty($a['height'])){
			$return .= ' data-width="' . $a['height'] . '"';
		}
		if(isset($a['cover']) && !empty($a['cover'])){
			switch($a['cover']){
				case "true":
				$a['cover'] = false;
				break;
				case "false":
				$a['cover'] = true;
				break;
			}
			$return .= ' data-hide-cover="' . $a['cover'] . '"';
		}
		if(isset($a['facepile']) && !empty($a['facepile'])){
			$return .= ' data-show-facepile="' . $a['facepile'] . '"';
		}
		if(isset($a['posts']) && !empty($a['posts'])){
			$return .= ' data-show-posts="true"';
		}
		$return .= '></div>';
	}
	return $return;
}
add_shortcode( 'facebook-page-plugin', 'facebook_page_plugin' );