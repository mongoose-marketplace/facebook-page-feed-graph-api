=== Facebook Page Plugin ===
Contributors: cameronjonesweb
Tags: facebook,social,like,facepile,activity feed,recommendations,shortcode,widget,shortcode generator,plugin,admin,sidebar,facebook page,multilingual,like box,facebook like box,facebook page plugin, facebook feed, facebook plugin
Donate link: https://www.patreon.com/cameronjonesweb
Requires at least: 4.0
Tested up to: 4.7.1
Stable tag: trunk
License: GPLv2
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html

It's time to upgrade from your old like box! Display the Facebook Page Plugin from the Graph API using a shortcode or widget.

== Description ==
As of June 23rd 2015, Facebook **has now deprecated many of their old social plugins**, including Activity Feed, Facepile, Like Box and Recommendations. As such, many WordPress plugins that utilise these social plugins will soon stop working. This plugin instead uses the Graph API v2.3 to guarantee your WordPress site continues to have full Facebook support.

This plugin can be used by adding the widget to a widget area and filling out the form, or by using the `[facebook-page-plugin]` shortcode to display the plugin wherever you like, as often as you like.

Features:

* Add your Facebook page to any widget area with the custom Facebook Page Plugin widget

* Add your Facebook page to any page content or text widget area using the shortcode

* Includes a shortcode generator on the admin dashboard for easy generating of the shortcode

* Uses your site language by default, but you can display your Facebook page in all 95 languages that Facebook supports, including English, Spanish, Arabic, German, French, Russian and many more

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
= What happened to "Show Posts"? =
The latest version of the API has removed show posts and replaced it with `tabs` which is more dynamic. To show just the posts, your tabs value should be "timeline". To hide the posts, `tabs` should be empty (shortcode) or select "none" (widget). If you're using the shortcode, remember that by default it shows the timeline so you must set it as either an empty or false value to hide posts ie `tabs=""` or `tabs="false"`. If the posts option is already being used it will be converted to tabs.

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

`tabs` (timeline,messages or a combination of both, display page posts and/or private messages between the page and the logged in user viewing the page, default timeline)

`cta` (true/false, hide custom call to action if applicable, default false)

`small` (true/false, display small header (must be true for height to be lower than 130px), default false)

`adapt` (true/false, force plugin to be responsive, default true)

`language` (languageCode_countryCode eg: en_US, language of the plugin, default site language)

* Deprecated Settings *

`posts` (true/false) - posts has been replaced by tabs as of 1.4.0. There is a fallback in place to convert it to tabs

Example: `[facebook-page-plugin href="facebook" width="300" height="500" cover="true" facepile="true" tabs="timeline" adapt="true"]`
This will display a Facebook page feed that loads in the page `facebook.com/facebook` that is 300px wide but adapts to it's container, 500px high, displaying the page's cover photo, facepile and recent posts in the same language as the site. See the screenshots tab for a demonstration of how it will appear

= What languages are available? =
As of version 1.2.0, the plugin is available in all languages provided by Facebook ( full list availabe [here](https://www.facebook.com/translations/FacebookLocales.xml) ). By default it uses the same language as the site, but alternatively you can specify the language in the shortcode. The dashboard widget is currently only available in English but is multilingual ready.

= My Facebook page isn't loading =
If the URL for your page is http://facebook.com/ABC123 then when you use the shortcode don't include the domain, instead use like so: `[facebook-page-plugin href="ABC123"]`
Also, if your page has only just been created it may take some time for the API to load the page. Just be patient

= What versions of WordPress will this plugin work on? =
Shortcodes were introduced in WordPress 2.5, so theorectially it should work on all sites that are at least 2.5, however it has only been tested on versions 4.0 and up, and no guarantee will be made concerning earlier versions

= I can only see a link, the plugin won't load =
By default the plugin will display a link to your page while the page plugin loads. If the page plugin doesn't load, this could happen for a number of reasons. Your connection could be very slow, you could have JavaScript disabled, you could have an ad blocker or similar browser extension blocking the plugin or there could be an error in the information you have provided in the widget or shortcode. 

= I can't get the Facepile to work! =
Chances are your plugin isn't tall enough to display the facepile properly. The facepile requires the plugin to have a minimum height of 214 pixels, or 154 pixel if using the small header.

== Screenshots ==
1. Installation example
2. Example of the new widget introduced in version 1.2.0
3. The new shortcode generator dashboard widget

== Changelog ==

= 1.5.3 =
* Fixed bug where share button would return `App Not Setup` error

= 1.5.2 =
* Fixed bug where plugin would rerender during scroll on mobile devices

= 1.5.1 =
* Fixed bug where plugin wouldn't rerender
* Fixed bug with languages XML file not loading on installs where the admin is not wp-admin

= 1.5.0 =
* Migrated to object oriented
* Fixed languages XML file being blocked by iThemes Security
* Added option for switching between HTML5/XHTML
* Fixed HTML issue with dashboard widget
* Added script that makes the plugin fully responsive

= 1.4.2 =
* Fixing shortcode not being updated when tabs change in the shortcode generator
* Removing link text parameter and option when `Show Link` is false

= 1.4.1 =
* Fixing shortcode generator using posts instead of tabs
* Verifying compatibility with 4.3.1

= 1.4.0 =
* Options to remove and customise the page link that displays while the plugin loads
* Fixed `undefined index` error when adding a new instance of the plugin in the customizer
* Updated all admin text to be multi-lingual compatible
* Updated `posts` option to `tabs`
* Updated screenshots and example

= 1.3.4 =
* Fixed typo in widget
* Fixed labels in widget
* Changed languages to load from a local file instead of Facebook's Locales XML file. This fixes the issue where approximately 40 languages were supported by Facebook but not for the page plugin, and also users working locally without internet access are now able to change the language from default.
* Re-introduced App ID, while it should not be needed it appears that removing it has affected some sites.

= 1.3.3 =
* Direct access security update
* Verifying compatibility with WP 4.2.4 and WP 4.3
* Fixing bug where some options in the widget would revert to the default instead of false

= 1.3.2 =
* WP 4.2.3 Compatibility
* Upgrading to Graph API 2.4

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

= 1.4.0 =
The `posts` option has been removed and replaced by `tabs`. If you are upgrading to 1.4.0, please adjust your shortcodes and widgets accordingly.

= 1.3.3 =
This version includes increased security measures and fixes a bug where some widget options would not work properly. Please upgrade immediately.

= 1.3.0 =
This version adds new settings. Please update for the best possible experience.

= 1.2.3 =
This version fixes a bug where the admin dashboard and widgets pages would break if the WordPress installation is running on localhost and there is no internet connection. While not imperative to most sites it is recommended that you update if you work on a localhost or virtual machine

= 1.2.2 =
This version addresses a fix for the posts option not working in the widget. Please update immediately.

= 1.2.0 =
This version includes multilingual support, a custom widget and a shortcode generator on the admin dashboard. It is highly recommended that you update.

= 1.1.1 =
Fixed height bug where height would only ever be the same value as width. Update immediately.

= 1.1.0 =
Added filter to allow calling of shortcodes in the text widget
