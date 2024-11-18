<div class="listed-photo">
    <div class="listed-photo__infos">
        <a href="<?php the_permalink(); ?>" class="listed-photo__infos__view"></a>
        <a href="<?php the_field('reference'); ?>" class="listed-photo__infos__fullscreen"></a>
        <span class="listed-photo__infos__reference tags"><?php the_field('reference'); ?></span>
        <span class="listed-photo__infos__category tags"><?php the_term_name( $post->ID, 'categorie' ); ?></span>
    </div>
    <?php
        the_post_thumbnail('', ['class' => 'listed-photo__image']);
    ?>
</div>
