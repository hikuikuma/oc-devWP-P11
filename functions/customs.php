<?php
function get_term_name($postid, $taxonomy) {
    $term_obj_list = get_the_terms($postid, $taxonomy);
    $term_name_array = wp_list_pluck($term_obj_list, 'name');
    return $term_name_array[array_key_first($term_name_array)];
}

function the_term_name($postid, $taxonomy) {
    echo get_term_name($postid, $taxonomy);
}

function get_previous_photo($args, $type_return = null) {
    return get_photo_on_loop($args, 'previous', $type_return);
}

function get_next_photo($args, $type_return = null) {
    return get_photo_on_loop($args, 'next', $type_return);
}

function get_photo_on_loop($args, $which, $type_return) {

    $hasFormat = false; $hasCategory = false;

    if (isset($args['tax_query'])){
        switch (count($args['tax_query'])) {
            case 1:
                if($args['tax_query'][0]['taxonomy'] == 'format') $hasFormat = true;
                if($args['tax_query'][0]['taxonomy'] == 'categorie') $hasCategory = true;
                break;
            case 3:
                $hasFormat = true; $hasCategory = true;
                break;
        }
    }

    $inSame = false;
    $excluded = '';
    $taxonomy = false;

    if ($hasCategory) {
        $inSame = true;
        $taxonomy = 'categorie';
    }

    if ($hasFormat) {
        $inSame = true;
        if ($hasCategory) {
            $excluded = ($args['tax_query'][0]['terms'] === 'paysage') ? ['6'] : ['5'];
        } else {
            $taxonomy = 'format';
        }
    }

    $post = new WP_Query($args);

    if ($post->have_posts()) {
        if($inSame) {
            $previous = get_previous_post($inSame, $excluded, $taxonomy);
            $next = get_next_post($inSame, $excluded, $taxonomy);
        } else {
            $previous = get_previous_post();
            $next = get_next_post();
        }
    } else {
        wp_die('Loop is broken', 404);
    }
    wp_reset_postdata();
    if ($which === 'previous') $post = (is_a($previous, 'WP_Post')) ? $previous : get_photo($args, 'last');
    if ($which === 'next') $post = (is_a($next, 'WP_Post')) ? $next : get_photo($args, 'first');

    switch ($type_return) {
        case 'id':
            return $post->ID;
        case 'post':
        default:
            return $post;
    }
}


function get_photo($args, $order) {
    if ($order !== 'last' && $order !== 'first') wp_die('Invalid argument in get_photo function', 400);
    unset($args['p']);
    $args['order'] = ($order === 'last') ? 'DESC' : 'ASC';
    $args['posts_per_page'] = 1;
    $photos = new WP_Query($args);
    return $photos->posts[0];
}
