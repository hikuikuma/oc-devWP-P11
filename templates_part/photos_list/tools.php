<div class="photos-list__tools">
    <?php
        get_template_part('templates_part/dropdown-filter', null, ['taxonomy' => 'categorie', 'tax_plural' => 'categories', 'name' => 'Catégories']);
        get_template_part('templates_part/dropdown-filter', null, ['taxonomy' => 'format', 'tax_plural' => 'formats', 'name' => 'Formats'])
    ?>
    <div class="dropdown dropdown-date-sorter">
        <button class="dropdown__toggle form-text form-text__label" type="button" id="sortByDate" data-name="Trier par date">Trier par date</button>
        <div class="dropdown__menu" aria-labelledby="sortByDate">
        <?php
            $sorters = [
                ['filter' => 'date-desc', 'name' => 'A partir des plus récentes'],
                ['filter' => 'date-asc', 'name' => 'A partir des plus anciennes'],
            ];
            $ajax_url = admin_url( "admin-ajax.php" );
            $ajax_action = "motaphoto_sorter";
            $ajax_nonce = wp_create_nonce( $ajax_action );
            foreach($sorters as $sorter) {
                $item = '<a href="#" class="dropdown__menu__item form-text" data-ajaxurl="%s" data-action="%s" data-nonce="%s" data-filter="%s">%s</a>';
                echo sprintf($item, $ajax_url, $ajax_action, $ajax_nonce, $sorter['filter'], $sorter['name']);
            }
        ?>
        </div>
    </div>
</div>
