<?php
get_header();
?>

<div class="hero">
    <h1>Photographe event</h1>
</div>

<main class="site-content">
    <div class="photos-list">
        <?php get_template_part('templates_part/photos_list/tools'); ?>
        <?php get_template_part('templates_part/photos_list/photos'); ?>
    </div>
</main>


<?php
get_footer();