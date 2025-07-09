<?php
/*
Plugin Name: Gn Custom Post Selector
Plugin URI:  https://www.georgenicolaou.me/plugins/gn-custom-post-selector
Description: A Divi Builder Module that allows a user to add a title and select the post from any post type to dosplay as a list
Version:     1.0.8
Author:      George Nicolaou
Author URI:  httgps://www.georgenicolaou.me
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: gnwebdevcy-gn-custom-post-selector
Domain Path: /languages

Gn Custom Post Selector is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Gn Custom Post Selector is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Gn Custom Post Selector. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/


if ( ! function_exists( 'gnwebdevcy_initialize_extension' ) ):
/**
 * Creates the extension's main class instance.
 *
 * @since 1.0.0
 */
function gnwebdevcy_initialize_extension() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/GnCustomPostSelector.php';
}
add_action( 'divi_extensions_init', 'gnwebdevcy_initialize_extension' );
endif;

// Set up the GitHub-based update checker.
if ( ! class_exists( '\\YahnisElsts\\PluginUpdateChecker\\v5\\PucFactory' ) ) {
       require_once plugin_dir_path( __FILE__ ) . 'includes/plugin-update-checker/plugin-update-checker.php';
}
$gncps_update_checker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
       'https://github.com/GeorgeWebDevCy/gn-custom-post-selector/',
       __FILE__,
       'gn-custom-post-selector'
);
$gncps_update_checker->setBranch( 'main' );

function gncps_enqueue_builder_assets() {
    wp_enqueue_script(
        'gncps-admin',
        plugin_dir_url( __FILE__ ) . 'scripts/admin.js',
        array( 'jquery' ),
        '1.0.8',
        true
    );
}
add_action( 'admin_enqueue_scripts', 'gncps_enqueue_builder_assets' );
add_action( 'wp_enqueue_scripts', 'gncps_enqueue_builder_assets' );
add_action( 'wp_ajax_gncps_get_posts', 'gncps_get_posts' );
add_action( 'wp_ajax_nopriv_gncps_get_posts', 'gncps_get_posts' );
function gncps_get_posts() {
    $post_type = isset( $_GET['post_type'] ) ? sanitize_text_field( $_GET['post_type'] ) : 'post';
    $search    = isset( $_GET['search'] ) ? sanitize_text_field( $_GET['search'] ) : '';
    $args = array(
        'post_type'      => $post_type,
        'posts_per_page' => 20,
        's'              => $search,
    );
    $posts = get_posts( $args );
    $options = array();
    foreach ( $posts as $post ) {
        $options[] = array(
            'id'    => $post->ID,
            'title' => $post->post_title,
        );
    }
    wp_send_json_success( $options );
}
