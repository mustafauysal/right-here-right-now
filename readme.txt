=== Right Here Right Now ===
Contributors: m_uysl,LettoBlog 
Tags: dashboard widget,widget,chart,right now,admin widget,statistics
Requires at least: 3.0
Tested up to: 5.2
Stable tag: 1.1.2

Replace wordpress right now widget with "Right Here Right Now" widget. (Inspired by Ghost)

== Description ==
This plugin replaces default admin "right now" widget with new one. 

* This plugin uses html5 canvas feature. So your browser must support canvas feature.
* Built with [chartjs](http://www.chartjs.org/ "ChartJS")


== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Network admin's Plugins page.
== Frequently Asked Questions ==

*   Can I use right now and right here right now widget at the same time?  
    - Yes, use `remove_original_right_now_widget`: e.g `add_filter('remove_original_right_now_widget','__return_false');`
*   I can't see charts, what's happening?
    - This plugin use html5 canvas feature. You need a modern browser buddy.
*   Is it compatible with multisite?
	- Yes.	
	
== Screenshots ==
1. screenshot-1.png

== Changelog ==

= 1.1.2 =
* tested up to WP 5.2
* `remove_original_right_now_widget` filter added

= 1.1.1 = 
* Charts size changed for wp 3.8 dashboard widget.

= 1.1 = 
* Items linked to pages.

= 1.0 =
* Initial release

