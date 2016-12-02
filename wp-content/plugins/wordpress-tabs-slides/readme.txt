=== WP Tabs Slides ===
Contributors: abdul_ibad
Donate Link: http://wts.dulabs.com 
Tags: tab,tabs,slides,post,responsive,bootstrap,collapse
Requires at least: 2.7
Tested up to: 3.0
Stable tag: 2.0.0

Tabs and Slides (in post/page) Plugin gives you the ability to easily add content tabs and/or content slides.

== Description ==

Tabs and Slides (in post/page) Plugin gives you the ability to easily add content tabs and/or content slides. The tabs emulate a multi-page structure, while the slides emulate an accordion-like structure, inside a single page!

= Support Easy Responsive Tabs as default tab engine =
http://webthemez.com/demo/easy-responsive-tabs/Index.html

= Support Bootstrap Tab =
See installation.

= Demo =
http://satuproperti.com/wp-tabs-test

= Github =
https://github.com/dulabs/Wordpress-Tabs-Slides

= Homepage =
http://wts.dulabs.com

Before update, please backup your style or wordpress.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload folder `wordpress-tabs-slides` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Test and enjoy!

= Default Tab Shortcode =

Insert shortcode to your post or page

[tabs]
	[tab title="Tab 1 Title"]
		Tab Content 1
	[/tab]
	[tab title="Tab 2 Title"]
		Tab Content 2
	[/tab]
[/tabs]

Vertical Tab

[tabs type="vertical"]
	[tab title="Tab 1 Title"]
		Tab Content 1
	[/tab]
	[tab title="Tab 2 Title"]
		Tab Content 2
	[/tab]
[/tabs]

= Bootstrap Tab Shortcode =

[boottabs]
	[boottab title="Tab 1 Title"]
		Tab Content 1
	[/boottab]
	[boottab title="Tab 2 Title"]
		Tab Content 2
	[/boottab]
[/boottabs]

= Bootstrap Collapse = 

Slider has deprecated, and replace with bootstrap collapse

[collapse title="Our Collapse"]
Collapse Content
[/collapse]

Another Example

Trying bootstrap collapse [collapse target="towrapper"]plugin[/collapse] in paragraph.

[collapse name="towrapper"]
Wow, do you see me?
[/collapse]


= Deprecated < 2.0.1 =

Tab:

{tab=Tab Title}
Contents
{/tabs}

or

{tab=Tab 1}

Contents Tab 1

{tab=Tab 2}

Contents Tab 2

{/tabs}

Slide:
{slide=Slide Title}
Contents
{/slide}

Accordion-like structure(1.8):
{accordion=Accordion 1}
Contents
{/accordion}
{accordion=Accordion 2}
  Contents
{/accordion}

== Other Notes ==

= Tabs =
To linking tabs with anchors
you must add tabs title to anchors (ex: ?p=1#tabs1)
if you tabs use whitespace, replace it with %20 (ex: ?p=1#tabs%201)

= Slides =
In previous release, slide was broken when have nested slides.
Now, slideID is change to title of slides. don't use same name for slides.

(Since version 1.8) Slides is available in accordion-like structure. You can call it with accordion tag.

== Changelog ==

= Version 2.0.3 =
* Added: Easy Responsive Tab
* Added: Bootstrap Tab
* Change: Increase compability with wordpress shortcode
* [updated Jan 13, 2016]

= Version 2.0.1 = 
* Added: Custom CSS Style
* Fixed: Some improvements on default CSS
* Change: scripts and styles insert with wp_enqueue_styles and wp_enqueue_scripts

= Version 2.0 =
* Fixed: gap between title and content on tabs
* Fixed: Disable script problem in the frontpage
* Fixed: Javascript issue on slider
* Added: Style option
* Added: Enable script on specify post/page only

= Version 1.9 =
* Fix javascript conflict with eshop (thanks peter)
* Copyright text is disable
* [Updated March 05, 2010]

= Version 1.8 =
* update code for performance
* fix with id selector
* add Accordion style
* [Updated January 07, 2010]

= Version 1.7 =
* Tabs works with anchor
* Fix nested Slides
* [Updated December 25, 2009]

= Version 1.6 = 
* Fix various problems in javascript
* Fix jquery not define
* [Updated November 13, 2009]

= Version 1.5 =
* Fix Javascript with "AnswerDiv" is null
* Fix Slider, now use jQuery SlideToggle
* [Updated October 29, 2009]

= Version 1.4 =
* Fix javascript code for slides
* [Updated October 27, 2009]