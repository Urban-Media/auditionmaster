=== LifterLMS Labs ===
Contributors: thomasplevy, chrisbadgett, kathy11, lifterlms, codeboxllc
Donate link: https://lifterlms.com
Tags: learning management system, LMS, membership, elearning, online courses, quizzes, sell courses, badges, gamification, learning, Lifter, LifterLMS
Requires at least: 4.7
Tested up to: 4.8.1
Stable tag: 1.4.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A collection of experimental, conceptual, and possibly silly features which improve and enhance the functionality of the LifterLMS core.

== Description ==

LifterLMS Labs is a collection of experimental, conceptual, and possibly silly features which improve and enhance the functionality of the LifterLMS core.

We've created this free LifterLMS add-on in order to provide these optional features to the LifterLMS community which may or may not be useful to everyone.

Some labs will ultimately find their way into the LifterLMS Core, some may be a lab forever.


### Current Labs

**Action Manager**

Quickly remove specific elements like course author, syllabus, and more without having to write any code. [Documentation and more information](https://lifterlms.com/docs/lab-action-manager/?utm_source=readme&utm_medium=product&utm_campaign=lifterlmslabsplugin&utm_content=actionmanager).

** Beaver Builder**

Add LifterLMS elements as pagebuilder modules and enable row and module visibility settings based on student enrollment in courses and memberships. [Documentation and more information](https://lifterlms.com/docs/lab-beaver-builder/?utm_source=readme&utm_medium=product&utm_campaign=lifterlmslabsplugin&utm_content=beaverbuilder).


**Lifti: Divi Theme Compatibility**

Enable LifterLMS compatibility with the Divi Theme and Page Builder. [Documentation and more information](https://lifterlms.com/docs/lab-lifti/?utm_source=readme&utm_medium=product&utm_campaign=lifterlmslabsplugin&utm_content=lifti).


**Simple Branding**

Customize the default colors of various LifterLMS elements. [Documentation and more information](https://lifterlms.com/docs/simple-branding-lab?utm_source=readme&utm_campaign=lifterlmslabsplugin&utm_medium=product&utm_content=simplebranding).


**Super Sidebars**

Very quickly configure LifterLMS sidebars to work with your theme. [Documentation and more information](https://lifterlms.com/docs/super-sidebars-lab?utm_source=readme&utm_campaign=lifterlmslabsplugin&utm_medium=product&utm_content=supersidebars).

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the LifterLMS -> Labs screen to activate and configure the labs you wish to use

== Frequently Asked Questions ==

= Why are these labs not included in the LifterLMS Core? =

Because not every LifterLMS user needs (or wants) the features in this plugin.

== Changelog ==

= v1.4.0 - 2017-09-05 =
-----------------------

##### Simple Branding Updates

+ Add support for LifterLMS notifications
+ Set default colors for branding options. Fixes issues with invalid CSS when options aren't set after enabling the lab
+ Make all branding color settings required


= v1.3.1 - 2017-08-16 =
-----------------------

+ Ensures BeaverBuilder enabled courses and lessons properly display private areas and private posts generated by LifterLMS Private Areas


= v1.3.0 - 2017-08-03 =
-----------------------

### Beaver Builder Integration Lab

+ Adds LifterLMS-specific modules for course and lesson construction via Beaver Builder
+ Adds row & module visibility settings to conditionally display elements based on course/membership enrollment status of the current visitor
+ Adds a basic LifterLMS course template for quick course building with a layout similar to the standard LifterLMS course layout
+ Full usage documentation and more details [here](https://lifterlms.com/docs/lab-beaver-builder/)


= v1.2.2 - 2017-05-19 =
-----------------------

+ Simple Branding: Automatically brand LifterLMS email templates according to branding color settings (requires LifterLMS 3.8.0 and higher).
+ Fix typo in i18n directory name


= v1.2.1 - 2017-03-28 =
-----------------------

+ Prevent Lifti from returning a builder layout for lessons when retrieving the lesson excerpt


= v1.2.0 - 2017-03-28 =
-----------------------

### Action Manager Lab

+ Check boxes to remove LifterLMS elements added to courses, lessons, and memberships instead of writing code

### Lifti: Divi compatibility Upgrades!

+ Divi Friends is now called Lifti because it's more fun
+ Add options for Divi page builder and custom layout support on LifterLMS courses, lessons, and memberships
+ Add a prebuilt layout for LifterLMS courses which automatically adds default LifterLMS content via LifterLMS shortcodes to a pagebuilder layout
	+ If you already had this lab enabled, disable and re-enable so the layout will be installed!
+ Combine this lab with the Action Manager for a lot of Divi fun!


= v1.1.2 - 2017-02-20 =
-----------------------

+ Load template functions on the admin panel when using the Divi Friends lab. Allows LifterLMS widgets and shortcodes to be used within Divi page builder.


= v1.1.1 - 2017-01-17 =
-----------------------

+ Fixed bug with Divi theme not removing lifterlms sidebars by making action initalize late
+ Tested up to WordPress core 4.7.1


= v1.1.0 - 2017-01-10 =
-----------------------

+ Added Divi Friends for better compatibility with Divi theme
+ Added support for labs without settings
+ Automatically load all labs for display on labs setting screen


= v1.0 - 2016-12-27 =
---------------------

+ Initial public release

