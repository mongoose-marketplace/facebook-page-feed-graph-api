<?php
/**
 * Plugin Name: Facebook Page Plugin
 * Plugin URI: https://cameronjonesweb.com.au/wordpress-plugins/facebook-page-plugin/
 * Description: It's time to upgrade from your old like box! Display the Facebook Page Plugin from the Graph API using a shortcode or widget. Now available in 95 different languages
 * Version: 1.6.1
 * Author: Cameron Jones
 * Author URI: https://cameronjonesweb.com.au
 * License: GPLv2
 * Text Domain: facebook-page-feed-graph-api
 
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

	public static $remove_donate_notice_key = 'facebook_page_plugin_donate_notice_ignore';

	public function __construct() {

		define( 'CJW_FBPP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		define( 'CJW_FBPP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		define( 'CJW_FBPP_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
		define( 'CJW_FBPP_PLUGIN_VER', '1.6.1' );
		define( 'CJW_FBPP_PLUGIN_DONATE_LINK', 'https://www.patreon.com/cameronjonesweb' );
		define( 'CJW_FBPP_PLUGIN_SURVEY_LINK', 'https://cameronjonesweb.typeform.com/to/BllbYm' );

		//Add all the hooks and actions
		add_shortcode( 'facebook-page-plugin', array( $this, 'facebook_page_plugin' ) );
		add_filter( 'widget_text', 'do_shortcode' );
		add_action( 'wp_dashboard_setup', array( $this, 'facebook_page_plugin_dashboard_widget' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'facebook_page_plugin_admin_resources' ) );
		add_action( 'admin_init', array( $this, 'remove_donate_notice_nojs' ) );
		add_action( 'admin_menu', array( $this, 'facebook_page_plugin_landing_page_menu' ) );
		add_action( 'wp_ajax_facebook_page_plugin_latest_blog_posts_callback', array( $this, 'facebook_page_plugin_latest_blog_posts_callback' ) );
		add_action( 'wp_ajax_facebook_page_plugin_other_plugins_callback', array( $this, 'facebook_page_plugin_other_plugins_callback' ) );
		add_action( 'activated_plugin', array( $this, 'facebook_page_plugin_activation_hook' ) );
		add_action( 'wp_ajax_facebook_page_plugin_remove_donate_notice', array( $this, 'remove_donate_notice' ) );
		add_filter( 'plugin_action_links_' . CJW_FBPP_PLUGIN_BASENAME, array( $this, 'plugin_action_links' ) );
		add_filter( 'plugin_row_meta', array( $this, 'plugin_meta_links' ), 10, 2 );

	}


	// Filter functions
	private static function dashboard_widget_capability() {

		$return = apply_filters( 'facebook_page_plugin_dashboard_widget_capability', 'edit_posts' );
		return $return;

	}


	private static function app_id() {

		$return = apply_filters( 'facebook_page_plugin_app_id', '846690882110183' );
		return $return;

	}


	//Admin functions

	public static function donate_notice() {

		$return = NULL;

		if( current_user_can( 'administrator' ) ) {

			$user_id = get_current_user_id();

			if ( !get_user_meta( $user_id, self::$remove_donate_notice_key ) || get_user_meta( $user_id, self::$remove_donate_notice_key ) === false ) {

				$return .= '<div class="facebook-page-plugin-donate"><p>';

					$return .= __( 'Thank you for using the Facebook Page Plugin. Please consider donating to support ongoing development. ', 'facebook-page-feed-graph-api' );

					$return .= '</p><p>';

					$return .= '<a href="' . CJW_FBPP_PLUGIN_DONATE_LINK . '" target="_blank" class="button button-secondary">' . __( 'Donate now', 'facebook-page-feed-graph-api' ) . '</a>';

					$return .= '<a href="?' . self::$remove_donate_notice_key . '=0" class="notice-dismiss facebook-page-plugin-donate-notice-dismiss" title="' . __( 'Dismiss this notice', 'facebook-page-feed-graph-api' ) . '"><span class="screen-reader-text">' . __( 'Dismiss this notice', 'facebook-page-feed-graph-api' ) . '.</span></a>';

				$return .= '</p></div>';

			}

		}

		return $return;

	}

	public static function remove_donate_notice() {

		$user_id = get_current_user_id();

		update_user_meta( $user_id, self::$remove_donate_notice_key, 'true', true );

		if( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

			wp_die();

		}

	}

	public function remove_donate_notice_nojs() {

		if ( isset( $_GET[self::$remove_donate_notice_key] ) && '0' == $_GET[self::$remove_donate_notice_key] ) {

			self::remove_donate_notice();

		}

	}


	// Add a link to support on plugins listing
	function plugin_action_links( $links ) {

		$links[] = '<a href="https://wordpress.org/support/plugin/facebook-page-feed-graph-api" target="_blank">Support</a>';	
		return $links;
	}

	//Add link on plugins listing to my plugins directory
	function plugin_meta_links( $links, $file ) {

		if ( $file == CJW_FBPP_PLUGIN_BASENAME ) {

			$links[] = '<a href="https://profiles.wordpress.org/cameronjonesweb/#content-plugins" target="_blank">More plugins by cameronjonesweb</a>';

		}
		
		return $links;

	}


	//Enqueue CSS and JS for admin
	public function facebook_page_plugin_admin_resources() {

		wp_enqueue_script( 'facebook-page-plugin-admin-scripts', CJW_FBPP_PLUGIN_URL . 'js/facebook-page-plugin-admin.js' );
		wp_enqueue_style( 'facebook-page-plugin-admin-styles', CJW_FBPP_PLUGIN_URL . 'css/facebook-page-plugin-admin.css' );

	}

	//Register the dashboard widget
	public function facebook_page_plugin_dashboard_widget() {

		if( current_user_can( self::dashboard_widget_capability() ) ) {
		
			wp_add_dashboard_widget( 'facebook-page-plugin-shortcode-generator', __( 'Facebook Page Plugin Shortcode Generator', 'facebook-page-feed-graph-api' ), array( $this, 'facebook_page_plugin_dashboard_widget_callback' ) );

		}

	}

	//Load the dashboard widget
	function facebook_page_plugin_dashboard_widget_callback() {
		echo '<a name="cameronjonesweb_facebook_page_plugin_shortcode_generator"></a>';
		$generator = new cameronjonesweb_facebook_page_plugin_shortcode_generator;
		$generator->generate();
		
	}

	function facebook_page_plugin_landing_page_menu() {
	    add_submenu_page( 'plugins.php', __( 'Facebook Page Plugin by cameronjonesweb', 'facebook-page-feed-graph-api' ), 'Facebook Page Plugin', 'install_plugins', 'facebook-page-plugin', array( $this, 'facebook_page_plugin_landing_page' ) );
	}

	function facebook_page_plugin_landing_page() {

		wp_enqueue_script( 'facebook-page-plugin-landing-page', CJW_FBPP_PLUGIN_URL . 'js/landing-page.js', array( 'jquery' ), NULL, true );
		include CJW_FBPP_PLUGIN_DIR . '/inc/landing-page.php';

	}

	/*
	 * http://stackoverflow.com/a/4860432/1672694
	 */

	function facebook_page_plugin_is_connected() {
	    $connected = @fsockopen( "cameronjonesweb.com.au", 80 ); 
	    if( $connected ){
	        $is_conn = true; //action when connected
	        fclose( $connected );
	    } else {
	        $is_conn = false; //action in connection failure
	    }
	    return $is_conn;
	}

	function facebook_page_plugin_latest_blog_posts_callback() {
		$internet = $this->facebook_page_plugin_is_connected();
		if( $internet ) {
			$feed = 'https://cameronjonesweb.com.au/feed/';
			$xml = simplexml_load_file( $feed, 'SimpleXMLElement', LIBXML_NOCDATA );
			if( isset( $xml ) && !empty( $xml ) ) {
				echo '<ul>';
				foreach( $xml->channel->item as $blogpost ) {
					echo '<li>';
						echo date( 'M jS', strtotime( $blogpost->pubDate ) ) . ' - ';
						echo '<a href="' . $blogpost->link . '">';
							echo $blogpost->title;
						echo '</a>';
					echo '</li>';
				}
				echo '</ul>';
				echo '<p><a href="https://cameronjonesweb.com.au/blog/" target="_blank">' . __( 'View more recent posts', 'facebook-page-feed-graph-api' ) . '</a></p>';
			}
		} else {
			echo '<p><strong>' . __( 'No posts found.', 'facebook-page-feed-graph-api' ) . '</strong>' . __( 'Check your connection.', 'facebook-page-feed-graph-api' ) . '</p>';
		}
		wp_die();
	}

	function facebook_page_plugin_other_plugins_callback() {
		$internet = $this->facebook_page_plugin_is_connected();
		if ( ! function_exists( 'plugins_api' ) ){
			require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
		}
		if( $internet ) {
			$plugins = plugins_api( 'query_plugins', array( 
				'author' => 'cameronjonesweb', 'fields' => array(
					'active_installs' => true,
					'description' => false,
					'icons' => true,
				) 
			) );
			if( isset( $plugins ) && !empty( $plugins ) ) {
				echo '<div>';
					for( $i = 0; $i < count( $plugins->plugins ); $i++ ) {
						if( $plugins->plugins[$i]->slug != 'facebook-page-feed-graph-api' ) {
							echo '<div class="plugin-card">';
								echo '<div class="plugin-card-top">';
									if( !empty( $plugins->plugins[$i]->icons['1x'] ) ) {
										echo '<img src="' . $plugins->plugins[$i]->icons['1x'] . '" alt="' . $plugins->plugins[$i]->name . ' Icon" />';
									}
									echo '<h4><strong>' . __( $plugins->plugins[$i]->name, 'facebook-page-feed-graph-api' ) . '</strong></h4>';
									echo '<p>' . _e( $plugins->plugins[$i]->short_description, 'facebook-page-feed-graph-api' ) . '</p>';
									echo '<p><a href="' . self_admin_url() . 'plugin-install.php?tab=plugin-information&plugin=' . $plugins->plugins[$i]->slug . '&TB_iframe=true&width=600&height=550" class="open-plugin-details-modal button" target="_blank" aria-label="More information about ' . __( $plugins->plugins[$i]->name, 'facebook-page-feed-graph-api' ) . '" data-title="' . __( $plugins->plugins[$i]->name, 'facebook-page-feed-graph-api' ) . '">' . __( 'Details &amp; Install', 'facebook-page-feed-graph-api' ) . '</a></p>';
								echo '</div>';
							echo '</div>';
						}
					}
					echo '<div class="clear"></div>';
				echo '</div>';
			} else {
				_e( 'No additional plugins available at this time.', 'facebook-page-feed-graph-api' );
			}
		} else {
			echo '<p><strong>' . __( 'No plugins found.', 'facebook-page-feed-graph-api' ) . '</strong> ' . __( 'Check your connection.', 'facebook-page-feed-graph-api' ) . '</p>';
		}
		wp_die();
	}

	function facebook_page_plugin_activation_hook( $plugin ) {
		if( $plugin == CJW_FBPP_PLUGIN_BASENAME ) {
	        exit( wp_redirect( admin_url( 'plugins.php?page=facebook-page-plugin' ) ) );
	    }
	}


	//Client side stuff
	function facebook_page_plugin_generate_wrapper_id() {
		return substr( str_shuffle( str_repeat( implode( '', array_merge( range( 'A', 'Z' ), range( 'a', 'z' ) ) ), 5 ) ), 0, 15 );
	}

	//Parse shortcode
	function facebook_page_plugin( $filter ) {
		wp_enqueue_script( 'facebook-page-plugin-sdk', CJW_FBPP_PLUGIN_URL . 'js/sdk.js', array(), NULL, true );
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
			'_implementation' => 'shortcode'
	    ), $filter );
		if(isset($a['href']) && !empty($a['href'])){
			$a['language'] = str_replace("-", "_", $a['language']);

			//Send the language as a parameter to the SDK
			wp_localize_script( 'facebook-page-plugin-sdk', 'facebook_page_plugin_language', array( 'language' => $a['language'] ) );

			$return .= '<div class="cameronjonesweb_facebook_page_plugin" data-version="' . CJW_FBPP_PLUGIN_VER . '" data-implementation="' . esc_attr( $a['_implementation'] ) . '" id="' . $this->facebook_page_plugin_generate_wrapper_id() . '">';
			$return .= '<div id="fb-root"></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/' . $a['language'] . '/sdk.js#xfbml=1&version=v2.5&appId=' . self::app_id() . '";fjs.parentNode.insertBefore(js, fjs);	}(document, \'script\', \'facebook-jssdk\'));</script>';
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
	private $settings;
	
	function __construct() {
		 $this->settings = new facebook_page_plugin_settings;
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
				if( is_array( $tabs ) ) {
					$shortcode .= ' tabs="';
					for( $i = 0; $i < count( $tabs ); $i++ ) {
						$shortcode .= $tabs[$i];
						$shortcode .= ( $i != count( $tabs ) - 1 ? ',' : '' );
					}
					$shortcode .= '"';
				} else {
					$shortcode .= ' tabs="' . $tabs . '"';
				}
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
			$shortcode .= ' _implementation="widget"';
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

		$langs = $this->settings->get_locale_xml();

		echo cameronjonesweb_facebook_page_plugin::donate_notice();

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
        	_e( 'Page Tabs:', 'facebook-page-feed-graph-api' );
        	$CJW_FBPP_TABS = $this->settings->tabs();
            if( !empty( $CJW_FBPP_TABS ) ) {
             	// First we should convert the string to an array as that's how it will be stored moving forward.
             	if( !is_array( $tabs ) ) {
	             	$oldtabs = esc_attr( $tabs );
	             	$newtabs = explode( ',', $tabs );
	             	$tabs = $newtabs;
	             }
             	foreach( $CJW_FBPP_TABS as $tab ) {
             		echo '<br/><label>';
             			echo '<input type="checkbox" name="' . $this->get_field_name( 'tabs' ) . '[' . $tab . ']" ' . ( in_array( $tab, $tabs ) ? 'checked' : '' ) . ' /> ';
             			_e( ucfirst( $tab ), 'facebook-page-feed-graph-api' );
             		echo '</label>';
             	}
        	}
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
		if( !empty( $new_instance['tabs'] ) ) {
			if( is_array( $new_instance['tabs'] ) ) {
				foreach( $new_instance['tabs'] as $key => $var ) {
					$instance['tabs'][] = sanitize_text_field( $key );
				}
			}
		} else {
			$instance['tabs'] = '';
		}
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
	private $settings;
	
	function __construct() {

		$this->settings = new facebook_page_plugin_settings;
		$this->langs = $this->settings->get_locale_xml();
	}

	function generate() {
		
		$return = NULL;

		$return .= cameronjonesweb_facebook_page_plugin::donate_notice();

		$return .= '<noscript>' . __( 'The shortcode generator requires JavaScript enabled', 'facebook-page-feed-graph-api' ) . '</noscript>';

		$return .= '<form>';
			$return .= '<p><label>' . __( 'Facebook Page URL', 'facebook-page-feed-graph-api' ) . ': <input type="url" id="fbpp-href" /></label></p>';
			$return .= '<p><label>' . __( 'Width (pixels)', 'facebook-page-feed-graph-api' ) . ': <input type="number" max="500" min="180" id="fbpp-width" /></label></p>';
			$return .= '<p><label>' . __( 'Height (pixels)', 'facebook-page-feed-graph-api' ) . ': <input type="number" min="70" id="fbpp-height" /></label></p>';
			$return .= '<p><label>' . __( 'Show Cover Photo', 'facebook-page-feed-graph-api' ) . ': <input type="checkbox" value="true" id="fbpp-cover" /></label></p>';
			$return .= '<p><label>' . __( 'Show Facepile', 'facebook-page-feed-graph-api' ) . ': <input type="checkbox" value="true" id="fbpp-facepile" /></label></p>';
			$return .= '<p><label>' . __( 'Page Tabs (formerly posts)', 'facebook-page-feed-graph-api' ) . ':';
			$settings = new facebook_page_plugin_settings;
        	$CJW_FBPP_TABS = $settings->tabs();
			if( !empty( $CJW_FBPP_TABS ) ) {
				foreach( $CJW_FBPP_TABS as $tab ) {
	         		$return .= '<br/><label>';
	         			$return .= '<input type="checkbox" class="fbpp-tabs" name="' . $tab . '" /> ';
	         			$return .= __( ucfirst( $tab ), 'facebook-page-feed-graph-api' );
	         		$return .= '</label>';
	         	}
	         }
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

class facebook_page_plugin_settings {

	public $tabs;

	function __construct() {
		$this->tabs = array( 'timeline', 'events', 'messages' );
	}

	function tabs() {
		return $this->tabs;
	}

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

}

//Register the widget
function facebook_page_plugin_load_widget() {
	register_widget( 'cameronjonesweb_facebook_page_plugin_widget' );
}
add_action( 'widgets_init', 'facebook_page_plugin_load_widget' );

$cameronjonesweb_facebook_page_plugin = new cameronjonesweb_facebook_page_plugin;