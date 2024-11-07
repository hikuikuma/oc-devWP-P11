<div class="photos-list__list">
    <?php $photos = new WP_Query([
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'order_by' => 'id',
        'order' => 'asc'
    ]);
    ?>

    <?php if($photos->have_posts()): ?>
        <?php
        while($photos->have_posts()) : $photos->the_post();
            get_template_part('templates_part/photos_list/photo');
        endwhile;
        ?>
    <?php endif; ?>
</div>