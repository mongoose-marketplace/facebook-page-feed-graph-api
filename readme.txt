=== Facebook Page Plugin ===
Contributors: cameronjonesweb
Tags: facebook,social,like,facepile,activity feed,recommendations,shortcode,widget,shortcode generator,plugin,admin,sidebar,facebook page,multilingual,like box,facebook like box
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=WLV5HPHSPM2BG&lc=AU&item_name=Cameron%20Jones%20Web%20Development¤cy_code=AUD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Requires at least: 4.0
Tested up to: 4.2.2
Stable tag: 1.3.1
License: GPLv2
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html

It's time to upgrade from your old like box! Display the Facebook Page Plugin from the Graph API using a shortcode or widget.

== Description ==
As of June 23rd 2015, Facebook **has now deprecated many of their old social plugins**, including Activity Feed, Facepile, Like Box and Recommendations. As such, many WordPress plugins that utilise these social plugins will soon stop working. This plugin instead uses the Graph API v2.3 to guarantee your WordPress site continues to have full Facebook support.

This plugin can be used by added the widget to a widget area and filling out the form, or by using the `[facebook-page-plugin]` shortcode to display the plugin wherever you like, as often as you like.

Features:

* Add your Facebook page to any widget area with the custom Facebook Page Plugin widget

* Add your Facebook page to any page content or text widget area using the shortcode

* Includes a shortcode generator on the admin dashboard for easy generating of the shortcode

* Uses your site language by default, but you can display your Facebook page in all 136 languages that Facebook supports, including English, Spanish, Arabic, German, French, Russian and many more

If you like the plugin, please take the time to leave a review.

== Installation ==

= From your WordPress dashboard =

1. Click `Add New` from the plugins page in your wordpress site
2. Search for `Facebook Page Plugin`
3. Click on install

= Alternatively from wordpress.org =

1. Download the latest version of Facebook Page Plugin
2. Extract the files
3. Upload the entire `facebook-page-feed-graph-api` folder to the `/wp-content/plugins/` directory.

4. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==
= How do I use the plugin? =
As of version 1.2.0, a custom widget has been included. If you wish to display your Facebook Page Plugin in a widget area it is recommended that you use the widget. Simply drag and drop the widget into the widget area and fill out the form.

If you require a shortcode, it is recommended that you use the shortcode generator on your site dashboard. Simply fill in the relevant information and then copy the generated shortcode and paste in the post or widget area where you want the plugin to appear.

The Facebook Page Plugin uses a shortcode to insert the page feed. You set your settings within the shortcode.
`[facebook-page-plugin setting="value"]` 
Available settings: 

`href` (URL path that comes after facebook.com/)

`width` (number, in pixels, between 180 and 500, default 340)

`height` (number, in pixels, minimum 70, default 500)

`cover` (true/false, show page cover photo, default true)

`facepile` (true/false, show facepile, default true)

`posts` (true/false, display page posts, default false)

`cta` (true/false, hide custom call to action if applicable, default false)

`small` (true/false, display small header (must be true for height to be lower than 130px), default false)

`adapt` (true/false, force plugin to be responsive, default true)

`language` (languageCode_countryCode eg: en_US, language of the plugin, default site language)

Example: `[facebook-page-plugin href="facebook" width="300" height="500" cover="true" facepile="true" posts="true"]`
This will display a Facebook page feed that loads in the page `facebook.com/facebook` that is 300px wide, 500px high, displaying the page's cover photo, facepile and recent posts in the same language as the site. See the screenshots tab for a demonstration of how it will appear

= What languages are available? =
As of version 1.2.0, the plugin is available in all languages provided by Facebook ( full list availabe [here](https://www.facebook.com/translations/FacebookLocales.xml) ). By default it uses the same language as the site, but alternatively you can specify the language in the shortcode. The dashboard widget is only available in English.

= My Facebook page isn't loading =
If the URL for your page is http://facebook.com/ABC123 then when you use the shortcode don't include the domain, instead use like so: `[facebook-page-plugin href="ABC123"]`
Also, if your page has only just been created it may take some time for the API to load the page. Just be patient

= What versions of WordPress will this plugin work on? =
Shortcodes were introduced in WordPress 2.5, so theorectially it should work on all sites that are at least 2.5, however it has only been tested on versions 4.0 and up, and no guarantee will be made concerning earlier versions

== Screenshots ==
1. Installation example
2. Example of the new widget introduced in version 1.2.0
3. The new shortcode generator dashboard widget

== Changelog ==
= 1.3.0 =
* Added hide-cta, small-header and adapt-container-width settings
* Adjusted min height and width
= 1.2.5 =
* Fixed close icon on notice
= 1.2.4 =
* Fixed readme
= 1.2.3 =
* Fixed bug where the admin dashboard and widgets pages would break if the WordPress installation is running on localhost and there is no internet connection
= 1.2.2 =
* Fixed posts option for widget
= 1.2.1 =
* Fixed readme bug
= 1.2.0 =
* Added multilingual support. Language can be specified in the shortcode, otherwise it is retrievd from the site settings.
* Added a shortcode generator dashboard widget to allow easier creation of the shortcode
* Added a custom widget
= 1.1.1 =
* Fixed height bug
= 1.1.0 =
* Added filter to allow calling of shortcodes in the text widget
= 1.0.3 =
* Fixing screenshot issue
= 1.0.1 =
* Cleaning up readme file
= 1.0 =
* Initial release

== Upgrade Notice ==
= 1.3.0 =
This version adds new settings. Please update for the best possible experience.
= 1.2.3 =
This version fixes a bug where the admin dashboard and widgets pages would break if the WordPress installation is running on localhost and there is no internet connection. While not imperative to most sites it is recommeded that you update if you work on a localhost or virtual machine
= 1.2.2 =
This version addresses a fix for the posts option not working in the widget. Please update immediately.
= 1.2.0 =
This version includes multilingual support, a custom widget and a shortcode generator on the admin dashboard. It is highly recommeded that you update.
= 1.1.1 =
Fixed height bug where height would only ever be the same value as width. Update immediately.
= 1.1.0 =
Added filter to allow calling of shortcodes in the text widget
= 1.0.0 =
Initial release