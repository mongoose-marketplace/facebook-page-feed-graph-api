<?php
/**
 * Plugin Name: Facebook Page Plugin
 * Plugin URI: https://cameronjonesweb.com.au/projects/facebook-page-plugin
 * Description: It's time to upgrade from your old like box! Display the Facebook Page Plugin from the Graph API using a shortcode or widget. Now available in 95 different languages
 * Version: 1.5.5
 * Author: Cameron Jones
 * Author URI: https://cameronjonesweb.com.au
 * License: GPLv2
 
 * Copyright 2015  Cameron Jones  (email : plugins@cameronjonesweb.com.au)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 */

defined( 'ABSPATH' ) or die();

class cameronjonesweb_facebook_page_plugin {

	public function __construct() {

		define( 'CJW_FBPP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		define( 'CJW_FBPP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		define( 'CJW_FBPP_PLUGIN_VER', '1.5.4' );

		//Add all the hooks and actions
		add_shortcode( 'facebook-page-plugin', array( $this, 'facebook_page_plugin' ) );
		add_filter( 'widget_text', 'do_shortcode' );
		add_action( 'wp_dashboard_setup', array( $this, 'facebook_page_plugin_dashboard_widget' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'facebook_page_plugin_admin_resources' ) );
		add_action( 'admin_notices', array( $this, 'facebook_page_plugin_admin_notice' ) );
		add_action( 'admin_init', array( $this, 'facebook_page_plugin_admin_notice_ignore' ) );
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'facebook_page_plugin_action_links' ) );
	}


	//Admin functions
	//Display review notice
	public function facebook_page_plugin_admin_notice() {
		$screen = get_current_screen();
		//Only display on the dashboard, widgets and plugins pages
		if( $screen->base === 'widgets' || $screen->base === 'dashboard' || $screen->base === 'plugins' ){
			global $current_user ;
			$user_id = $current_user->ID;
			//Don't show if they have hidden it
			if ( !get_user_meta( $user_id, 'facebook_page_plugin_admin_notice_ignore' ) || get_user_meta( $user_id, 'facebook_page_plugin_admin_notice_ignore' ) === false ) {
				echo '<div class="updated" id="facebook-page-plugin-review"><p>';
				echo __( 'Thank you for using the Facebook Page Plugin. If you enjoy using it, please take the time to', 'facebook-page-feed-graph-api' ) . ' <a href="https://wordpress.org/support/view/plugin-reviews/facebook-page-feed-graph-api?rate=5#postform" target="_blank">' . __( 'leave a review', 'facebook-page-feed-graph-api' ) . '</a>. ' . __( 'Thanks', 'facebook-page-feed-graph-api' );
				echo '<a href="?facebook_page_plugin_admin_notice_ignore=0" class="notice-dismiss"><span class="screen-reader-text">' . __( 'Dismiss this notice', 'facebook-page-feed-graph-api' ) . '.</span></a></p></div>';
			}
		}
	}

	//Handler function for when review notice is hidden
	public function facebook_page_plugin_admin_notice_ignore() {
		global $current_user;
	    $user_id = $current_user->ID;
	    if ( isset($_GET['facebook_page_plugin_admin_notice_ignore']) && '0' == $_GET['facebook_page_plugin_admin_notice_ignore'] ) {
	         update_user_meta($user_id, 'facebook_page_plugin_admin_notice_ignore', 'true', true);
		}
	}

	//Add link on plugins page to my plugins directory
	public function facebook_page_plugin_action_links( $links ) {
		$links[] = '<a href="https://profiles.wordpress.org/cameronjonesweb/#content-plugins" target="_blank">More plugins by cameronjonesweb</a>';	
		return $links;
	}

	//Enqueue CSS and JS for admin
	public function facebook_page_plugin_admin_resources() {
		wp_enqueue_script( 'facebook-page-plugin-admin-scripts', CJW_FBPP_PLUGIN_URL . 'js/facebook-page-plugin-admin.js' );
		wp_enqueue_style( 'facebook-page-plugin-admin-styles', CJW_FBPP_PLUGIN_URL . 'css/facebook-page-plugin-admin.css' );
	}

	//Register the dashboard widget
	public function facebook_page_plugin_dashboard_widget() {
		wp_add_dashboard_widget( 'facebook-page-plugin-shortcode-generator', __( 'Facebook Page Plugin Shortcode Generator', 'facebook-page-feed-graph-api' ), array( $this, 'facebook_page_plugin_dashboard_widget_callback' ) );
	}

	//Load the dashboard widget
	function facebook_page_plugin_dashboard_widget_callback() {

		$generator = new cameronjonesweb_facebook_page_plugin_shortcode_generator;
		$generator->generate();
		
	}

	//Client side stuff
	//Parse shortcode
	function facebook_page_plugin( $filter ) {
		wp_enqueue_script( 'facebook-page-plugin-responsive-script', CJW_FBPP_PLUGIN_URL . 'js/responsive.min.js', 'jquery', NULL, true );
		$return = NULL;
		$a = shortcode_atts( array(
	        'href' => NULL,
	        'width' => 340,
			'height' => 130,
			'cover' => NULL,
			'facepile' => NULL,
			'posts' => NULL,
			'tabs' => array(),
			'language' => get_bloginfo('language'),
			'cta' => NULL,
			'small' => NULL,
			'adapt' => NULL,
			'link' => true,
			'linktext' => NULL,
			'standard' => 'html5',
	    ), $filter );
		if(isset($a['href']) && !empty($a['href'])){
			$a['language'] = str_replace("-", "_", $a['language']);
			$return .= '<div class="cameronjonesweb_facebook_page_plugin" data-version="' . CJW_FBPP_PLUGIN_VER . '" id="' . preg_replace("/[^a-zA-Z]+/", "",substr(md5(rand()), 0, 15)) . '">';
			$return .= '<div id="fb-root"></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/' . $a['language'] . '/sdk.js#xfbml=1&version=v2.5&appId=846690882110183";fjs.parentNode.insertBefore(js, fjs);	}(document, \'script\', \'facebook-jssdk\'));</script>';
			$return .= '<div class="fb-page" data-href="https://facebook.com/' . $a["href"] . '" ';
			if(isset($a['width']) && !empty($a['width'])){
				$return .= ' data-width="' . $a['width'] . '"';
				$return .= ' data-max-width="' . $a['width'] . '"';
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
			if(isset($a['tabs']) && !empty($a['tabs'])){
				$return .= ' data-tabs="' . $a['tabs'] . '"';
			} else if(isset($a['posts']) && !empty($a['posts'])){
				if($a['posts'] == 'true'){
					$return .= ' data-tabs="timeline"';
				} else {
					$return .= ' data-tabs="false"';
				}
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
			$return .= '><div class="fb-xfbml-parse-ignore">';
			if( $a['link'] == 'true' ){
				$return .= '<blockquote cite="https://www.facebook.com/' . $a['href'] . '">';
				$return .= '<a href="https://www.facebook.com/' . $a['href'] . '">';
				if( empty( $a['linktext'] ) ) {
					$return .= 'https://www.facebook.com/' . $a['href'];
				} else {
					$return .= $a['linktext'];
				}
				$return .= '</a>';
				$return .= '</blockquote>';
			}
			$return .= '</div></div></div>';
		}
		return $return;
	}

}

class cameronjonesweb_facebook_page_plugin_widget extends WP_Widget {
	
	private $facebookURLs = array('https://www.facebook.com/', 'https://facebook.com/', 'www.facebook.com/', 'facebook.com/');
	
	function __construct() {
		parent::__construct( 'facebook_page_plugin_widget', __( 'Facebook Page Plugin', 'facebook-page-feed-graph-api' ), array( 'description' => __( 'Generates a Facebook Page feed in your widget area', 'facebook-page-feed-graph-api' ), ) 	);
	}
	public function widget( $args, $instance ) {
		if( isset( $instance['title'] ) && !empty( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		} else {
			$title = NULL;
		}
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
		if(isset($instance['tabs']) && !empty($instance['tabs'])){
			$tabs = $instance['tabs'];
		} else {
			$tabs = '';
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
		if(isset($instance['link']) && !empty($instance['link'])){
			$link = 'true';
		} else {
			$link = 'false';
		}
		if(isset($instance['linktext']) && !empty($instance['linktext'])){
			$linktext = $instance['linktext'];
		} else {
			$linktext = NULL;
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
			if( isset( $width ) && !empty( $width ) ){
				$shortcode .= ' width="' . $width . '"';
			}
			if( isset( $height ) && !empty( $height ) ){
				$shortcode .= ' height="' . $height . '"';
			}
			if( isset( $cover ) && !empty( $cover ) ){
				$shortcode .= ' cover="' . $cover . '"';
			}
			if( isset( $facepile ) && !empty( $facepile ) ){
				$shortcode .= ' facepile="' . $facepile . '"';
			}
			if( isset( $tabs ) && !empty( $tabs ) ){
				$shortcode .= ' tabs="' . $tabs . '"';
			}
			if( isset( $language ) && !empty( $language ) ){
				$shortcode .= ' language="' . $language . '"';
			}
			if( isset( $cta ) && !empty( $cta ) ){
				$shortcode .= ' cta="' . $cta . '"';
			}
			if( isset( $small ) && !empty( $small ) ){
				$shortcode .= ' small="' . $small . '"';
			}
			if( isset( $adapt ) && !empty( $adapt ) ){
				$shortcode .= ' adapt="' . $adapt . '"';
			}
			if( isset( $link ) && !empty( $link ) ){
				$shortcode .= ' link="' . $link . '"';
			}
			if( isset( $linktext ) && !empty( $linktext ) ){
				$shortcode .= ' linktext="' . $linktext . '"';
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
			$title = __( 'New title', 'facebook-page-feed-graph-api' );
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
		if ( isset( $instance[ 'tabs' ] ) ) {
			$tabs = $instance[ 'tabs' ];
		} else {
			$tabs = '';
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
		if ( isset( $instance[ 'link' ] ) ) {
			$link = $instance[ 'link' ];
		} else {
			$link = 'true';
		}
		if ( isset( $instance[ 'linktext' ] ) ) {
			$linktext = $instance[ 'linktext' ];
		} else {
			$linktext = '';
		}
		if ( isset( $instance[ 'language' ] ) ) {
			$language = $instance[ 'language' ];
		} else {
			$language = '';
		}

		$langs = get_locale_xml();

		echo '<p>';
			echo '<label for="' . $this->get_field_id( 'title' ) . '">';
				_e( 'Title:', 'facebook-page-feed-graph-api' );
			echo '</label>';
			echo '<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '" />';
		echo '</p>';
        echo '<p>';
        	 echo '<label for="' . $this->get_field_id( 'href' ) . '">';
            	_e( 'Page URL:', 'facebook-page-feed-graph-api' );
             echo '</label>';
             echo '<input class="widefat" id="' . $this->get_field_id( 'href' ) . '" name="' . $this->get_field_name( 'href' ) . '" type="url" value="' . esc_attr( $href ) . '" required />';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="' . $this->get_field_id( 'width' ) . '">';
            	_e( 'Width:', 'facebook-page-feed-graph-api' );
             echo '</label>';
             echo '<input class="widefat" id="' . $this->get_field_id( 'width' ) . '" name="' . $this->get_field_name( 'width' ) . '" type="number" min="180" max="500" value="' . esc_attr( $width ) . '" />';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="' . $this->get_field_id( 'height' ) . '">';
            	_e( 'Height:', 'facebook-page-feed-graph-api' );
             echo '</label>';
             echo '<input class="widefat" id="' . $this->get_field_id( 'height' ) . '" name="' . $this->get_field_name( 'height' ) . '" type="number" min="70" value="' . esc_attr( $height ) . '" />';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="' . $this->get_field_id( 'cover' ) . '">';
            	_e( 'Cover Photo:', 'facebook-page-feed-graph-api' );
             echo '</label>';
             echo ' <input class="widefat" id="' . $this->get_field_id( 'cover' ) . '" name="' . $this->get_field_name( 'cover' ) . '" type="checkbox" value="true" ' . checked( esc_attr( $cover ), 'true', false ) . ' />';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="' . $this->get_field_id( 'facepile' ) . '">';
            	_e( 'Show Facepile:', 'facebook-page-feed-graph-api' );
             echo '</label>';
             echo ' <input class="widefat" id="' . $this->get_field_id( 'facepile' ) . '" name="' . $this->get_field_name( 'facepile' ) . '" type="checkbox" value="true" ' . checked( esc_attr( $facepile ), 'true', false ) . ' />';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="' . $this->get_field_id( 'tabs' ) . '">';
            	_e( 'Page Tabs:', 'facebook-page-feed-graph-api' );
             echo '</label>';
             echo ' <select class="widefat" id="' . $this->get_field_id( 'tabs' ) . '" name="' . $this->get_field_name( 'tabs' ) . ' "><option value="" ' . selected( esc_attr( $tabs ), "", false ) . '>None</option><option value="timeline"' . selected( esc_attr( $tabs ), "timeline", false ) . '>Timeline</option><option value="messages"' . selected( esc_attr( $tabs ), "messages", false ) . '>Messages</option><option value="timeline,messages"' . selected( esc_attr( $tabs ), "timeline,messages", false ) . '>Timeline, Messages</option><option value="messages,timeline"' . selected( esc_attr( $tabs ), "messages,timeline", false ) . '>Messages, Timeline</option></select>';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="' . $this->get_field_id( 'cta' ) . '">';
            	_e( 'Hide Call To Action:', 'facebook-page-feed-graph-api' );
             echo '</label>';
             echo ' <input class="widefat" id="' . $this->get_field_id( 'cta' ) . '" name="' . $this->get_field_name( 'cta' ) . '" type="checkbox" value="true" ' . checked( esc_attr( $cta ), 'true', false ) . ' />';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="' . $this->get_field_id( 'small' ) . '">';
            	_e( 'Small Header:', 'facebook-page-feed-graph-api' );
             echo '</label>';
             echo ' <input class="widefat" id="' . $this->get_field_id( 'small' ) . '" name="' . $this->get_field_name( 'small' ) . '" type="checkbox" value="true" ' . checked( esc_attr( $small ), 'true', false ) . ' />';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="' . $this->get_field_id( 'adapt' ) . '">';
            	_e( 'Adaptive Width:', 'facebook-page-feed-graph-api' );
             echo '</label>';
             echo ' <input class="widefat" id="' . $this->get_field_id( 'adapt' ) . '" name="' . $this->get_field_name( 'adapt' ) . '" type="checkbox" value="true" ' . checked( esc_attr( $adapt ), 'true', false ) . ' />';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="' . $this->get_field_id( 'link' ) . '">';
            	_e( 'Display link while loading:', 'facebook-page-feed-graph-api' );
             echo '</label>';
             echo ' <input class="widefat" id="' . $this->get_field_id( 'link' ) . '" name="' . $this->get_field_name( 'link' ) . '" type="checkbox" value="true" ' . checked( esc_attr( $link ), 'true', false ) . ' />';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="' . $this->get_field_id( 'linktext' ) . '">';
            	_e( 'Link text:', 'facebook-page-feed-graph-api' );
             echo '</label>';
             echo '<input class="widefat" id="' . $this->get_field_id( 'linktext' ) . '" name="' . $this->get_field_name( 'linktext' ) . '" type="text" value="' . esc_attr( $linktext ) . '" />';
         echo '</p>';
		 echo '<p>';
        	 echo '<label for="' . $this->get_field_id( 'language' ) . '">';
            	_e( 'Language:', 'facebook-page-feed-graph-api' );
             echo '</label>';
             echo '<select class="widefat" id="' . $this->get_field_id( 'language' ) . '" name="' . $this->get_field_name( 'language' ) . '">';
			 	echo '<option value="">' . __( 'Site Language (default)', 'facebook-page-feed-graph-api' ) . '</option>';
				if(isset($langs) && !empty($langs)){
					foreach($langs as $lang){
						//echo '<option value="' . $lang->codes->code->standard->representation . '"' . selected( esc_attr( $language ), $lang->codes->code->standard->representation, false ) . '>' . __( $lang->englishName, 'facebook-page-feed-graph-api' ) . '</option>'; // Facebook only
						echo '<option value="' . $lang->standard->representation . '"' . selected( esc_attr( $language ), $lang->standard->representation, false ) . '>' . __( $lang->englishName, 'facebook-page-feed-graph-api' ) . '</option>';
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
		$instance['tabs'] = ( ! empty( $new_instance['tabs'] ) ) ? strip_tags( $new_instance['tabs'] ) : '';
		$instance['cta'] = ( ! empty( $new_instance['cta'] ) ) ? strip_tags( $new_instance['cta'] ) : '';
		$instance['small'] = ( ! empty( $new_instance['small'] ) ) ? strip_tags( $new_instance['small'] ) : '';
		$instance['adapt'] = ( ! empty( $new_instance['adapt'] ) ) ? strip_tags( $new_instance['adapt'] ) : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';
		$instance['linktext'] = ( ! empty( $new_instance['linktext'] ) ) ? strip_tags( $new_instance['linktext'] ) : '';
		$instance['language'] = ( ! empty( $new_instance['language'] ) ) ? strip_tags( $new_instance['language'] ) : '';
	return $instance;
	}
} // Class wpb_widget ends here

class cameronjonesweb_facebook_page_plugin_shortcode_generator {

	private $langs;
	
	function __construct() {

		$this->langs = get_locale_xml();
	}

	function generate() {
		
		$return = NULL;

		$return .= '<form>';
			$return .= '<p><label>' . __( 'Facebook Page URL', 'facebook-page-feed-graph-api' ) . ': <input type="url" id="fbpp-href" /></label></p>';
			$return .= '<p><label>' . __( 'Width (pixels)', 'facebook-page-feed-graph-api' ) . ': <input type="number" max="500" min="180" id="fbpp-width" /></label></p>';
			$return .= '<p><label>' . __( 'Height (pixels)', 'facebook-page-feed-graph-api' ) . ': <input type="number" min="70" id="fbpp-height" /></label></p>';
			$return .= '<p><label>' . __( 'Show Cover Photo', 'facebook-page-feed-graph-api' ) . ': <input type="checkbox" value="true" id="fbpp-cover" /></label></p>';
			$return .= '<p><label>' . __( 'Show Facepile', 'facebook-page-feed-graph-api' ) . ': <input type="checkbox" value="true" id="fbpp-facepile" /></label></p>';
			$return .= '<p><label>' . __( 'Page Tabs (formerly posts)', 'facebook-page-feed-graph-api' ) . ': <select id="fbpp-tabs"><option value="">None</option><option value="timeline">Timeline</option><option value="messages">Messages</option><option value="timeline,messages">Timeline, Messages</option><option value="messages,timeline">Messages, Timeline</option></select></label></p>';
			$return .= '<p><label>' . __( 'Hide Call To Action', 'facebook-page-feed-graph-api' ) . ': <input type="checkbox" value="true" id="fbpp-cta" /></label></p>';
			$return .= '<p><label>' . __( 'Small Header', 'facebook-page-feed-graph-api' ) . ': <input type="checkbox" value="true" id="fbpp-small" /></label></p>';
			$return .= '<p><label>' . __( 'Adaptive Width', 'facebook-page-feed-graph-api' ) . ': <input type="checkbox" value="true" id="fbpp-adapt" checked /></label></p>';
			$return .= '<p><label>' . __( 'Display link while loading', 'facebook-page-feed-graph-api' ) . ': <input type="checkbox" value="true" id="fbpp-link" checked /></label></p>';
			$return .= '<p id="linktext-label"><label>' . __( 'Link text', 'facebook-page-feed-graph-api' ) . ': <input type="text" id="fbpp-linktext" /></label></p>';
			$return .= '<p><label>' . __( 'Language', 'facebook-page-feed-graph-api' ) . ': <select id="fbpp-lang"><option value="">' . __( 'Site Language', 'facebook-page-feed-graph-api' ) . '</option>';
			if(isset($this->langs) && !empty($this->langs)){
				foreach($this->langs as $lang){
					$return .= '<option value="' . $lang->standard->representation . '">' . __( $lang->englishName, 'facebook-page-feed-graph-api' ) . '</option>';
				}
			}
			$return .= '</select></label></p>';
			$return .= '<input type="text" readonly="readonly" id="facebook-page-plugin-shortcode-generator-output" onfocus="this.select()" />';
		$return .= '</form>';

		echo $return;
	}
}

//Register the widget
function facebook_page_plugin_load_widget() {
	register_widget( 'cameronjonesweb_facebook_page_plugin_widget' );
}
add_action( 'widgets_init', 'facebook_page_plugin_load_widget' );

function get_locale_xml() {

	$admin_abspath = str_replace( site_url(), ABSPATH, admin_url() );

	include_once( $admin_abspath . '/includes/class-wp-filesystem-base.php' );
	include_once( $admin_abspath . '/includes/class-wp-filesystem-direct.php' );
	$wp_filesystem = new WP_Filesystem_Direct( null );

	try {
    	//$xml = file_get_contents('https://www.facebook.com/translations/FacebookLocales.xml');
		//$xml = file_get_contents( CJW_FBPP_PLUGIN_URL ) . 'lang.xml');
		$lang_xml = $wp_filesystem->get_contents( CJW_FBPP_PLUGIN_DIR . '/lang.xml');
	} catch( Exception $ex ){
		$lang_xml = NULL;
	}

	if(isset($lang_xml) && !empty($lang_xml)){
    	$langs = new SimpleXMLElement($lang_xml);
	} else {
		$langs = NULL;
	}

	return $langs;
}

$cameronjonesweb_facebook_page_plugin = new cameronjonesweb_facebook_page_plugin;