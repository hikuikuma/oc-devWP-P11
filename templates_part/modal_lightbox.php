<?php
    $ajax_url = admin_url( 'admin-ajax.php' );
    $ajax_action = "motaphoto_photo_query";
    $ajax_nonce = wp_create_nonce( $ajax_action );
?>

<div class="modal__lightbox">

    <div class="modal__lightbox__closer"></div>
    <div class="modal__lightbox__content">
        <div class="lightbox__previous">
            <?php
            $item = '<a href="%s" id="previousLightbox" class="lightbox__nav tags" data-action="%s" data-nonce="%s" data-id="0">Précédente</a>';
            echo sprintf($item, $ajax_url, $ajax_action, $ajax_nonce);
            ?>
        </div>
        <div class="lightbox__media">
            <div class="lightbox__media__infos">
                <span class="infos__reference tags">Référence de la photo</span>
                <span class="infos__categorie tags">Catégorie</span>
            </div>
        </div>
        <div class="lightbox__next">
            <?php
            $item = '<a href="%s" id="nextLightbox" class="lightbox__nav tags" data-action="%s" data-nonce="%s" data-id="0">Suivante</a>';
            echo sprintf($item, $ajax_url, $ajax_action, $ajax_nonce);
            ?>
        </div>

    </div>
    
</div>
