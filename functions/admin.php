<?php
function motaphoto_admin_init()
{
    remove_post_type_support('photo', 'editor');
}

function manage_photo_columns($columns) {
    unset ($columns['date']);
    $columns['reference'] = get_field_object('reference')['label'];
    $columns['categorie'] = get_taxonomy_labels(get_taxonomy('categorie'))->name;
    $columns['formats'] = get_taxonomy_labels(get_taxonomy('format'))->singular_name;
    $columns['type'] = get_field_object('type')['label'];
    $columns['year'] = 'Année';
    $columns['status'] = 'État';
    return $columns;
}

function custom_photo_column($column, $post_id) {
    switch ($column) {
        case 'reference':
            return get_field('reference');
            break;
        case 'categorie':
            $terms = get_the_term_list($post_id, 'categorie', '', ',', '');
            if (is_string($terms))
                echo $terms;
            else
                echo get_taxonomy_labels(get_taxonomy('categorie'))->no_terms;
            break;
        case 'formats':
            $terms = get_the_term_list($post_id, 'format', '', ',', '');
            if (is_string($terms))
                echo $terms;
            else
                _e('Format', 'format_not_found');
            break;
        case 'type':
            echo get_field('type')['label'];
            break;
        case 'year':
            echo get_the_date('Y');
            break;
        case 'status':
            echo get_post_status_object(get_post_status())->label;
            break;
    }
}

add_action('admin_init', 'motaphoto_admin_init');
add_filter('manage_photo_posts_columns', 'manage_photo_columns');
add_action('manage_photo_posts_custom_column', 'custom_photo_column', 10, 2);
