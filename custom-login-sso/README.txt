=== Plugin Name ===
Contributors: sumanbiswas013
Donate link: https://profiles.wordpress.org/sumanbiswas013/
Tags: login,REST API,
Requires at least: 3.0.1
Tested up to: 6.0 2
Stable tag: 6.0 2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

By using this plugin you will get custom rest api to get user login

== Description ==

Rest api endpoint to get user login.
If user is not exits then it will create the user and then login and return success data.
If password is not matched with username then it will return error.

API endpoint :
1. Login 
	https://domainname.com/wp-json/custom-login/v1/login
	Method : Post
	Parameters : 
		username (string)
		pswword (string)
	Response :
		Array


== Installation ==


1. Upload `custom-login` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress


== Frequently Asked Questions ==



== Screenshots ==



== Changelog ==

