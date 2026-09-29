=== Deerwood Lazy Video Divi Module ===
Contributors: deerwoodmedia
Tags: divi, youtube, performance, lazy load, video
Requires at least: 6.0
Requires PHP: 7.4
Stable tag: 1.2.0

A lightweight Divi 4 custom module that delays the YouTube iframe until the visitor clicks Play.

== Installation ==
1. Upload the ZIP in Plugins > Add New > Upload Plugin.
2. Activate Deerwood Lazy Video Divi Module.
3. In Divi Builder, add the "Deerwood Lazy Video" module.
4. Paste a YouTube URL or video ID.
5. For best performance, choose a local custom thumbnail from the Media Library. If left blank, the module uses YouTube's maxresdefault thumbnail.

== Performance ==
With a custom thumbnail, the module makes no YouTube request before the visitor clicks Play. One small CSS file and one small vanilla-JS file are shared by all module instances on the page. The aspect-ratio container reserves space to reduce layout shift.

== Notes ==
Version 1.0 targets Divi 4's ET_Builder_Module API. Divi 5 has a separate native module API and should receive a dedicated compatibility build rather than relying on backward compatibility mode.


== Changelog ==

= 1.2.0 =
* Added Thumbnail Loading control.
* Priority / Above Fold is now the default and uses eager loading with high fetch priority to improve LCP.
* Lazy / Below Fold remains available for videos farther down the page.

= 1.1.1 =
* Added the required Divi 4 React Visual Builder component.
* Fixed raw JavaScript/function output appearing in the Visual Builder.
* Video thumbnail and play button now render as a non-playing preview while editing.

= 1.0.0 =
* Initial release.
