<?php
get_header();

echo '<main class="site-content">';

/* Start the Loop */
while ( have_posts() ) :
    the_post();

?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="entry-header">
            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
            <?php has_post_thumbnail() ? the_post_thumbnail() : null; ?>
        </header>

        <div class="entry-content">
            <?php the_content(); ?>
        </div>

    </article>

<?php

    // If comments are open or there is at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) {
        comments_template();
    }
endwhile; // End of the loop.

echo '</main>';

get_footer();
