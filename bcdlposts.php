<?php
/*
Plugin Name:    BCDL Display Posts by Category
Plugin URI:     https://github.com/bchavdarov/bcdlposts
Description:    A basic WordPress plugin. Displays posts of a given category in the order: Post ID, Post Category, and Post Title.
Version:        1.0
Author:         Boncho Chavdarov
Author URI:     https://github.com/bchavdarov
License:        GPL-2.0-or-later
*/

function display_posts_by_category_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'category' => '',
    ), $atts );

    $category_name = $atts['category'];

    $args = array(
        'category_name' => $category_name,
        'post_type' => 'post',
        'posts_per_page' => -1, // Display all posts
    );

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) {
        $output = '<ul>';
        while ( $query->have_posts() ) {
            $query->the_post();
            $categories = get_the_category();
            $category_name = $categories[0]->name;
            $output .= '<li>';
            $output .= 'Post ID: ' . get_the_ID() . '<br>';
            $output .= 'Post Category: ' . $category_name . '<br>';
            $output .= 'Post Title: ' . get_the_title() . '</li>';
        }
        $output .= '</ul>';
        wp_reset_postdata();
        return $output;
    } else {
        return 'No posts found in category ' . $category_name;
    }
}

add_shortcode( 'display_posts_by_category', 'display_posts_by_category_shortcode' );


