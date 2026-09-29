<?php
/**
 * Plugin Name: Deerwood Lazy Video for Divi
 * Description: Lightweight click-to-load YouTube module for Divi 4 and Divi 5. Loads the YouTube player only after Play is clicked.
 * Version: 1.3.5
 * Author: Deerwood Media
 * Author URI: https://deerwoodmedia.com/
 * License: GPL-2.0-or-later
 * Requires PHP: 7.4
 * Text Domain: deerwood-lazy-video-divi
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'DLVD_VERSION', '1.3.5' );
define( 'DLVD_FILE', __FILE__ );
define( 'DLVD_URL', plugin_dir_url( __FILE__ ) );
define( 'DLVD_PATH', plugin_dir_path( __FILE__ ) );

function dlvd_is_divi_5() {
    return function_exists( 'et_builder_d5_enabled' ) && et_builder_d5_enabled();
}

function dlvd_register_assets() {
    wp_register_style( 'dlvd-style', DLVD_URL . 'assets/css/lazy-video.css', array(), DLVD_VERSION );
    wp_register_script( 'dlvd-script', DLVD_URL . 'assets/js/lazy-video.js', array(), DLVD_VERSION, true );
    wp_register_style( 'dlvd5-style', DLVD_URL . 'assets/css/lazy-video.css', array(), DLVD_VERSION );
    wp_register_script( 'dlvd5-player', DLVD_URL . 'assets/js/lazy-video.js', array(), DLVD_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'dlvd_register_assets', 1 );

function dlvd_load_divi_5() {
    if ( ! dlvd_is_divi_5() ) { return; }
    $dependency = ABSPATH . 'wp-content/themes/Divi/includes/builder-5/server/Framework/DependencyManagement/Interfaces/DependencyInterface.php';
    $server = DLVD_PATH . 'includes/divi5/server/index.php';
    if ( file_exists( $dependency ) && file_exists( $server ) ) { require_once $server; }
}
add_action( 'after_setup_theme', 'dlvd_load_divi_5', 20 );

function dlvd_register_divi_4_module() {
    if ( dlvd_is_divi_5() || ! class_exists( 'ET_Builder_Module' ) ) { return; }
    require_once DLVD_PATH . 'includes/class-deerwood-lazy-video-module.php';
    new Deerwood_Lazy_Video_Module();
}
add_action( 'et_builder_ready', 'dlvd_register_divi_4_module' );

function dlvd_divi_4_builder_assets() {
    if ( dlvd_is_divi_5() ) { return; }
    wp_enqueue_style( 'dlvd-style' );
    wp_enqueue_script( 'dlvd-script' );
}
add_action( 'et_builder_framework_loaded', 'dlvd_divi_4_builder_assets' );

function dlvd_divi_4_visual_builder_assets() {
    if ( dlvd_is_divi_5() ) { return; }
    if ( function_exists( 'et_core_is_fb_enabled' ) && et_core_is_fb_enabled() ) {
        wp_enqueue_script( 'dlvd-visual-builder', DLVD_URL . 'assets/js/visual-builder.js', array( 'react', 'jquery' ), DLVD_VERSION, true );
        wp_enqueue_style( 'dlvd-style' );
    }
}
add_action( 'wp_enqueue_scripts', 'dlvd_divi_4_visual_builder_assets', 20 );

function dlvd_divi_5_visual_builder_assets() {
    if ( ! dlvd_is_divi_5() || ! class_exists( '\\ET\\Builder\\VisualBuilder\\Assets\\PackageBuildManager' ) ) { return; }
    \ET\Builder\VisualBuilder\Assets\PackageBuildManager::register_package_build( array(
        'name' => 'deerwood-lazy-video-divi-5-visual-builder',
        'version' => DLVD_VERSION,
        'script' => array(
            'src' => DLVD_URL . 'includes/divi5/visual-builder/build/deerwood-lazy-video-divi-5.js',
            'deps' => array( 'react', 'jquery', 'divi-module-library', 'wp-hooks', 'divi-rest' ),
            'enqueue_top_window' => false,
            'enqueue_app_window' => true,
        ),
    ) );
}
add_action( 'divi_visual_builder_assets_before_enqueue_scripts', 'dlvd_divi_5_visual_builder_assets' );

/**
 * GitHub release updater.
 * Public releases should include an asset named deerwood-lazy-video-divi.zip.
 */
function dlvd_github_release() {
    $cached = get_site_transient( 'dlvd_github_release' );
    if ( false !== $cached ) { return $cached; }

    $response = wp_remote_get(
        'https://api.github.com/repos/deerwoodmedia/deerwood-lazy-video-divi/releases/latest',
        array( 'timeout' => 5, 'headers' => array( 'Accept' => 'application/vnd.github+json' ) )
    );
    if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
        set_site_transient( 'dlvd_github_release', array(), HOUR_IN_SECONDS );
        return array();
    }

    $release = json_decode( wp_remote_retrieve_body( $response ), true );
    if ( ! is_array( $release ) ) { return array(); }
    set_site_transient( 'dlvd_github_release', $release, 6 * HOUR_IN_SECONDS );
    return $release;
}

function dlvd_update_package( $release ) {
    if ( empty( $release['assets'] ) || ! is_array( $release['assets'] ) ) { return ''; }
    foreach ( $release['assets'] as $asset ) {
        if ( isset( $asset['name'], $asset['browser_download_url'] ) && 'deerwood-lazy-video-divi.zip' === $asset['name'] ) {
            return esc_url_raw( $asset['browser_download_url'] );
        }
    }
    return '';
}

function dlvd_check_for_update( $transient ) {
    if ( empty( $transient->checked ) ) { return $transient; }
    $release = dlvd_github_release();
    $version = isset( $release['tag_name'] ) ? ltrim( $release['tag_name'], 'vV' ) : '';
    $package = dlvd_update_package( $release );

    if ( $version && $package && version_compare( DLVD_VERSION, $version, '<' ) ) {
        $plugin = plugin_basename( DLVD_FILE );
        $transient->response[ $plugin ] = (object) array(
            'slug' => 'deerwood-lazy-video-divi',
            'plugin' => $plugin,
            'new_version' => $version,
            'url' => 'https://github.com/deerwoodmedia/deerwood-lazy-video-divi',
            'package' => $package,
        );
    }
    return $transient;
}
add_filter( 'pre_set_site_transient_update_plugins', 'dlvd_check_for_update' );

function dlvd_plugin_info( $result, $action, $args ) {
    if ( 'plugin_information' !== $action || empty( $args->slug ) || 'deerwood-lazy-video-divi' !== $args->slug ) { return $result; }
    $release = dlvd_github_release();
    $version = isset( $release['tag_name'] ) ? ltrim( $release['tag_name'], 'vV' ) : DLVD_VERSION;
    return (object) array(
        'name' => 'Deerwood Lazy Video for Divi',
        'slug' => 'deerwood-lazy-video-divi',
        'version' => $version,
        'author' => '<a href="https://deerwoodmedia.com/">Deerwood Media</a>',
        'homepage' => 'https://deerwoodmedia.com/',
        'sections' => array(
            'description' => 'A lightweight click-to-load YouTube module for Divi 4 and Divi 5.',
            'changelog' => isset( $release['body'] ) ? wp_kses_post( $release['body'] ) : '',
        ),
        'download_link' => dlvd_update_package( $release ),
    );
}
add_filter( 'plugins_api', 'dlvd_plugin_info', 20, 3 );
