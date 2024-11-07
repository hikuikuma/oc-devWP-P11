<?php

function motaphoto_setup() {
    register_nav_menus(
        array(
            'header-navbar' => __('Header Menu'),
            'footer' => __('Footer Menu')
        )
    );
}

function motaphoto_enqueue_scripts() {
    wp_enqueue_script('motaphoto-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0', true);
    wp_enqueue_style('motaphoto-google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,500;1,300&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap', array(), null, 'all');
    wp_enqueue_style('motaphoto-style', get_template_directory_uri() . '/style.css', array(), time(), 'all');
}

function motaphoto_supports() {
    add_theme_support( 'title-tag' );

    add_theme_support('post-thumbnails');
    add_image_size('photo-thumbnail', 300,300, array('center', 'center'));

}

function get_terms_name($postid,$taxonomy) {
    $term_obj_list = get_the_terms( $postid, $taxonomy );
    $term_name_array = wp_list_pluck( $term_obj_list, 'name' );
    echo $term_name_array[array_key_first($term_name_array)];
}

add_action( 'init', 'motaphoto_setup');
add_action( 'wp_enqueue_scripts', 'motaphoto_enqueue_scripts' );
add_action( 'after_setup_theme', 'motaphoto_supports' );

add_filter("manage_photo_posts_columns", 'set_custom_edit_photo_columns');
function set_custom_edit_photo_columns($columns){
    $columns['categories'] = 'Catégorie';
    $columns['formats'] = 'Format';
    $columns['type'] = 'Type';
    $columns['ref'] = 'Référence';
    return $columns;
};
add_action("manage_photo_posts_custom_column", 'custom_photo_column', 10, 2);
function custom_photo_column($column, $post_id){
    switch($column) {
        case 'categories':
            $terms = get_the_terms($post_id, 'categorie');
            if( is_string($terms) )
                echo $terms;
            else
                _e( 'Catégorie non trouvée', 'category_not_found' );
            break;
        case 'formats':
            $terms = get_the_term_list($post_id, 'format', '', ',', '');
            if( is_string($terms) )
                echo $terms;
            else
                _e( 'Format', 'format_not_found' );
            break;
        case 'type':
            the_field('type',$post_id);
            break;
        case 'ref':
            the_field('reference',$post_id);
            break;
    }
}