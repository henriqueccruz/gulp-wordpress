<?php
/**
 * Query for the related posts block
 *
 * @author   Tinpix Digital
 * @version  1.0.0
 * @package  sinqia
 */

function get_related_category_posts() {
    // Check if we are on a single page, if not, return false
    if ( !is_single() )
        return false;

    // Get the current post id
    $post_id = get_queried_object_id();

    // Get the post categories
    $categories = get_the_category( $post_id );

    // Lets build our array
    // If we don't have categories, bail
    if ( !$categories )
        return false;

    foreach ( $categories as $category ) {
        if ( $category->parent == 0 ) {
            $term_ids[] = $category->term_id;
        } else {
            $term_ids[] = $category->parent;
            $term_ids[] = $category->term_id;
        }
    }

    // Remove duplicate values from the array
    $unique_array = array_unique( $term_ids );

    // Lets build our query
    $args = [
        'post__not_in' => [$post_id],
        'posts_per_page' => 3, // Note: showposts is depreciated in favor of posts_per_page
        'ignore_sticky_posts' => 1, // Note: caller_get_posts is depreciated
        'orderby' => 'title',
        'no_found_rows' => true, // Skip pagination, makes the query faster
        'tax_query' => [
            [
                'taxonomy' => 'category',
                'terms' => $unique_array,
                'include_children' => false,
            ],
        ],
    ];
    $q = new WP_Query( $args );
    return $q;
}