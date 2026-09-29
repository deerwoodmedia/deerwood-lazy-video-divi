<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Deerwood_Lazy_Video_Module extends ET_Builder_Module {
    public $slug       = 'dlvd_lazy_video';
    public $vb_support = 'partial';

    public function init() {
        $this->name = esc_html__( 'Deerwood Lazy Video', 'deerwood-lazy-video-divi' );
        $this->icon_path = '';

        $this->advanced_fields = array(
            'background'     => false,
            'fonts'          => false,
            'text'           => false,
            'button'         => false,
            'link_options'   => false,
            'margin_padding' => array(),
            'borders'        => array(),
            'box_shadow'     => array(),
            'filters'        => array(),
            'transform'      => array(),
            'animation'      => array(),
        );
    }

    public function get_fields() {
        return array(
            'youtube_url' => array(
                'label'           => esc_html__( 'YouTube URL or Video ID', 'deerwood-lazy-video-divi' ),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Paste a YouTube URL (youtube.com or youtu.be) or the 11-character video ID.', 'deerwood-lazy-video-divi' ),
                'toggle_slug'     => 'main_content',
            ),
            'thumbnail' => array(
                'label'              => esc_html__( 'Custom Thumbnail', 'deerwood-lazy-video-divi' ),
                'type'               => 'upload',
                'upload_button_text' => esc_attr__( 'Upload an image', 'deerwood-lazy-video-divi' ),
                'choose_text'        => esc_attr__( 'Choose an Image', 'deerwood-lazy-video-divi' ),
                'update_text'        => esc_attr__( 'Set As Thumbnail', 'deerwood-lazy-video-divi' ),
                'description'        => esc_html__( 'Optional. If empty, the module uses YouTube maxresdefault.jpg. A custom local WebP/JPEG is fastest and makes no YouTube request before play.', 'deerwood-lazy-video-divi' ),
                'toggle_slug'        => 'main_content',
            ),
            'accessible_label' => array(
                'label'       => esc_html__( 'Play Button Label', 'deerwood-lazy-video-divi' ),
                'type'        => 'text',
                'default'     => esc_html__( 'Play video', 'deerwood-lazy-video-divi' ),
                'toggle_slug' => 'main_content',
            ),
            'privacy_mode' => array(
                'label'           => esc_html__( 'YouTube Privacy-Enhanced Mode', 'deerwood-lazy-video-divi' ),
                'type'            => 'yes_no_button',
                'options'         => array( 'on' => esc_html__( 'Yes', 'deerwood-lazy-video-divi' ), 'off' => esc_html__( 'No', 'deerwood-lazy-video-divi' ) ),
                'default'         => 'on',
                'toggle_slug'     => 'main_content',
            ),
            'autoplay' => array(
                'label'           => esc_html__( 'Autoplay After Click', 'deerwood-lazy-video-divi' ),
                'type'            => 'yes_no_button',
                'options'         => array( 'on' => esc_html__( 'Yes', 'deerwood-lazy-video-divi' ), 'off' => esc_html__( 'No', 'deerwood-lazy-video-divi' ) ),
                'default'         => 'on',
                'toggle_slug'     => 'main_content',
            ),
            'aspect_ratio' => array(
                'label'       => esc_html__( 'Aspect Ratio', 'deerwood-lazy-video-divi' ),
                'type'        => 'select',
                'options'     => array( '16-9' => '16:9', '4-3' => '4:3', '1-1' => '1:1', '9-16' => '9:16' ),
                'default'     => '16-9',
                'toggle_slug' => 'main_content',
            ),
            'play_button_color' => array(
                'label'       => esc_html__( 'Play Button Color', 'deerwood-lazy-video-divi' ),
                'type'        => 'color-alpha',
                'default'     => '#ff0000',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'play_button',
            ),
            'play_icon_color' => array(
                'label'       => esc_html__( 'Play Icon Color', 'deerwood-lazy-video-divi' ),
                'type'        => 'color-alpha',
                'default'     => '#ffffff',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'play_button',
            ),
            'play_button_size' => array(
                'label'          => esc_html__( 'Play Button Size', 'deerwood-lazy-video-divi' ),
                'type'           => 'range',
                'default'        => '68px',
                'range_settings' => array( 'min' => 40, 'max' => 120, 'step' => 1 ),
                'tab_slug'       => 'advanced',
                'toggle_slug'    => 'play_button',
            ),
        );
    }

    public function get_settings_modal_toggles() {
        return array(
            'general' => array( 'toggles' => array( 'main_content' => esc_html__( 'Video', 'deerwood-lazy-video-divi' ) ) ),
            'advanced' => array( 'toggles' => array( 'play_button' => esc_html__( 'Play Button', 'deerwood-lazy-video-divi' ) ) ),
        );
    }

    private function video_id( $input ) {
        $input = trim( html_entity_decode( (string) $input ) );
        if ( preg_match( '/^[A-Za-z0-9_-]{11}$/', $input ) ) { return $input; }
        $patterns = array(
            '~youtu\.be/([A-Za-z0-9_-]{11})~',
            '~youtube\.com/(?:watch\?.*?v=|embed/|shorts/|live/)([A-Za-z0-9_-]{11})~',
        );
        foreach ( $patterns as $pattern ) {
            if ( preg_match( $pattern, $input, $m ) ) { return $m[1]; }
        }
        return '';
    }

    public function render( $attrs, $content = null, $render_slug = '' ) {
        $id = $this->video_id( isset( $this->props['youtube_url'] ) ? $this->props['youtube_url'] : '' );
        if ( ! $id ) {
            return is_admin() ? '<div class="dlvd-notice">' . esc_html__( 'Enter a valid YouTube URL or video ID.', 'deerwood-lazy-video-divi' ) . '</div>' : '';
        }

        wp_enqueue_style( 'dlvd-style' );
        wp_enqueue_script( 'dlvd-script' );

        $thumb = ! empty( $this->props['thumbnail'] ) ? esc_url( $this->props['thumbnail'] ) : 'https://i.ytimg.com/vi/' . rawurlencode( $id ) . '/maxresdefault.jpg';
        $label = ! empty( $this->props['accessible_label'] ) ? $this->props['accessible_label'] : esc_html__( 'Play video', 'deerwood-lazy-video-divi' );
        $privacy = ( isset( $this->props['privacy_mode'] ) && 'off' === $this->props['privacy_mode'] ) ? 'www.youtube.com' : 'www.youtube-nocookie.com';
        $autoplay = ( isset( $this->props['autoplay'] ) && 'off' === $this->props['autoplay'] ) ? '0' : '1';
        $ratio = isset( $this->props['aspect_ratio'] ) ? $this->props['aspect_ratio'] : '16-9';
        $button_color = ! empty( $this->props['play_button_color'] ) ? $this->props['play_button_color'] : '#ff0000';
        $icon_color = ! empty( $this->props['play_icon_color'] ) ? $this->props['play_icon_color'] : '#ffffff';
        $button_size = ! empty( $this->props['play_button_size'] ) ? $this->props['play_button_size'] : '68px';

        $style = sprintf( '--dlvd-button:%s;--dlvd-icon:%s;--dlvd-size:%s;', esc_attr( $button_color ), esc_attr( $icon_color ), esc_attr( $button_size ) );

        return sprintf(
            '<div class="dlvd-wrap dlvd-ratio-%1$s" data-video-id="%2$s" data-host="%3$s" data-autoplay="%4$s" style="%5$s"><img class="dlvd-thumb" src="%6$s" alt="" loading="lazy" decoding="async"><button class="dlvd-play" type="button" aria-label="%7$s"><span aria-hidden="true"></span></button><noscript><a href="https://www.youtube.com/watch?v=%2$s">%7$s</a></noscript></div>',
            esc_attr( $ratio ), esc_attr( $id ), esc_attr( $privacy ), esc_attr( $autoplay ), $style, $thumb, esc_attr( $label )
        );
    }
}
