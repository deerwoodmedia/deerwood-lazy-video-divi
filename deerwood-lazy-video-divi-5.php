<?php
/**
 * Plugin Name: Deerwood Lazy Video Divi 5 Module
 * Description: Native Divi 5 click-to-load YouTube module. Loads the YouTube iframe only after Play is clicked.
 * Version: 1.1.0
 * Author: Deerwood Media
 * Requires PHP: 7.4
 */
if ( ! defined( 'ABSPATH' ) ) exit;
define( 'DLVD5_VERSION', '1.1.0' );
define( 'DLVD5_PATH', plugin_dir_path( __FILE__ ) );
define( 'DLVD5_URL', plugin_dir_url( __FILE__ ) );
require_once DLVD5_PATH . 'server/index.php';
add_action( 'wp_enqueue_scripts', function() {
    wp_register_style( 'dlvd5-style', DLVD5_URL . 'assets/css/lazy-video.css', [], DLVD5_VERSION );
    wp_register_script( 'dlvd5-player', DLVD5_URL . 'assets/js/lazy-video.js', [], DLVD5_VERSION, true );
} );
add_action( 'divi_visual_builder_assets_before_enqueue_scripts', function() {
    if ( function_exists( 'et_core_is_fb_enabled' ) && et_core_is_fb_enabled() && function_exists( 'et_builder_d5_enabled' ) && et_builder_d5_enabled() ) {
        \ET\Builder\VisualBuilder\Assets\PackageBuildManager::register_package_build( [
            'name' => 'deerwood-lazy-video-divi-5-visual-builder',
            'version' => DLVD5_VERSION,
            'script' => [
                'src' => DLVD5_URL . 'visual-builder/build/deerwood-lazy-video-divi-5.js',
                'deps' => [ 'react', 'divi-module-library', 'jquery', 'divi-module-library', 'wp-hooks', 'divi-rest' ],
                'enqueue_top_window' => false,
                'enqueue_app_window' => true,
            ],
        ] );
    }
} );
