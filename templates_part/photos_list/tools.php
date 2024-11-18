<div class="photos-list__tools">
    <div class="dropdown">
        <button class="dropdown__toggle form-text form-text__label" type="button" id="filterByCategories">Catégories</button>
        <div class="dropdown__menu" aria-labelledby="filterByCategories">
            <?php
                $tax = "categorie"; $terms = get_terms(["taxonomy" => $tax]);
                $ajax_url = admin_url( "admin-ajax.php" );
                $ajax_action = "motaphoto_filter_categories";
                $ajax_nonce = wp_create_nonce( "motaphoto_filter_categories" );
                for($i = 0; $i < count($terms); $i++) {
                    $term_name = $terms[$i]->name;
                    $term_slug = $terms[$i]->slug;
                    $item = '<a href="#" class="dropdown__menu__item form-text" data-ajaxurl="%s" data-action="%s" data-nonce="%s" data-filter="%s">%s</a>';
                    echo sprintf($item, $ajax_url, $ajax_action, $ajax_nonce, $term_slug, $term_name);
                }
            ?>
        </div>
    </div>
    <div class="dropdown">
        <button class="dropdown__toggle form-text form-text__label" type="button" id="filterByFormats">Formats</button>
        <div class="dropdown__menu" aria-labelledby="filterByFormats">
            <?php
                $tax = "format"; $terms = get_terms(["taxonomy" => $tax]);
                $ajax_url = admin_url( "admin-ajax.php" );
                $ajax_action = "motaphoto_filter_formats";
                $ajax_nonce = wp_create_nonce( "motaphoto_filter_formats" );
                for($i = 0; $i < count($terms); $i++) {
                    $term_name = $terms[$i]->name;
                    $term_slug = $terms[$i]->slug;
                    $item = '<a href="#" class="dropdown__menu__item form-text" data-ajaxurl="%s" data-action="%s" data-nonce="%s" data-filter="%s">%s</a>';
                    echo sprintf($item, $ajax_url, $ajax_action, $ajax_nonce, $term_slug, $term_name);
                }
            ?>
        </div>
    </div>
    <div class="dropdown dropdown-date-sorter">
        <button class="dropdown__toggle form-text form-text__label" type="button" id="sortByDate">Trier par date</button>
        <div class="dropdown__menu" aria-labelledby="sortByDate">
        <?php
            $sorters = [
                ['filter' => 'date-desc', 'name' => 'A partir des plus récentes'],
                ['filter' => 'date-asc', 'name' => 'A partir des plus anciennes'],
            ];
            $ajax_url = admin_url( "admin-ajax.php" );
            $ajax_action = "motaphoto_sorter";
            $ajax_nonce = wp_create_nonce( "motaphoto_sorter" );
            foreach($sorters as $sorter) {
                $item = '<a href="#" class="dropdown__menu__item form-text" data-ajaxurl="%s" data-action="%s" data-nonce="%s" data-filter="%s">%s</a>';
                echo sprintf($item, $ajax_url, $ajax_action, $ajax_nonce, $sorter['filter'], $sorter['name']);
            }
        ?>
        </div>
    </div>
</div>
