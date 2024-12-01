<?php
include_once get_template_directory().'/functions/admin.php';
include_once get_template_directory().'/functions/customs.php';
include_once get_template_directory().'/functions/ajax.php';

function motaphoto_init() {
    add_theme_support('title-tag');

    add_theme_support('post-thumbnails');
    add_image_size('photo-thumbnail', 300, 300, array('center', 'center'));

    register_nav_menus(['header-navbar' => __('Header Menu'), 'footer' => __('Footer Menu')]);
}

function motaphoto_enqueue_scripts() {
    wp_enqueue_script('motaphoto-scripts-modals', get_template_directory_uri().'/js/modals.js', array('jquery'), '1.0', true);
    wp_enqueue_script('motaphoto-scripts-photos', get_template_directory_uri().'/js/photos.js', array('jquery'), '1.0', true);
    wp_enqueue_script('motaphoto-scripts-menus', get_template_directory_uri().'/js/menus.js', array('jquery'), '1.0', true);
    wp_enqueue_style('motaphoto-google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,500;1,300&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap', array(), null, 'all');
    wp_enqueue_style('motaphoto-style', get_template_directory_uri().'/style.css', array(), time(), 'all');
}

add_action('init', 'motaphoto_init');
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_scripts');
