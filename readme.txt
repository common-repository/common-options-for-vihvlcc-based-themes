=== Common options for VihvLCC based themes  ===
Contributors: vihv
Donate link: 
Tags: theming, xslt, vihvlcc
Requires at least: 3.3
Tested up to: 4.5.3
Stable tag: 1.0.1
License: MIT
License URI: http://opensource.org/licenses/MIT

== Description ==

This plugin has 2 purposes:
1. Editing common options for vihvlcc based themes (enable/disable debugger, debugger position)
2. Include vihvlcc core in wordpress environment, so you can keep an eye on updates using wordpress plugin system

About the lib:

VihvLCC is cross-CMS theming engine based on XSLT. XSLT is fast, well-known and you will make less mistakes while working on views.

Wordpress-specific benefits:

1. Same architecture for themes, plugins and widgets.

For example if you create 2 themes, then review em, you will see some duplicated features. You might want to move that code to some plugin/widget. With default wp coding style it requires a lot of coding. With VihvLCC you just copy/paste a few files from theme folder to plugin folder with minimal(or no) changes.

2. Some ready-to-use components for wordpress.

Other benefits:

3. Components (you can think of em as about widgets) can contain each other, no dept limits.
4. Each component can be runned as a standalone application
5. Everything can be tested with unit tests 

== Screenshots ==

1. Frontend with enabled debugger
2. Options page

== Installation ==

1. Unzip folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently asked questions ==


= How can i ask a question? =

You can send your questions to feedback@vihv.org.

== Changelog ==

= 1.0.1 =
publication fixes
= 1.0.0 =
Initial

== Upgrade Notice ==

upgrade as usual