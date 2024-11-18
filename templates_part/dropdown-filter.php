<?php
    $tax = $args['taxonomy'] ?? false;
    $tax_plural = $args['tax_plural'] ?? false;
    $name = $args['name'] ?? false;
    if( !$tax || !$tax_plural || !$name ) {
        wp_die('Un ou plusieurs arguments ne sont pas renseigner, le filtre ne peut fonctionner.',400);
    }

    $filter = "filterBy".ucfirst($tax_plural);

    $button = '<button class="dropdown__toggle form-text form-text__label" type="button" id="%1$s" data-name="%2$s">%2$s</button>';
    $menu = '<div class="dropdown__menu" aria-labelledby="%s">';

    echo '<div class="dropdown">';
        echo sprintf($button, $filter, $name);
        echo sprintf($menu, $filter);

            $terms = get_terms(["taxonomy" => $tax]);
            $ajax_url = admin_url( "admin-ajax.php" );
            $ajax_action = "motaphoto_filter_".$tax_plural;
            $ajax_nonce = wp_create_nonce( $ajax_action );

            for($i = 0; $i < count($terms); $i++) {
                $term_name = $terms[$i]->name;
                $term_slug = $terms[$i]->slug;
                $item = '<a href="#" class="dropdown__menu__item form-text" data-ajaxurl="%s" data-action="%s" data-nonce="%s" data-filter="%s">%s</a>';
                echo sprintf($item, $ajax_url, $ajax_action, $ajax_nonce, $term_slug, $term_name);
            }

        echo '</div>';
    echo '</div>';

?>
