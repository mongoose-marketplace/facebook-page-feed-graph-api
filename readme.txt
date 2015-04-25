=== Facebook Page Plugin ===
Contributors: cameronjonesweb
Tags: facebook,social,like,facepile,activity feed,recommendations,shortcode
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=WLV5HPHSPM2BG&lc=AU&item_name=Cameron%20Jones%20Web%20Development¤cy_code=AUD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Requires at least: 4.0
Tested up to: 4.1.2
Stable tag: trunk
License: GPLv2
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html

Display the Facebook Page Plugin from the Graph API.

== Description ==
Facebook are depreciating many of their old social plugins on June 23rd 2015, including Activity Feed, Facepile, Like Box and Recommendations. As such, many WordPress plugins that utilise these social plugins will soon stop working. This plugin instead uses the Graph API v2.3 to guarantee your WordPress site continues to have full Facebook support.

This plugin is shortcode based, unlike many other Facebook social plugins that are available. Simply call the [facebook-page-plugin] shortcode and set your settings within the shortcode. Place it wherever you like, as often as you like.

== Installation ==
1. Upload the entire `facebook-page-feed-graph-api` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
Usage: [facebook-page-plugin setting=\"value\"]. 
Available settings: 
href (URL path that comes after facebook.com/)
width (number, in pixels, default 340)
height (number, in pixels, default 500)
cover (true/false, show page cover photo, default true)
facepile (true/false, show facepile, default true)
posts (true/false, display page posts, default false)
Example: [facebook-page-plugin href=\"facebook\" width=\"300\" height=\"500\" cover=\"true\" facepile=\"true\" posts=\"true\"]

== Frequently Asked Questions ==
= What languages are available? =
English.

= My Facebook page isn\'t loading =
If the URL for your page is http://facebook.com/ABC123 then when you use the shortcode don\'t include the domain, instead use like so: [facebook-page-plugin href=\"ABC123\"]
Also, if your page has only just been created it may take some time for the API to load the page. Just be patient

== Screenshots ==
1. Installation example

== Changelog ==
= 1.0 =
* Initial release

== Upgrade Notice ==
= 1.0 =
Initial release