# Deerwood Lazy Video — Divi 5

Native Divi 5 version of Deerwood Lazy Video. It renders a lightweight thumbnail and play button first, then creates the YouTube iframe only after the visitor clicks Play.

## Performance goal

With a local custom thumbnail, the initial page makes **no YouTube request**. The YouTube player, scripts and related third-party resources are deferred until interaction.

## Features

- Native Divi 5 module registration and Visual Builder support
- YouTube URL or video ID
- Automatic YouTube thumbnail or local custom thumbnail
- Privacy-enhanced `youtube-nocookie.com` playback by default
- Autoplay after click
- 16:9, 4:3, 1:1 and 9:16 ratios
- Play button colour, icon colour and size controls
- Fixed aspect-ratio container to reduce layout shift
- Tiny vanilla-JS frontend player loader

## Branches

- `main` — Divi 4 implementation
- `divi-5` — native Divi 5 implementation

## Testing

This branch is intentionally separate from the Divi 4 release. Test it on a Divi 5 staging site before production deployment, especially after Divi updates that change third-party module APIs.
