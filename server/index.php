<?php
namespace Deerwood\LazyVideo\Divi5;
if ( ! defined( 'ABSPATH' ) ) exit;
require_once ABSPATH . 'wp-content/themes/Divi/includes/builder-5/server/Framework/DependencyManagement/Interfaces/DependencyInterface.php';
use ET\Builder\Framework\DependencyManagement\Interfaces\DependencyInterface;
use ET\Builder\Packages\Module\Module;
use ET\Builder\Packages\Module\Options\Element\ElementClassnames;
use ET\Builder\Packages\ModuleLibrary\ModuleRegistration;
class LazyVideoModule implements DependencyInterface {
    public function load() { add_action( 'init', [ self::class, 'register_module' ] ); }
    public static function register_module() {
        ModuleRegistration::register_module( dirname( __DIR__ ) . '/visual-builder/src', [ 'render_callback' => [ self::class, 'render_callback' ] ] );
    }
    private static function value( $attrs, $name, $default = '' ) {
        $v = $attrs[$name]['innerContent']['desktop']['value'] ?? $default;
        return is_scalar( $v ) ? (string) $v : $v;
    }
    private static function video_id( $input ) {
        $input = trim( html_entity_decode( (string) $input ) );
        if ( preg_match( '/^[A-Za-z0-9_-]{11}$/', $input ) ) return $input;
        foreach ( [ '~youtu\.be/([A-Za-z0-9_-]{11})~', '~youtube\.com/(?:watch\?.*?v=|embed/|shorts/|live/)([A-Za-z0-9_-]{11})~' ] as $pattern ) {
            if ( preg_match( $pattern, $input, $m ) ) return $m[1];
        }
        return '';
    }
    public static function module_classnames( $args ) {
        $args['classnamesInstance']->add( ElementClassnames::classnames( [ 'attrs' => $args['attrs']['module']['decoration'] ?? [] ] ) );
    }
    public static function render_callback( $attrs, $content, $block, $elements ) {
        $id = self::video_id( self::value( $attrs, 'youtubeUrl' ) );
        if ( ! $id ) return '';
        wp_enqueue_style( 'dlvd5-style' );
        wp_enqueue_script( 'dlvd5-player' );
        $thumb = self::value( $attrs, 'thumbnail' );
        if ( is_array( $thumb ) ) $thumb = $thumb['src'] ?? '';
        if ( ! $thumb ) $thumb = 'https://i.ytimg.com/vi/' . rawurlencode( $id ) . '/maxresdefault.jpg';
        $label = self::value( $attrs, 'accessibleLabel', 'Play video' ) ?: 'Play video';
        $privacy = self::value( $attrs, 'privacyMode', 'on' ) !== 'off';
        $autoplay = self::value( $attrs, 'autoplay', 'on' ) !== 'off';
        $ratio = self::value( $attrs, 'aspectRatio', '16-9' ) ?: '16-9';
        $button = self::value( $attrs, 'playButtonColor', '#ff0000' ) ?: '#ff0000';
        $icon = self::value( $attrs, 'playIconColor', '#ffffff' ) ?: '#ffffff';
        $size = self::value( $attrs, 'playButtonSize', '68px' ) ?: '68px';
        $html = sprintf(
            '<div class="dlvd-wrap dlvd-ratio-%1$s" data-video-id="%2$s" data-host="%3$s" data-autoplay="%4$s" style="--dlvd-button:%5$s;--dlvd-icon:%6$s;--dlvd-size:%7$s"><img class="dlvd-thumb" src="%8$s" alt="" loading="lazy" decoding="async"><button class="dlvd-play" type="button" aria-label="%9$s"><span aria-hidden="true"></span></button></div>',
            esc_attr( $ratio ), esc_attr( $id ), $privacy ? 'www.youtube-nocookie.com' : 'www.youtube.com', $autoplay ? '1' : '0', esc_attr( $button ), esc_attr( $icon ), esc_attr( $size ), esc_url( $thumb ), esc_attr( $label )
        );
        return Module::render( [
            'orderIndex' => $block->parsed_block['orderIndex'],
            'storeInstance' => $block->parsed_block['storeInstance'],
            'attrs' => $attrs, 'elements' => $elements, 'id' => $block->parsed_block['id'],
            'moduleClassName' => 'deerwood_lazy_video_divi_5', 'name' => $block->block_type->name,
            'classnamesFunction' => [ self::class, 'module_classnames' ],
            'moduleCategory' => $block->block_type->category,
            'children' => $elements->style_components( [ 'attrName' => 'module' ] ) . $html,
        ] );
    }
}
add_action( 'divi_module_library_modules_dependency_tree', function( $tree ) { $tree->add_dependency( new LazyVideoModule() ); } );
