<?php
get_header();

echo '<main class="site-content">';

/* Start the Loop */

$this_post = get_the_ID();

if (!have_posts()) {wp_die('The query with ID '.$this_post.' returns no results', 404);}
while ( have_posts() ) {
the_post();
$prev_post = get_previous_photo(get_previous_post(), 'post', 'date');
$next_post = get_next_photo(get_next_post(), 'post', 'date');
$categorie = get_term_name( $this_post, 'categorie' );
?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="photo__content">
            <header class="photo__content__header">
                <?php the_title('<h2 class="photo__header__title">', '</h2>'); ?>
                <p class="photo__content__header__tags tags">Référence : <?php the_field('reference'); ?></p>
                <p class="photo__content__header__tags tags">Catégorie : <?php the_term_name( $this_post, 'categorie' ); ?></p>
                <p class="photo__content__header__tags tags">Format : <?php the_term_name( $this_post, 'format' ); ?></p>
                <p class="photo__content__header__tags tags">Type : <?php echo get_field('type')['label']; ?></p>
                <p class="photo__content__header__tags tags">Année : <?php the_date('Y'); ?> </p>
            </header>
            <div class="photo__content__thumbnail">
                <?php has_post_thumbnail() ? the_post_thumbnail('', ['class' => 'photo__content__thumbnail__image']) : null; ?>
            </div>
        </div>

        <div class="photo__tools">
            <div class="photo__tools__cta">
                <p>Cette photo vous intéresse ?</p>
                <button class="cta btn-contact" data-photo="<?php the_field('reference'); ?>">Contact</button>
            </div>
            <div class="photo__tools__navigation">
                <div class="photo__navigation__image"></div>
                <a class="photo__navigation__arrow photo__navigation__arrow-left" href="<?= get_post_permalink($prev_post); ?>" alt="Photo précédente">
                    <img src="<?= get_the_post_thumbnail_url($prev_post); ?>" alt="<?= get_the_title($prev_post); ?>">
                </a>
                <a class="photo__navigation__arrow photo__navigation__arrow-right" href="<?= get_post_permalink($next_post); ?>" alt="Photo suivante">
                    <img src="<?= get_the_post_thumbnail_url($next_post); ?>" alt="<?= get_the_title($next_post); ?>">
                </a>
            </div>
        </div>

    </article>

<?php } // End of the loop.
    $paging = 2;
    $photos = new WP_Query([
        'post_type' => 'photo',
        'posts_per_page' => $paging,
        'tax_query' => [
                [
                    'taxonomy' => 'categorie',
                    'field' => 'name',
                    'terms' => $categorie
                ],
        ],
        'order_by' => 'date',
        'order' => 'asc',
        'post__not_in' => [$this_post]
    ]); ?>
    <div class="photos-list">
        <h3 class="photos-list__title">Vous aimerez aussi</h3>
        <div class="photos-list__list">
            <?php if($photos->have_posts()) {
                while($photos->have_posts()) {
                    $photos->the_post();
                    get_template_part('templates_part/photos_list/photo');
                }
            } ?>
        </div>
    </div>
</main>
<?php
get_footer();
