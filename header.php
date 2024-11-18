<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header class="site-header">
        <div class="site-header__content">
            <a href="<?= get_option('home'); ?>" class="site-header__content__logo"></a>
            <?php wp_nav_menu( [
                'container' => 'nav',
                'container_class' => 'navbar',
                'container_aria_label' => 'Navigation',
                'theme_location' => 'header-navbar'
            ] ); ?>
        </div>

    </header>
