=== Connections Business Directory Login  ===
Contributors: shazahm1@hotmail.com
Donate link: http://connections-pro.com/
Tags: addresses, address book, addressbook, bio, bios, biographies, business, businesses, business directory, business-directory, business directory plugin, directory plugin, directory widget, church, contact, contacts, connect, connections, directory, directories, hcalendar, hcard, ical, icalendar, image, images, list, lists, listings, member directory, members directory, members directories, microformat, microformats, page, pages, people, profile, profiles, post, posts, plugin, shortcode, staff, user, users, vcard, wordpress business directory, wordpress directory, wordpress directory plugin, wordpress business directory, login, form, login form, widget, login widget
Requires at least: 3.8
Tested up to: 4.2
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Extension for the Connections Business Directory that adds a shortcode and widget to display a login form.

== Description ==

This is an extension plugin for the [Connections Business Directory Plugin](http://wordpress.org/plugins/connections/) please be sure to install and active it before adding this plugin.

What does this plugin do?
It adds an entry content block, a shortcode and a widget which displays a login form when a user is not logged into your site.

Ok, great, but how does this benefit me?
Well, if you have the directory setup to require login, you can add the `[connections_login]` shortcode to the login required message setting (or any page you want, the shortcode is not limited to this setting). When it is added and the user is not logged in and visit your directory, they'll be shown your message plus the login form.

The content block login form and the login widget are best used with [Link](http://connections-pro.com/add-on/link/) installed and activated. You can setup the login form content block to be shown on a single entry, that way when a user visits the page and they are not logged in, they'll be shown a login form right on their page. Alternatively, you could use the widget which will only be displayed on the single entry page when a user is not logged in. It's your choice, you could use either one or both.

[Checkout the screenshots.](http://connections-pro.com/add-on/login/)

Here are other great extensions that enhance your expirence with the Connections Business Directory:

* [Business Hours](http://wordpress.org/plugins/connections-business-directory-hours/)
* [Toolbar](http://wordpress.org/plugins/connections-toolbar/)
* [Income Levels](http://wordpress.org/plugins/connections-business-directory-income-levels/)
* [Education Levels](http://wordpress.org/plugins/connections-business-directory-education-levels/)
* [Languages](http://wordpress.org/plugins/connections-business-directory-languages/)

== Installation ==

= Using the WordPress Plugin Search =

1. Navigate to the `Add New` sub-page under the Plugins admin page.
2. Search for `connections business directory login`.
3. The plugin should be listed first in the search results.
4. Click the `Install Now` link.
5. Lastly click the `Activate Plugin` link to activate the plugin.

= Uploading in WordPress Admin =

1. [Download the plugin zip file](http://wordpress.org/plugins/connections-business-directory-login/) and save it to your computer.
2. Navigate to the `Add New` sub-page under the Plugins admin page.
3. Click the `Upload` link.
4. Select Connections Business Directory Login zip file from where you saved the zip file on your computer.
5. Click the `Install Now` button.
6. Lastly click the `Activate Plugin` link to activate the plugin.

= Using FTP =

1. [Download the plugin zip file](http://wordpress.org/plugins/connections-business-directory-login/) and save it to your computer.
2. Extract the Connections Business Directory Login zip file.
3. Create a new directory named `connections-business-directory-login` directory in the `../wp-content/plugins/` directory.
4. Upload the files from the folder extracted in Step 2.
4. Activate the plugin on the Plugins admin page.

== Frequently Asked Questions ==

None yet...

== Screenshots ==

[Screenshots can be found here.](http://connections-pro.com/add-on/login/)

== Changelog ==

= 1.1 07/06/2015 =
BUG: Load the text domain immediately on plugins_loaded action so the translation files will be loaded.
BUG: Remove stray period from version number.
TWEAK: Refactor loadTextDomain() so it is consistent with the other extensions for Connections.
I18N: Include the POT file.
I18N: Add a Spanish (Spain) translation (machine translated).
DEV: Update .gitignore.

= 1.0 08/08/2014 =
* Initial release.
