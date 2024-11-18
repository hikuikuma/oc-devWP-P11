<?php
    $paging = $args['paging'] ?? 8;
    $categorie = $args['filterByCategory'] ?? '';
    $format = $args['filterByFormat'] ?? '';
    $totalPhotos = wp_count_posts('photo')->publish;
    $more = $totalPhotos > $paging;
    $photos = new WP_Query([
        'post_type' => 'photo',
        'posts_per_page' => $paging,
        'order_by' => 'id',
        'order' => 'asc'
    ]); ?>
<div class="photos-list__list" data-total="<?= $totalPhotos; ?>" data-paging="<?= $paging; ?>" data-categorie="<?= $categorie; ?>" data-format="<?= $format; ?>" data-order="id-asc">
    <?php if($photos->have_posts()) {
        while ($photos->have_posts()) {
            $photos->the_post();
            get_template_part('templates_part/photos_list/photo');
        }
    } ?>
</div>
<?php if ($more) { ?>
<div class="photos-list__load-more">
    <button class="photos-list__more-button cta"
            data-ajaxurl="<?= admin_url( 'admin-ajax.php' ); ?>"
            data-action="motaphoto_load_more"
            data-nonce="<?= wp_create_nonce('motaphoto_load_more'); ?>"
            data-categorie="<?= $categorie; ?>"
            data-format="<?= $format; ?>"
            data-paging="<?= $paging; ?>"
            data-loaded="<?= $paging; ?>"
            data-order="id-asc"
    >Charger plus</button>
</div>
<?php } ?>
