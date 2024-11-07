<?php
get_header();
?>
<main class="site-content">
<?php
/* Start the Loop */
while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="photo__content">
            <header class="photo__content__header">
                <?php the_title('<h2 class="photo__header__title">', '</h2>'); ?>
                <p class="photo__content__header__tags tags">Référence : <?php the_field('reference'); ?></p>
                <p class="photo__content__header__tags tags">Catégorie : <?php get_terms_name( $post->ID, 'categorie' ); ?></p>
                <p class="photo__content__header__tags tags">Format : <?php get_terms_name( $post->ID, 'format' ); ?></p>
                <p class="photo__content__header__tags tags">Type : <?php the_field('type'); ?></p>
                <p class="photo__content__header__tags tags">Année : <?php the_date('Y'); ?> </p>
            </header>
            <div class="photo__content__thumbnail">
                <?php has_post_thumbnail() ? the_post_thumbnail('', ['class' => 'photo__content__thumbnail__image']) : null; ?>
            </div>
        </div>

        <div class="photo__tools">
            <div class="photo__tools__cta">
                <p>Cette photo vous intéresse?</p>
                <button class="cta btn-contact" data-photo="<?php the_field('reference'); ?>">Contact</button>
            </div>
        </div>

    </article>

<?php endwhile; // End of the loop. ?>
</main>
<?php
get_footer();
