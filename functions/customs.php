<?php
function get_term_name($postid, $taxonomy) {
    $term_obj_list = get_the_terms( $postid, $taxonomy );
    $term_name_array = wp_list_pluck( $term_obj_list, 'name' );
    return $term_name_array[array_key_first($term_name_array)];
}

function the_term_name($postid, $taxonomy) {
    echo get_term_name($postid, $taxonomy);
}

function get_previous_photo($previous, $type_return, $orderby = 'id') {
    return get_photo_on_loop($previous, 'previous', $type_return, $orderby);
}

function get_next_photo($next, $type_return, $orderby = 'id') {
    return get_photo_on_loop($next, 'next', $type_return, $orderby);
}

function get_photo_on_loop($post, $which, $type_return, $orderby = 'id') {
    if ( !is_a($post, 'WP_Post') ) {
        if ($which == 'next') { $post = get_first_photo($orderby); }
        else { $post = get_last_photo($orderby); }
    }
    switch( $type_return) {
        case 'id': return $post->ID;
        case 'post':
        default:
            return $post;
    }
}

function get_first_photo($orderby) {
    if ($orderby != 'id' && $orderby != 'date') {wp_die('Invalid argument in get_first_photo function ['.$orderby.']', 400);}
    return get_photo($orderby, 'ASC');
}

function get_last_photo($orderby) {
    if ($orderby != 'id' && $orderby != 'date') {wp_die('Invalid argument in get_last_photo function ['.$orderby.']', 400);}
    return get_photo($orderby, 'DESC');
}

function get_photo($orderby, $order) {
    if ($order != 'ASC' && $order != 'DESC') {wp_die('Invalid argument in get_photo function', 400);}
    $args = [
        'post_type' => 'photo',
        'posts_per_page' => 1,
        'orderby' => $orderby,
        'order' => $order,
    ];
    $photos = new WP_Query($args);
    return $photos->posts[0];
}
