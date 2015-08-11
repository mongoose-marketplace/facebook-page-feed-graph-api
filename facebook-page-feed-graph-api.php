<?php
/**
 * Plugin Name: Facebook Page Plugin
 * Plugin URI: https://cameronjones.x10.mx/projects/facebook-page-plugin
 * Description: It's time to upgrade from your old like box! Display the Facebook Page Plugin from the Graph API using a shortcode or widget. Now available in 136 different languages
 * Version: 1.3.3
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

defined( 'ABSPATH' ) or die();

//Hooks
add_shortcode( 'facebook-page-plugin', 'facebook_page_plugin' );
add_filter( 'widget_text', 'do_shortcode' );
add_action( 'wp_dashboard_setup', 'facebook_page_plugin_dashboard_widget' );
add_action( 'admin_enqueue_scripts', 'facebook_page_plugin_admin_resources' );
add_action( 'widgets_init', 'facebook_page_plugin_load_widget' );
add_action( 'admin_notices', 'facebook_page_plugin_admin_notice' );
add_action( 'admin_init', 'facebook_page_plugin_admin_notice_ignore' );

function facebook_page_plugin( $filter ) {
	$return = NULL;
	$a = shortcode_atts( array(
        'href' => NULL,
        'width' => 340,
		'height' => 130,
		'cover' => NULL,
		'facepile' => NULL,
		'posts' => NULL,
		'language' => get_bloginfo('language'),
		'cta' => NULL,
		'small' => NULL,
		'adapt' => NULL,
    ), $filter );
	if(isset($a['href']) && !empty($a['href'])){
		$a['language'] = str_replace("-", "_", $a['language']);
		$return .= '<div id="fb-root" data-version="1.3.3"></div><script async>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/' . $a['language'] . '/sdk.js#xfbml=1&version=v2.4";fjs.parentNode.insertBefore(js, fjs);	}(document, \'script\', \'facebook-jssdk\'));</script>';
		$return .= '<div class="fb-page" data-version="1.3.3" data-href="https://facebook.com/' . $a["href"] . '" ';
		if(isset($a['width']) && !empty($a['width'])){
			$return .= ' data-width="' . $a['width'] . '"';
		}
		if(isset($a['height']) && !empty($a['height'])){
			$return .= ' data-height="' . $a['height'] . '"';
		}
		if(isset($a['cover']) && !empty($a['cover'])){
			if($a['cover'] == "false"){
				$return .= ' data-hide-cover="true"';
			} else if($a['cover'] == "true"){
				$return .= ' data-hide-cover="false"';
			}	
		}
		if(isset($a['facepile']) && !empty($a['facepile'])){
			$return .= ' data-show-facepile="' . $a['facepile'] . '"';
		}
		if(isset($a['posts']) && !empty($a['posts'])){
			$return .= ' data-show-posts="' . $a['posts'] . '"';
		}
		if(isset($a['cta']) && !empty($a['cta'])){
			$return .= ' data-hide-cta="' . $a['cta'] . '"';
		}
		if(isset($a['small']) && !empty($a['small'])){
			$return .= ' data-small-header="' . $a['small'] . '"';
		}
		if(isset($a['adapt']) && !empty($a['adapt'])){
			$return .= ' data-adapt-container-width="' . $a['adapt'] . '"';
		} else {
			$return .= ' data-adapt-container-width="false"';
		}
		$return .= '><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/' . $a['href'] . '"><a href="https://www.facebook.com/' . $a['href'] . '">' . $a['href'] . '</a></blockquote></div></div>';
	}
	return $return;
}

function facebook_page_plugin_dashboard_widget() {
	wp_add_dashboard_widget( 'facebook-page-plugin-shortcode-generator', 'Facebook Page Plugin Shortcode Generator', 'facebook_page_plugin_dashboard_widget_callback' );
}

function facebook_page_plugin_dashboard_widget_callback() {
	try {
    	$lang_xml = file_get_contents('https://www.facebook.com/translations/FacebookLocales.xml');
	}catch(Exception $ex){
		$lang_xml = NULL;
	}
	if(isset($lang_xml) && !empty($lang_xml)){
    	$langs = new SimpleXMLElement($lang_xml);
	} else {
		$langs = NULL;
	}
	echo '<form>';
		echo '<p><label>Facebook Page URL: <input type="url" id="fbpp-href" /></label></p>';
		echo '<p><label>Width (pixels): <input type="number" max="500" min="180" id="fbpp-width" /></label></p>';
		echo '<p><label>Height (pixels): <input type="number" min="70" id="fbpp-height" /></label></p>';
		echo '<p><label>Show Cover Photo: <input type="checkbox" value="true" id="fbpp-cover" /></label></p>';
		echo '<p><label>Show Facepile: <input type="checkbox" value="true" id="fbpp-facepile" /></label></p>';
		echo '<p><label>Show Posts Feed: <input type="checkbox" value="true" id="fbpp-posts" /></label></p>';
		echo '<p><label>Hide Call To Action: <input type="checkbox" value="true" id="fbpp-cta" /></label></p>';
		echo '<p><label>Small Header: <input type="checkbox" value="true" id="fbpp-small" /></label></p>';
		echo '<p><label>Adaptive Width: <input type="checkbox" value="true" id="fbpp-adapt" checked /></label></p>';
		echo '<p><label>Language: <select id="fbpp-lang" /><option value="">Site Language</option>';
		if(isset($langs) && !empty($langs)){
			foreach($langs as $lang){
				echo '<option value="' . $lang->codes->code->standard->representation . '">' . $lang->englishName . '</option>';
			}
		}
		echo '</label></p>';
		echo '<input type="text" readonly="readonly" id="facebook-page-plugin-shortcode-generator-output" onfocus="this.select()" />';
	echo '</form>';
}

function facebook_page_plugin_admin_resources() {
	wp_enqueue_script( 'Facebook Page Plugin Admin Scripts', plugin_dir_url( __FILE__ ) . '/js/facebook-page-plugin-admin.js' );
	wp_enqueue_style( 'Facebook Page Plugin Admin Styles', plugin_dir_url( __FILE__ ) . '/css/facebook-page-plugin-admin.css' );
}

class facebook_page_plugin_widget extends WP_Widget {
	
	private $facebookURLs = array('https://www.facebook.com/', 'https://facebook.com/', 'www.facebook.com/', 'facebook.com/');
	
	function __construct() {
		parent::__construct( 'facebook_page_plugin_widget', __('Facebook Page Plugin', 'facebook_page_plugin'), array( 'description' => __( 'Generates a Facebook Page feed in your widget area', 'facebook_page_plugin' ), ) 	);
	}
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		if(isset($instance['href']) && !empty($instance['href'])){
			$href = $instance['href'];
			foreach($this->facebookURLs as $url){
				$href = str_replace($url, '', $href);
			}
		} else {
			$href = NULL;
		}
		if(isset($instance['width']) && !empty($instance['width'])){
			$width = $instance['width'];
		} else {
			$width = NULL;
		}
		if(isset($instance['height']) && !empty($instance['height'])){
			$height = $instance['height'];
		} else {
			$height = NULL;
		}
		if(isset($instance['cover']) && !empty($instance['cover'])){
			$cover = 'true';
		} else {
			$cover = 'false';
		}
		if(isset($instance['facepile']) && !empty($instance['facepile'])){
			$facepile = 'true';
		} else {
			$facepile = 'false';
		}
		if(isset($instance['posts']) && !empty($instance['posts'])){
			$posts = 'true';
		} else {
			$posts = 'false';
		}
		if(isset($instance['cta']) && !empty($instance['cta'])){
			$cta = 'true';
		} else {
			$cta = 'false';
		}
		if(isset($instance['small']) && !empty($instance['small'])){
			$small = 'true';
		} else {
			$small = 'false';
		}
		if(isset($instance['adapt']) && !empty($instance['adapt'])){
			$adapt = 'true';
		} else {
			$adapt = 'false';
		}
		if(isset($instance['language']) && !empty($instance['language'])){
			$language = $instance['language'];
		} else {
			$language = NULL;
		}
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		if( !empty($href )){
			$shortcode = '[facebook-page-plugin href="' . $href . '"';
			if(isset($width) && !empty($width)){
				$shortcode .= ' width="' . $width . '"';
			}
			if(isset($height) && !empty($height)){
				$shortcode .= ' height="' . $height . '"';
			}
			if(isset($cover) && !empty($cover)){
				$shortcode .= ' cover="' . $cover . '"';
			}
			if(isset($facepile) && !empty($facepile)){
				$shortcode .= ' facepile="' . $facepile . '"';
			}
			if(isset($posts) && !empty($posts)){
				$shortcode .= ' posts="' . $posts . '"';
			}
			if(isset($language) && !empty($language)){
				$shortcode .= ' language="' . $language . '"';
			}
			if(isset($cta) && !empty($cta)){
				$shortcode .= ' cta="' . $cta . '"';
			}
			if(isset($small) && !empty($small)){
				$shortcode .= ' small="' . $small . '"';
			}
			if(isset($adapt) && !empty($adapt)){
				$shortcode .= ' adapt="' . $adapt . '"';
			}
			$shortcode .= ']';
			echo do_shortcode( $shortcode );
		}
		echo $args['after_widget'];
	} 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'New title', 'facebook_page_plugin' );
		}
		if ( isset( $instance[ 'href' ] ) ) {
			$href = $instance[ 'href' ];
		} else {
			$href = '';
		}
		if ( isset( $instance[ 'width' ] ) ) {
			$width = $instance[ 'width' ];
		} else {
			$width = '';
		}
		if ( isset( $instance[ 'height' ] ) ) {
			$height = $instance[ 'height' ];
		} else {
			$height = '';
		}
		if ( isset( $instance[ 'cover' ] ) ) {
			$cover = $instance[ 'cover' ];
		} else {
			$cover = 'false';
		}
		if ( isset( $instance[ 'facepile' ] ) ) {
			$facepile = $instance[ 'facepile' ];
		} else {
			$facepile = 'false';
		}
		if ( isset( $instance[ 'posts' ] ) ) {
			$posts = $instance[ 'posts' ];
		} else {
			$posts = 'false';
		}
		if ( isset( $instance[ 'cta' ] ) ) {
			$cta = $instance[ 'cta' ];
		} else {
			$cta = 'false';
		}
		if ( isset( $instance[ 'small' ] ) ) {
			$small = $instance[ 'small' ];
		} else {
			$small = 'false';
		}
		if ( isset( $instance[ 'adapt' ] ) ) {
			$adapt = $instance[ 'adapt' ];
		} else {
			$adapt = 'true';
		}
		if ( isset( $instance[ 'language' ] ) ) {
			$language = $instance[ 'language' ];
		} else {
			$language = '';
		}
		try {
			$lang_xml = file_get_contents('https://www.facebook.com/translations/FacebookLocales.xml');
		}catch(Exception $ex){
			$lang_xml = NULL;
		}
		if(isset($lang_xml) && !empty($lang_xml)){
			$langs = new SimpleXMLElement($lang_xml);
		} else {
			$langs = NULL;
		}
		echo '<p>';
			echo '<label for="' . $this->get_field_id( 'title' ) . '">';
				echo _e( 'Title:' );
			echo '</label>';
			echo '<input class="widefat" id="<?php' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '" />';
		echo '</p>';
        echo '<p>';
        	 echo '<label for="<?php' . $this->get_field_id( 'href' ) . '">';
            	echo _e( 'Page URL:' );
             echo '</label>';
             echo '<input class="widefat" id="' . $this->get_field_id( 'href' ) . '" name="' . $this->get_field_name( 'href' ) . '" type="url" value="' . esc_attr( $href ) . '" required />';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="<?php' . $this->get_field_id( 'width' ) . '">';
            	echo _e( 'Width:' );
             echo '</label>';
             echo '<input class="widefat" id="' . $this->get_field_id( 'width' ) . '" name="' . $this->get_field_name( 'width' ) . '" type="number" min="180" max="500" value="' . esc_attr( $width ) . '" />';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="<?php' . $this->get_field_id( 'height' ) . '">';
            	echo _e( 'Height:' );
             echo '</label>';
             echo '<input class="widefat" id="' . $this->get_field_id( 'height' ) . '" name="' . $this->get_field_name( 'height' ) . '" type="number" min="70" value="' . esc_attr( $height ) . '" />';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="<?php' . $this->get_field_id( 'cover' ) . '">';
            	echo _e( 'Cover Photo:' );
             echo '</label>';
             echo ' <input class="widefat" id="' . $this->get_field_id( 'cover' ) . '" name="' . $this->get_field_name( 'cover' ) . '" type="checkbox" value="true" ' . checked( esc_attr( $cover ), 'true', false ) . ' />';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="<?php' . $this->get_field_id( 'facepile' ) . '">';
            	echo _e( 'Show Facepile:' );
             echo '</label>';
             echo ' <input class="widefat" id="' . $this->get_field_id( 'facepile' ) . '" name="' . $this->get_field_name( 'facepile' ) . '" type="checkbox" value="true" ' . checked( esc_attr( $facepile ), 'true', false ) . ' />';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="<?php' . $this->get_field_id( 'posts' ) . '">';
            	echo _e( 'Show Posts:' );
             echo '</label>';
             echo ' <input class="widefat" id="' . $this->get_field_id( 'posts' ) . '" name="' . $this->get_field_name( 'posts' ) . '" type="checkbox" value="true" ' . checked( esc_attr( $posts ), 'true', false ) . ' />';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="<?php' . $this->get_field_id( 'cta' ) . '">';
            	echo _e( 'Hide Call To Action:' );
             echo '</label>';
             echo ' <input class="widefat" id="' . $this->get_field_id( 'cta' ) . '" name="' . $this->get_field_name( 'cta' ) . '" type="checkbox" value="true" ' . checked( esc_attr( $cta ), 'true', false ) . ' />';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="<?php' . $this->get_field_id( 'small' ) . '">';
            	echo _e( 'Small Header:' );
             echo '</label>';
             echo ' <input class="widefat" id="' . $this->get_field_id( 'small' ) . '" name="' . $this->get_field_name( 'small' ) . '" type="checkbox" value="true" ' . checked( esc_attr( $small ), 'true', false ) . ' />';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="<?php' . $this->get_field_id( 'adapt' ) . '">';
            	echo _e( 'Adaptive Width:' );
             echo '</label>';
             echo ' <input class="widefat" id="' . $this->get_field_id( 'adapt' ) . '" name="' . $this->get_field_name( 'adapt' ) . '" type="checkbox" value="true" ' . checked( esc_attr( $adapt ), 'true', false ) . ' />';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="<?php' . $this->get_field_id( 'language' ) . '">';
            	echo _e( 'Language:' );
             echo '</label>';
             echo '<select class="widefat" id="' . $this->get_field_id( 'language' ) . '" name="' . $this->get_field_name( 'language' ) . '">';
			 	echo '<option value="">Site Lanugage (default)</option>';
				if(isset($langs) && !empty($langs)){
					foreach($langs as $lang){
						echo '<option value="' . $lang->codes->code->standard->representation . '"' . selected( esc_attr( $language ), $lang->codes->code->standard->representation, false ) . '>' . $lang->englishName . '</option>';
					}
				}
			 echo '</select>';
         echo '</p>';
	}
		
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['href'] = ( ! empty( $new_instance['href'] ) ) ? strip_tags( $new_instance['href'] ) : '';
		$instance['width'] = ( ! empty( $new_instance['width'] ) ) ? strip_tags( $new_instance['width'] ) : '';
		$instance['height'] = ( ! empty( $new_instance['height'] ) ) ? strip_tags( $new_instance['height'] ) : '';
		$instance['cover'] = ( ! empty( $new_instance['cover'] ) ) ? strip_tags( $new_instance['cover'] ) : '';
		$instance['facepile'] = ( ! empty( $new_instance['facepile'] ) ) ? strip_tags( $new_instance['facepile'] ) : '';
		$instance['posts'] = ( ! empty( $new_instance['posts'] ) ) ? strip_tags( $new_instance['posts'] ) : '';
		$instance['cta'] = ( ! empty( $new_instance['cta'] ) ) ? strip_tags( $new_instance['cta'] ) : '';
		$instance['small'] = ( ! empty( $new_instance['small'] ) ) ? strip_tags( $new_instance['small'] ) : '';
		$instance['adapt'] = ( ! empty( $new_instance['adapt'] ) ) ? strip_tags( $new_instance['adapt'] ) : '';
		$instance['language'] = ( ! empty( $new_instance['language'] ) ) ? strip_tags( $new_instance['language'] ) : '';
	return $instance;
	}
} // Class wpb_widget ends here

// Register and load the widget
function facebook_page_plugin_load_widget() {
	register_widget( 'facebook_page_plugin_widget' );
}

function facebook_page_plugin_admin_notice() {
	$screen = get_current_screen();
	//Only display on the dashboard, widgets and plugins pages
	if( $screen->base === 'widgets' || $screen->base === 'dashboard' || $screen->base === 'plugins' ){
		global $current_user ;
		$user_id = $current_user->ID;
		if ( !get_user_meta( $user_id, 'facebook_page_plugin_admin_notice_ignore' ) || get_user_meta( $user_id, 'facebook_page_plugin_admin_notice_ignore' ) === false ) {
			echo '<div class="updated" id="facebook-page-plugin-review"><p>Thank you for using the Facebook Page Plugin. If you enjoy using it, please take the time to <a href="https://wordpress.org/support/view/plugin-reviews/facebook-page-feed-graph-api?rate=5#postform" target="_blank">leave a review</a>. Thanks. <a href="?facebook_page_plugin_admin_notice_ignore=0" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></a></p></div>';
		}
	}
}

function facebook_page_plugin_admin_notice_ignore() {
	global $current_user;
    $user_id = $current_user->ID;
    if ( isset($_GET['facebook_page_plugin_admin_notice_ignore']) && '0' == $_GET['facebook_page_plugin_admin_notice_ignore'] ) {
         update_user_meta($user_id, 'facebook_page_plugin_admin_notice_ignore', 'true', true);
	}
}
