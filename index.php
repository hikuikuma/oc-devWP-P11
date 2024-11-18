<?php
get_header();
?>

<?php $hero = new WP_Query([
    'post_type' => 'photo',
    'posts_per_page' => 1,
    'orderby' => 'rand',
    'tax_query' => [
        [
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => 'paysage'
        ]
    ]
]); if($hero->have_posts()) { while ($hero->have_posts()) {
    $hero->the_post();
    $hero_image_url = get_the_post_thumbnail_url();
    echo sprintf('<div class="hero" style="background-image: url(%s);"><h1>Photographe event</h1></div>', $hero_image_url);
} } ?>

<main class="site-content">
    <div class="photos-list">
        <?php get_template_part('templates_part/photos_list/tools'); ?>
        <?php get_template_part('templates_part/photos_list/photos', null, ['paging' => 8, 'filterByCategory' => null, 'filterByFormat' => null]); ?>
    </div>
</main>


<?php
get_footer();
