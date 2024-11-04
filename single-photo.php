<?php
get_header();

/* Start the Loop */
while ( have_posts() ) :
    the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="photo__header">
            <?php the_title('<h2 class="photo__header__title">', '</h2>'); ?>
            <p class="photo__header__tags tags">Référence : <?php the_field('reference'); ?></p>
            <p class="photo__header__tags tags">Catégorie : </p>
            <p class="photo__header__tags tags">Format : </p>
            <p class="photo__header__tags tags">Type : <?php the_field('type'); ?></p>
            <p class="photo__header__tags tags">Année : <?php the_date('Y'); ?> </p>
            <?php has_post_thumbnail() ? the_post_thumbnail('photo-thumbnail') : null; ?>
        </header>

        <div class="entry-content">
            <?php the_content(); ?>
        </div>

    </article>

<?php endwhile; // End of the loop.

get_footer();