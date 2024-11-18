<?php
function get_term_name($postid, $taxonomy) {
    $term_obj_list = get_the_terms( $postid, $taxonomy );
    $term_name_array = wp_list_pluck( $term_obj_list, 'name' );
    return $term_name_array[array_key_first($term_name_array)];
}

function the_term_name($postid, $taxonomy) {
    echo get_term_name($postid, $taxonomy);
}
