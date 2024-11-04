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

add_action( 'init', 'motaphoto_setup');
add_action( 'wp_enqueue_scripts', 'motaphoto_enqueue_scripts' );
add_action( 'after_setup_theme', 'motaphoto_supports' );