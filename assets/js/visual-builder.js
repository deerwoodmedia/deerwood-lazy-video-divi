(function ($, React) {
    'use strict';

    if (!$ || !React) {
        return;
    }

    function getVideoId(input) {
        input = String(input || '').trim();
        if (/^[A-Za-z0-9_-]{11}$/.test(input)) {
            return input;
        }
        var match = input.match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?.*?v=|embed\/|shorts\/|live\/))([A-Za-z0-9_-]{11})/);
        return match ? match[1] : '';
    }

    class DeerwoodLazyVideo extends React.Component {
        static slug = 'dlvd_lazy_video';

        render() {
            var id = getVideoId(this.props.youtube_url);
            var thumb = this.props.thumbnail || (id ? 'https://i.ytimg.com/vi/' + encodeURIComponent(id) + '/maxresdefault.jpg' : '');
            var ratio = this.props.aspect_ratio || '16-9';
            var label = this.props.accessible_label || 'Play video';
            var buttonColor = this.props.play_button_color || '#ff0000';
            var iconColor = this.props.play_icon_color || '#ffffff';
            var buttonSize = this.props.play_button_size || '68px';
            var style = {
                '--dlvd-button': buttonColor,
                '--dlvd-icon': iconColor,
                '--dlvd-size': buttonSize
            };

            if (!id) {
                return React.createElement(
                    'div',
                    { className: 'dlvd-notice' },
                    'Enter a YouTube URL or video ID.'
                );
            }

            return React.createElement(
                'div',
                { className: 'dlvd-wrap dlvd-ratio-' + ratio, style: style },
                React.createElement('img', {
                    className: 'dlvd-thumb',
                    src: thumb,
                    alt: ''
                }),
                React.createElement(
                    'button',
                    {
                        className: 'dlvd-play',
                        type: 'button',
                        'aria-label': label,
                        onClick: function (event) { event.preventDefault(); }
                    },
                    React.createElement('span', { 'aria-hidden': 'true' })
                )
            );
        }
    }

    $(window).on('et_builder_api_ready', function (event, API) {
        API.registerModules([DeerwoodLazyVideo]);
    });
})(window.jQuery, window.React);
