<div class="listed-photo">
    <div class="listed-photo__infos">
        <a href="<?php the_permalink(); ?>" class="listed-photo__infos__view"></a>
        <?php
            $ajax_url = admin_url( 'admin-ajax.php' );
            $ajax_action = "motaphoto_photo_query";
            $ajax_nonce = wp_create_nonce( $ajax_action );
            $ajax_ref = get_field('reference');
            $ajax_id = $post->ID;
            $item = '<a href="%s" class="listed-photo__infos__fullscreen" data-action="%s" data-nonce="%s" data-ref="%s" data-id="%s"></a>';
            echo sprintf($item, $ajax_url, $ajax_action, $ajax_nonce, $ajax_ref, $ajax_id);
        ?>

        <span class="listed-photo__infos__reference tags"><?php the_field('reference'); ?></span>
        <span class="listed-photo__infos__category tags"><?php the_term_name( $post->ID, 'categorie' ); ?></span>
    </div>
    <?php
        the_post_thumbnail('', ['class' => 'listed-photo__image']);
    ?>
</div>
