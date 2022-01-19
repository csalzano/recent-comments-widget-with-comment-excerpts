=== Recent Comments Widget with Comment Excerpts ===

Contributors: salzano
Tags: recent comments, recent comment excerpts, comment excerpts, latest comments, newest comments
Requires at least: 2.8
Tested up to: 5.8.3
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Changes the behavior of the built-in Recent Comments widget to display comment excerpts instead of post titles

== Description ==

This plugin replaces the default recent comments widget so it behaves differently. Instead of the format "username on post title," the widget will display "username said comment excerpt."

All development happens on Github at [https://github.com/csalzano/recent-comments-widget-with-comment-excerpts](https://github.com/csalzano/recent-comments-widget-with-comment-excerpts)

Contact me by posting a message in the forums or [@breakfastcodes](https://twitter.com) on twitter.


== Installation ==

1. Download recent-comments-widget-with-excerpts.zip
1. Decompress the file contents
1. Upload the recent-comments-widget-with-excerpts folder to a Wordpress plugins directory (/wp-content/plugins)
1. Activate the plugin from the Administration Dashboard
1. Open the Widgets page under the Appearance section
1. Drag the widget to an active sidebar

== Frequently Asked Questions ==

= Need help? Have a suggestion? =
[Visit this plugin's home page](http://www.tacticaltechnique.com/wordpress/recent-comments-widget-with-excerpts/)

== Screenshots ==

1. Sample output

== Change Log ==

= 1.0.0 =
* [Added] Adds a text domain and makes all strings translatable
* [Added] Adds a setting to modify the character length of the comment excerpt
* [Added] Adds a license declaration to confirm this is GPLv2 code
* [Changed] Changes tested up to version number to 5.8.3
* [Changed] Changes the version number to use semantic versioning
* [Changed] Changes the plugin URI to point to the Github repo where I am now maintaining this plugin
* [Removed] Removes inline CSS to best play nice with users' sites

= 0.121230 =
Wrapped the author name with an HTML span to allow CSS to target only the author name.

= 0.111019 =
Massage the comment data with strip_tags, apply_filters and mb_substr for international characters/unicode

= 0.110111 = 
Stop showing ellipsis if the comment length is not long enough to be trimmed by the widget

= 0.101109 =
First build

== Upgrade Notice ==

= 1.0.0 = 
I am revisiting all my years-old plugins to see if anyone is still using them. This version fixes all issues raised in the forums, including making all strings translatable and adding a setting to control the character length of the comment excerpt. If you want me to add a block to this plugin with the same features as this widget, please reach out and say so in the forums or on twitter @breakfastcodes. Changes tested up to version number to 5.8.3. 

= 0.121230 = 
The new feature included with this update is the ability to target the author's name with CSS. Thank you, NicoleHolgate, for requesting this feature on the support forum.

= 0.111019 = 
This update handles comment data more responsibly. Other comment filters will be applied using apply_filters. Comments containing international characters will be properly truncated with mb_substr instead of substr. HTML will be removed from the comments with strip_tags. Up to 150 comments can be displayed instead of 15. Thank the users of this plugin for suggesting these changes on my blog.

= 0.110111 =
The previous version of this plugin would add an ellipsis (...) to the end of the comment excerpts even if the total length of the comment is less than the excerpt length. This length is currently 50 characters.

= 0.101109 =
First build