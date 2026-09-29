# Deerwood Lazy Video Divi Module

A lightweight **Divi 4** module from Deerwood Media for embedding YouTube videos without loading the full YouTube player during the initial page load.

The standard video embed approach can trigger a large number of third-party requests and JavaScript from YouTube and related Google services. Deerwood Lazy Video replaces that initial iframe with a lightweight thumbnail and play button. The YouTube iframe is only created after the visitor clicks Play.

## What it does

- Adds a **Deerwood Lazy Video** module to the Divi Builder.
- Accepts a normal YouTube URL or an 11-character YouTube video ID.
- Supports a custom thumbnail from the WordPress Media Library.
- Falls back to YouTube's `maxresdefault.jpg` thumbnail when no custom image is selected.
- Uses `youtube-nocookie.com` by default for privacy-enhanced playback.
- Can autoplay the video after the visitor clicks Play.
- Supports 16:9, 4:3, 1:1, and 9:16 aspect ratios.
- Includes controls for the play button colour, icon colour, and size.
- Reserves the video aspect ratio before playback to help reduce layout shift.
- Uses one small CSS file and one small vanilla JavaScript file shared by all module instances on the page.

## Why use it?

A normal YouTube iframe can load player JavaScript, CSS, thumbnails, advertising-related resources, and other third-party requests before the visitor ever watches the video.

With this module, the initial page contains only the thumbnail and play button. The actual YouTube iframe does not exist until the visitor interacts with the module.

For the best performance, use a **local custom thumbnail**. In that configuration, the module makes no YouTube request at all before Play is clicked.

## Installation

1. Download or clone this repository.
2. Place the plugin folder in `wp-content/plugins/`, or install the packaged ZIP through **Plugins → Add New → Upload Plugin**.
3. Activate **Deerwood Lazy Video Divi Module**.
4. Open a page in the Divi Builder.
5. Add the **Deerwood Lazy Video** module.
6. Paste a YouTube URL or video ID.
7. Optionally choose a custom thumbnail from the WordPress Media Library.

## Requirements

- WordPress 6.0+
- PHP 7.4+
- Divi 4 / the `ET_Builder_Module` API

## Divi 5

The `main` branch is built specifically for Divi 4. Divi 5 uses a different native module API, so Divi 5 support should be provided as a dedicated build rather than relying on legacy compatibility mode.

## Version

**1.1.1**

## Author

[Deerwood Media](https://deerwoodmedia.com/)
