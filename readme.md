# Facebook Page Plugin
by @cameronjonesweb

It's time to upgrade from your old like box! Display the Facebook Page Plugin from the Graph API using a shortcode or widget.


## Description
Seamlessly add a Facebook Page to your WordPress website with the Facebook Page Plugin! Trusted by more than 20,000 WordPress websites worldwide, the Facebook Page Plugin is the simplest way to add a Facebook page to your website.

You can add your Facebook page to any widget area with the custom Facebook Page Plugin widget, with live preview available in the Customizer.

The plugin can be used to add your Facebook page to any post, page or text widget by using the `[facebook-page-plugin]` shortcode to display the plugin wherever you like, as often as you like.

Other features include:

* A shortcode generator on the admin dashboard for easy generating of the shortcode

* Uses your site language by default, but you can display your Facebook page in all 95 languages that Facebook supports, including English, Spanish, Arabic, German, French, Russian and many more

With more than 20,000 installs and nearly 50 5-star rating, the Facebook Page Plugin is one of the most popular social media plugins for WordPress.


## Frequently Asked Questions

### What happened to "Show Posts"?
The latest version of the API has removed show posts and replaced it with `tabs` which is more dynamic. To show just the posts, your tabs value should be "timeline". To hide the posts, `tabs` should be empty (shortcode) or select "none" (widget). If you're using the shortcode, remember that by default it shows the timeline so you must set it as either an empty or false value to hide posts ie `tabs=""` or `tabs="false"`. If the posts option is already being used it will be converted to tabs.

### What languages are available?
As of version 1.2.0, the plugin is available in all languages provided by Facebook ( full list availabe [here](https://www.facebook.com/translations/FacebookLocales.xml) ). By default it uses the same language as the site, but alternatively you can specify the language in the shortcode. The dashboard widget is currently only available in English but is multilingual ready.

### My Facebook page isn't loading
If the URL for your page is http://facebook.com/ABC123 then when you use the shortcode don't include the domain, instead use like so: `[facebook-page-plugin href="ABC123"]`
Also, if your page has only just been created it may take some time for the API to load the page. Just be patient

### What versions of WordPress will this plugin work on? ###
Shortcodes were introduced in WordPress 2.5, so theorectially it should work on all sites that are at least 2.5, however it has only been tested on versions 4.0 and up, and no guarantee will be made concerning earlier versions

### I can only see a link, the plugin won't load
By default the plugin will display a link to your page while the page plugin loads. If the page plugin doesn't load, this could happen for a number of reasons. Your connection could be very slow, you could have JavaScript disabled, you could have an ad blocker or similar browser extension blocking the plugin or there could be an error in the information you have provided in the widget or shortcode. 

### I can't get the Facepile to work!
Chances are your plugin isn't tall enough to display the facepile properly. The facepile requires the plugin to have a minimum height of 214 pixels, or 154 pixel if using the small header.


## Screenshots
1. Installation example
1. Example of the new widget introduced in version 1.2.0
1. The new shortcode generator dashboard widget


## Changelog

### 1.6.0 - 02/04/17
* New landing page with FAQs to help with onboarding of new users
* Removal of the admin notice review nag
* Localisation of SDK
* Added `events` option to the widget and shortcode generator
* Changed `tabs` setting to checkboxes instead of a dropdown

### 1.5.3 - 25/01/16
* Fixed bug where share button would return `App Not Setup` error

### 1.5.2 - 01/12/15
* Fixed bug where plugin would rerender during scroll on mobile devices

### 1.5.1 - 29/11/15
* Fixed bug where plugin wouldn't rerender
* Fixed bug with languages XML file not loading on installs where the admin is not wp-admin

### 1.5.0 - 23/11/15
* Migrated to object oriented
* Fixed languages XML file being blocked by iThemes Security
* Fixed HTML issue with dashboard widget
* Added script that makes the plugin fully responsive

### 1.4.2 - 23/09/15
* Fixing shortcode not being updated when tabs change in the shortcode generator
* Removing link text parameter and option when `Show Link` is false

### 1.4.1 - 22/09/15
* Fixing shortcode generator using posts instead of tabs
* Verifying compatibility with 4.3.1

### 1.4.0 - 03/09/15
* Options to remove and customise the page link that displays while the plugin loads
* Fixed `undefined index` error when adding a new instance of the plugin in the customizer
* Updated all admin text to be multi-lingual compatible
* Updated `posts` option to `tabs`
* Updated screenshots and example

### 1.3.4 - 13/08/15
* Fixed typo in widget
* Fixed labels in widget
* Changed languages to load from a local file instead of Facebook's Locales XML file. This fixes the issue where approximately 40 languages were supported by Facebook but not for the page plugin, and also users working locally without internet access are now able to change the language from default.
* Re-introduced App ID, while it should not be needed it appears that removing it has affected some sites.

### 1.3.3 - 11/08/15
* Direct access security update
* Verifying compatibility with WP 4.2.4 and WP 4.3
* Fixing bug where some options in the widget would revert to the default instead of false

### 1.3.2 - 25/07/15
* WP 4.2.3 Compatibility
* Upgrading to Graph API 2.4

### 1.3.0 - 02/07/15
* Added hide-cta, small-header and adapt-container-width settings
* Adjusted min height and width

### 1.2.5 - 06/06/15
* Fixed close icon on notice

### 1.2.4 - 05/06/15
* Fixed readme

### 1.2.3 - 04/06/15
* Fixed bug where the admin dashboard and widgets pages would break if the WordPress installation is running on localhost and there is no internet connection

### 1.2.2 - 27/05/15
* Fixed posts option for widget

### 1.2.1 - 27/05/15
* Fixed readme bug

### 1.2.0 - 26/05/15
* Added multilingual support. Language can be specified in the shortcode, otherwise it is retrievd from the site settings.
* Added a shortcode generator dashboard widget to allow easier creation of the shortcode
* Added a custom widget

### 1.1.1 - 14/05/15
* Fixed height bug

### 1.1.0 - 10/05/15
* Added filter to allow calling of shortcodes in the text widget

### 1.0.3 - 28/04/15
* Fixing screenshot issue

### 1.0.1 - 28/04/15
* Cleaning up readme file

### 1.0 - 25/04/15
* Initial release


## Plugin Settings

The Facebook Page Plugin uses a shortcode to insert the page feed. You set your settings within the shortcode.
`[facebook-page-plugin setting="value"]` 
Available settings: 

`href` (URL path that comes after facebook.com/)

`width` (number, in pixels, between 180 and 500, default 340)

`height` (number, in pixels, minimum 70, default 500)

`cover` (true/false, show page cover photo, default true)

`facepile` (true/false, show facepile, default true)

`tabs` (any combination of [posts, messages, events], default timeline)

`cta` (true/false, hide custom call to action if applicable, default false)

`small` (true/false, display small header (must be true for height to be lower than 130px), default false)

`adapt` (true/false, force plugin to be responsive, default true)

`language` (languageCode_countryCode eg: en_US, language of the plugin, default site language)

* Deprecated Settings *

`posts` (true/false) - posts has been replaced by tabs as of 1.4.0. There is a fallback in place to convert it to tabs

Example: `[facebook-page-plugin href="facebook" width="300" height="500" cover="true" facepile="true" tabs="timeline" adapt="true"]`
This will display a Facebook page feed that loads in the page `facebook.com/facebook` that is 300px wide but adapts to it's container, 500px high, displaying the page's cover photo, facepile and recent posts in the same language as the site. See the screenshots tab for a demonstration of how it will appear


## Filter Reference

`facebook_page_plugin_dashboard_widget_capability`

Changes who can see the shortcode generator on the dashboard. Default: `edit_posts`

`facebook_page_plugin_app_id`

Changes the Facebook App ID.