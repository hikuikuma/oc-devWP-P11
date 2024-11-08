<?php

function motaphoto_init() {
    add_theme_support( 'title-tag' );

    add_theme_support('post-thumbnails');
    add_image_size('photo-thumbnail', 300,300, array('center', 'center'));

    register_nav_menus(
        array(
            'header-navbar' => __('Header Menu'),
            'footer' => __('Footer Menu')
        )
    );
}

function motaphoto_admin_init() {
    remove_post_type_support('photo', 'editor');
}

function motaphoto_enqueue_scripts() {
    wp_enqueue_script('motaphoto-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0', true);
    wp_enqueue_style('motaphoto-google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,500;1,300&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap', array(), null, 'all');
    wp_enqueue_style('motaphoto-style', get_template_directory_uri() . '/style.css', array(), time(), 'all');
}

function get_terms_name($postid, $taxonomy) {
    $term_obj_list = get_the_terms( $postid, $taxonomy );
    $term_name_array = wp_list_pluck( $term_obj_list, 'name' );
    echo $term_name_array[array_key_first($term_name_array)];
}

function manage_photo_columns($columns){
    unset ( $columns['date'] );
    $columns['reference'] = get_field_object('reference')['label'];
    $columns['categorie'] = get_taxonomy_labels(get_taxonomy('categorie'))->name;
    $columns['formats'] = get_taxonomy_labels(get_taxonomy('format'))->singular_name;
    $columns['type'] = get_field_object('type')['label'];
    $columns['year'] = 'Année';
    $columns['status'] = 'État';
    return $columns;
}

function custom_photo_column($column, $post_id){
    switch($column) {
        case 'reference':
            echo get_field('reference');
            break;
        case 'categorie':
            $terms = get_the_term_list($post_id, 'categorie', '', ',', '');
            if( is_string($terms) )
                echo $terms;
            else
                echo get_taxonomy_labels(get_taxonomy('categorie'))->no_terms;
            break;
        case 'formats':
            $terms = get_the_term_list($post_id, 'format', '', ',', '');
            if( is_string($terms) )
                echo $terms;
            else
                _e( 'Format', 'format_not_found' );
            break;
        case 'type':
            echo get_field('type')['label'];
            break;
        case 'year':
            echo get_the_date('Y');
            break;
        case 'status':
            echo get_post_status_object( get_post_status( ) )->label;
            break;
    }
}


add_action( 'init', 'motaphoto_init');
add_action( 'admin_init', 'motaphoto_admin_init');
add_action( 'wp_enqueue_scripts', 'motaphoto_enqueue_scripts' );

add_filter( 'manage_photo_posts_columns', 'manage_photo_columns' );
add_action( 'manage_photo_posts_custom_column', 'custom_photo_column', 10, 2);