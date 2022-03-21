<?php
/**
 * Plugin Name: Mongoose Page Plugin
 * Plugin URI: https://mongoosemarketplace.com/downloads/facebook-page-plugin/
 * Description: The most popular way to display the Facebook Page Plugin on your WordPress website. Easy implementation using a shortcode or widget. Now available in 95 different languages
 * Version: 1.8.3
 * Author: Mongoose Marketplace
 * Author URI: https://mongoosemarketplace.com/
 * License: GPLv2
 * Text Domain: facebook-page-feed-graph-api
 *
 * @package facebook-page-feed-graph-api
 */

/*
Copyright 2015-2019  Cameron Jones  (email : support@mongoosemarketplace.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Pulls in the main plugin class.
 */
require_once 'inc/class-mongoose-page-plugin.php';
Mongoose_Page_Plugin::get_instance();

/**
 * Register activation hook
 */
add_action( 'activated_plugin', array( Mongoose_Page_Plugin::get_instance(), 'activate' ) );
