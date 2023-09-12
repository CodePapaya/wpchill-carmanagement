<?php
/*
Plugin Name: wpchill-carmanagement
*/

function register_custom_post_type() {
    $labels = array(
        'name'               => _x('Cars', 'post type general name'),
        'singular_name'      => _x('Car', 'post type singular name'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'car'),
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'thumbnail'),
        'taxonomies'         => array('manufacturer'),
    );

    register_post_type('car', $args);
}
add_action('init', 'register_custom_post_type');

function register_manufacturer_taxonomy() {
    $args = array(
        'hierarchical'      => true,
        'labels'            => array(
            'name'              => _x('Manufacturers', 'taxonomy general name'),
            'singular_name'     => _x('Manufacturer', 'taxonomy singular name'),
        ),
        'public'            => true,
        'show_in_nav_menus' => true,
        'show_admin_column' => true,
        'rewrite'           => array('slug' => 'manufacturer'),
    );

    register_taxonomy('manufacturer', 'car', $args);
}
add_action('init', 'register_manufacturer_taxonomy');

function generate_test_cars() {
    $count = wp_count_posts('car')->publish;
    if ($count == 0) {
        for ($i = 0; $i < 10; $i++) {
            $car_data = array(
                'post_title'    => 'Sample Car ' . ($i + 1),
                'post_type'     => 'car',
                'post_status'   => 'publish',
            );

            $car_id = wp_insert_post($car_data);

            wp_set_object_terms($car_id, 'Manufacturer ' . ($i % 3 + 1), 'manufacturer');
            update_post_meta($car_id, 'model', 'Model ' . ($i + 1));
            update_post_meta($car_id, 'fuel_type', 'Fuel Type ' . ($i % 2 == 0 ? 'Gasoline' : 'Diesel'));
            update_post_meta($car_id, 'price', rand(10000, 50000));
            update_post_meta($car_id, 'color', 'Color ' . ($i % 3 == 0 ? 'Red' : ($i % 3 == 1 ? 'Blue' : 'Green')));
        }
    }
}
register_activation_hook(__FILE__, 'generate_test_cars');

function car_list_shortcode($atts) {
    $atts = shortcode_atts(array(
        'show_filter' => 1,
        'manufacturer' => '',
        'model' => '',
        'fuel_type' => '',
        'color' => '',
    ), $atts);

    ob_start();
    $output = ob_get_clean();
    return $output;
}
add_shortcode('car_list', 'car_list_shortcode');

function register_gutenberg_block() {
    wp_register_script(
        'wpchill-carmanagement-block',
        plugins_url('block.js', __FILE__),
        array('wp-blocks', 'wp-element')
    );

    register_block_type('wpchill/car-block', array(
        'editor_script' => 'wpchill-carmanagement-block',
    ));
}
add_action('init', 'register_gutenberg_block');


