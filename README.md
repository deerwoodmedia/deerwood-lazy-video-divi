# Deerwood Lazy Video for Divi

A free, lightweight **YouTube and Vimeo video module for Divi 4 and native Divi 5**, developed by Deerwood Media.

Traditional video embeds can load third-party player resources before a visitor ever watches the video. Deerwood Lazy Video replaces the initial player with a lightweight thumbnail and play button. The YouTube or Vimeo iframe is only created after the visitor clicks Play.

## What it does

- Adds a **Deerwood Lazy Video** module to the Divi Builder.
- Supports **Divi 4 and native Divi 5** in one installer.
- Lets you choose **YouTube or Vimeo** as the video provider.
- Accepts standard YouTube URLs, YouTube video IDs, Vimeo URLs, or numeric Vimeo video IDs.
- Supports custom/local thumbnails from the WordPress Media Library.
- Automatically uses YouTube's `maxresdefault.jpg` thumbnail when no custom YouTube thumbnail is selected.
- Uses a custom/local thumbnail for Vimeo so Vimeo does not need to be contacted before Play is clicked.
- Uses `youtube-nocookie.com` by default for YouTube privacy-enhanced playback.
- Can autoplay the video after the visitor clicks Play.
- Supports 16:9, 4:3, 1:1, and 9:16 aspect ratios.
- Includes **Priority / Above Fold** and **Lazy / Below Fold** thumbnail loading.
- Includes controls for play button colour, icon colour, and size.
- Reserves the video aspect ratio before playback to help reduce layout shift.
- Uses a small CSS file and vanilla JavaScript frontend loader shared by module instances.

## Why use it?

A normal YouTube or Vimeo embed can load third-party player resources before the visitor ever watches the video.

Deerwood Lazy Video takes a simpler approach: **don't load the video player until it is requested.**

Before the visitor clicks Play, the module displays a thumbnail and lightweight CSS play button. The actual third-party player iframe is created only after interaction.

For maximum control, use a **local custom thumbnail**. This avoids contacting the video provider before Play is clicked. Vimeo uses this local-thumbnail approach by design.

## YouTube

Choose **YouTube** as the Video Provider and paste a supported YouTube URL or 11-character video ID.

Supported inputs include:

- Standard YouTube watch URLs
- `youtu.be` links
- Embed URLs
- YouTube Shorts URLs
- YouTube live URLs
- 11-character YouTube video IDs

If no custom thumbnail is selected, the module automatically uses YouTube's maximum-resolution thumbnail. You can instead choose a local image from the WordPress Media Library to avoid the pre-click thumbnail request to YouTube.

YouTube privacy-enhanced playback using `youtube-nocookie.com` is enabled by default.

## Vimeo

Choose **Vimeo** as the Video Provider and paste a Vimeo URL or numeric Vimeo video ID.

Vimeo videos use a **custom/local thumbnail** selected from the WordPress Media Library. The plugin does not fetch a Vimeo thumbnail automatically, which keeps Vimeo out of the initial page load.

When the visitor clicks Play, the local thumbnail is replaced with the Vimeo player iframe.

## Thumbnail loading

The module includes two thumbnail loading modes:

- **Priority / Above Fold** — uses eager loading and high fetch priority for a video visible when the page first opens.
- **Lazy / Below Fold** — lazy loads thumbnails for videos farther down the page.

Priority is the default.

## Installation

1. Download the latest packaged plugin ZIP from the GitHub Releases page.
2. In WordPress, go to **Plugins → Add New → Upload Plugin**.
3. Upload and activate **Deerwood Lazy Video for Divi**.
4. Open a page in the Divi Builder.
5. Add the **Deerwood Lazy Video** module.
6. Choose YouTube or Vimeo.
7. Paste the video URL or ID.
8. For YouTube, optionally choose a local thumbnail. For Vimeo, choose a custom thumbnail.

The same plugin works with Divi 4 and Divi 5.

## Updates

Deerwood Lazy Video can receive updates through the normal WordPress plugin update interface.

Public releases are distributed through GitHub Releases using the packaged `deerwood-lazy-video-divi.zip` installer.

## Requirements

- WordPress 6.0+
- PHP 7.4+
- Divi 4 or Divi 5

## Current version

**1.4.0**

### 1.4.0

- Added Vimeo as a Video Provider in Divi 4 and native Divi 5.
- Added support for Vimeo URLs and numeric Vimeo video IDs.
- Vimeo remains click-to-load and uses a custom/local thumbnail.
- Generalized the video input to **Video URL or ID**.
- Existing modules continue to use YouTube by default for backward compatibility.

## Author

[Deerwood Media](https://deerwoodmedia.com/)

## License

GPL-2.0-or-later
