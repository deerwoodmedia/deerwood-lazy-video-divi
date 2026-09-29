<?php
/**
 * Plugin Name: Deerwood Lazy Video Divi Module
 * Description: Lightweight click-to-load YouTube video module for Divi. Avoids loading the YouTube iframe until the visitor clicks play.
 * Version: 1.1.1
 * Author: Deerwood Media
 * Text Domain: deerwood-lazy-video-divi
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'DLVD_VERSION', '1.1.1' );
define( 'DLVD_FILE', __FILE__ );
define( 'DLVD_URL', plugin_dir_url( __FILE__ ) );
define( 'DLVD_PATH', plugin_dir_path( __FILE__ ) );

function dlvd_register_module() {
    if ( ! class_exists( 'ET_Builder_Module' ) ) { return; }
    require_once DLVD_PATH . 'includes/class-deerwood-lazy-video-module.php';
    new Deerwood_Lazy_Video_Module();
}
add_action( 'et_builder_ready', 'dlvd_register_module' );

function dlvd_enqueue_assets() {
    wp_register_style( 'dlvd-style', DLVD_URL . 'assets/css/lazy-video.css', array(), DLVD_VERSION );
    wp_register_script( 'dlvd-script', DLVD_URL . 'assets/js/lazy-video.js', array(), DLVD_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'dlvd_enqueue_assets' );

function dlvd_builder_assets() {
    wp_enqueue_style( 'dlvd-style' );
    wp_enqueue_script( 'dlvd-script' );
}
add_action( 'et_builder_framework_loaded', 'dlvd_builder_assets' );

/**
 * Divi 4 Visual Builder component.
 *
 * Full Visual Builder support requires a JavaScript component whose slug
 * matches the PHP module slug. Loading this only while the front-end builder
 * is active keeps it off normal visitor page loads.
 */
function dlvd_visual_builder_assets() {
    if ( function_exists( 'et_core_is_fb_enabled' ) && et_core_is_fb_enabled() ) {
        wp_enqueue_script(
            'dlvd-visual-builder',
            DLVD_URL . 'assets/js/visual-builder.js',
            array( 'react', 'jquery' ),
            DLVD_VERSION,
            true
        );
        wp_enqueue_style( 'dlvd-style' );
    }
}
add_action( 'wp_enqueue_scripts', 'dlvd_visual_builder_assets', 20 );
