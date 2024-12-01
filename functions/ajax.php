<?php
function test_nonce($waiting, $nonce = null) {
    return (!$nonce === null || !wp_verify_nonce($_REQUEST['nonce'], $waiting)) ? wp_send_json_error("Vous n’avez pas l’autorisation d’effectuer cette action.", 403) : true;
}

function ajaxQuery($values, $more = false) {

    // Preparing the query
    $args = [
        'post_type' => 'photo',
        'posts_per_page' => -1,
    ];

    // Loading sort method
    $args = array_merge($args, orderQuery($values['order']));
    // Checking if the format filter is set
    if ($values['format'] !== '') $args['tax_query'][] = filterQuery($values['format'], 'format');
    // Checking if the category filter is set
    if ($values['categorie'] !== '') $args['tax_query'][] = filterQuery($values['categorie'], 'categorie');
    // Added AND relationship if both filters exist
    if ($values['format'] !== '' && $values['categorie'] !== '') $args['tax_query']['relation'] = 'AND';

    // Retrieving the total number of photos with these filters
    $values['total'] = totalQuery($args);

    // Then modifying the query with the real pagination value
    $args['posts_per_page'] = $values['paging'];

    // If it's to display more photos, we skip the photos already loaded
    if ($more) $args['offset'] = $values['loaded'];

    // Execute the query
    $ajaxposts = new WP_Query($args);

    // Loading posts
    $posts = '';
    if ($ajaxposts->have_posts()) {
        while ($ajaxposts->have_posts()) {
            $ajaxposts->the_post();
            ob_start();
            get_template_part('templates_part/photos_list/photo');
            $posts .= ob_get_clean();
        }
    } else {
        $posts = 'La requête ne renvoie pas de résultats (Erreur 204)';
    }
    wp_reset_postdata();

    // Updated the number of photos loaded in a "load more" process
    if ($more) $values['loaded'] = $values['loaded'] + $values['paging'];

    // Returning information as a JSON array
    $return = [
        'values' => $values,
        'posts' => $posts,
        'args' => $args,
    ];
    wp_send_json_success($return);
}

function totalQuery($args)
{
    $ajaxposts = new WP_Query($args);

    if ($ajaxposts->have_posts()) {
        $nb_posts = $ajaxposts->found_posts;
    } else {
        $nb_posts = 0;
    }

    wp_reset_postdata();

    return $nb_posts;
}

function orderQuery($order)
{
    switch ($order) {
        case 'date-asc':
            return ['orderby' => 'date', 'order' => 'ASC'];
            break;
        case 'date-desc':
            return ['orderby' => 'date', 'order' => 'DESC'];
            break;
        case 'id-asc':
        default:
            return ['orderby' => 'id', 'order' => 'ASC'];
    }
}

function filterQuery($terms, $taxonomy) {
    return [
        'taxonomy' => $taxonomy,
        'field' => 'slug',
        'terms' => $terms
    ];
}

function motaphoto_load_more()
{
    // Security test
    if (test_nonce('motaphoto_load_more', $_REQUEST['nonce'])) {
        // Retrieving the values
        if (!isset($_POST['paging']) || !isset($_POST['format']) || !isset($_POST['categorie']) || !isset($_POST['order']) || !isset($_POST['loaded'])) {
            wp_send_json_error('Les valeurs transmisent ne sont pas valides', 400);
        }
        $values = [
            'paging' => sanitize_option('post_per_page', $_POST['paging']),
            'format' => sanitize_text_field($_POST['format']),
            'categorie' => sanitize_text_field($_POST['categorie']),
            'order' => sanitize_text_field($_POST['order']),
            'loaded' => intval($_POST['loaded'])
        ];

        ajaxQuery($values, true);
    }
    exit;
}

if (is_user_logged_in() ) add_action('wp_ajax_motaphoto_load_more', 'motaphoto_load_more');
else add_action('wp_ajax_nopriv_motaphoto_load_more', 'motaphoto_load_more');

function motaphoto_filter_categories()
{
    // Security test
    if (test_nonce('motaphoto_filter_categories', $_REQUEST['nonce'])) {
        // Retrieving the values
        if (!isset($_POST['paging']) || !isset($_POST['format']) || !isset($_POST['categorie']) || !isset($_POST['order'])) {
            wp_send_json_error('Les valeurs transmisent ne sont pas valides', 400);
        }
        $values = [
            'paging' => intval(sanitize_option('post_per_page', $_POST['paging'])),
            'format' => sanitize_text_field($_POST['format']),
            'categorie' => sanitize_text_field($_POST['categorie']),
            'order' => sanitize_text_field($_POST['order']),
        ];

        ajaxQuery($values);
    }
    exit;
}

if (is_user_logged_in() ) add_action('wp_ajax_motaphoto_filter_categories', 'motaphoto_filter_categories');
else add_action('wp_ajax_nopriv_motaphoto_filter_categories', 'motaphoto_filter_categories');

function motaphoto_filter_formats()
{
    // Security test
    if (test_nonce('motaphoto_filter_formats', $_REQUEST['nonce'])) {
        // Retrieving the values
        if (!isset($_POST['paging']) || !isset($_POST['format']) || !isset($_POST['categorie']) || !isset($_POST['order'])) {
            wp_send_json_error('Les valeurs transmisent ne sont pas valides', 400);
        }
        $values = [
            'paging' => sanitize_option('post_per_page', $_POST['paging']),
            'format' => sanitize_text_field($_POST['format']),
            'categorie' => sanitize_text_field($_POST['categorie']),
            'order' => sanitize_text_field($_POST['order']),
        ];

        ajaxQuery($values);
    }
    exit;
}

if (is_user_logged_in() ) add_action('wp_ajax_motaphoto_filter_formats', 'motaphoto_filter_formats');
else add_action('wp_ajax_nopriv_motaphoto_filter_formats', 'motaphoto_filter_formats');

function motaphoto_sorter()
{
    if (test_nonce('motaphoto_sorter', $_REQUEST['nonce'])) {
        // Retrieving the values
        if (!isset($_POST['paging']) || !isset($_POST['format']) || !isset($_POST['categorie']) || !isset($_POST['order'])) {
            wp_send_json_error('Les valeurs transmisent ne sont pas valides', 400);
        }
        $values = [
            'paging' => sanitize_option('post_per_page', $_POST['paging']),
            'format' => sanitize_text_field($_POST['format']),
            'categorie' => sanitize_text_field($_POST['categorie']),
            'order' => sanitize_text_field($_POST['order']),
        ];

        ajaxQuery($values);
    }
    exit;
}

if (is_user_logged_in() ) add_action('wp_ajax_motaphoto_sorter', 'motaphoto_sorter');
else add_action('wp_ajax_nopriv_motaphoto_sorter', 'motaphoto_sorter');

// Querry a single photo (lightbox)
function motaphoto_photo_query()
{
    if (test_nonce('motaphoto_photo_query', $_REQUEST['nonce'])) {
        if (!isset($_POST['id'])) {
            wp_send_json_error('Les références de la photo n\'ont pas été fournies', 400);
        }
        $values = [
            'format' => sanitize_text_field($_POST['format']),
            'categorie' => sanitize_text_field($_POST['categorie']),
            'order' => sanitize_text_field($_POST['order']),
            'id' => absint($_POST['id']),
        ];

        // Preparing the query
        $args = [
            'post_type' => 'photo',
            'p' => $values['id']
        ];

        // Loading sort method
        $args = array_merge($args, orderQuery($values['order']));
        // Checking if the format filter is set
        if ($values['format'] !== '') $args['tax_query'][] = filterQuery($values['format'], 'format');
        // Checking if the category filter is set
        if ($values['categorie'] !== '') $args['tax_query'][] = filterQuery($values['categorie'], 'categorie');
        // Added AND relationship if both filters exist
        if ($values['format'] !== '' and $values['categorie'] !== '') $args['tax_query']['relation'] = 'AND';

        // Execute the query
        $photo = new WP_Query($args);

        $results = [];
        $noTerm = null;

        // Loading posts
        if ($photo->have_posts()) {
            $photo->the_post();
            $results['id'] = get_the_ID();
            $results['category'] = get_term_name($photo->ID, 'categorie');
            $results['format'] = get_term_name($photo->ID, 'format');
            $results['ref'] = get_field('reference');
            $results['image'] = get_the_post_thumbnail_url();
            $results['previous'] = get_previous_photo($args, 'id');
            $results['next'] = get_next_photo($args, 'id');
            $results['args'] = $args;
        } else {
            wp_send_json_error('La requête ne renvoie pas de résultats', 404);
        }
        wp_reset_postdata();

        $return = [
            'post' => $results
        ];

        wp_send_json_success($return);
    }
    exit;
}

if (is_user_logged_in() ) add_action('wp_ajax_motaphoto_photo_query', 'motaphoto_photo_query');
else add_action('wp_ajax_nopriv_motaphoto_photo_query', 'motaphoto_photo_query');
