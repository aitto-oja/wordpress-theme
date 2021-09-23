<?php

function aittoojaLikeRoutes() {
    register_rest_route('aittooja/v1', 'manageLike', array(
        'methods' => 'POST',
        'callback' => 'createLike', 
    ));
    register_rest_route('aittooja/v1', 'manageLike', array(
        'methods' => 'DELETE',
        'callback' => 'deleteLike', 
    ));
}

function createLike($data) {

    if (is_user_logged_in()) {
        $liked = sanitize_text_field($data['likedId']);
        $type = sanitize_text_field($data['likedType']);
        
        $existQuery = new WP_Query(array(
            'author' => get_current_user_id(), 
            'post_type' => 'like', 
            'meta_query' => array(
                array(
                    'key' => 'liked_'. $type .'_id', 
                    'compare' => '=', 
                    'value' => $like, 
                ), 
            ), 
        ));
        if ($existQuery->found_posts == 0) {
            return wp_insert_post(array(
                'post_type' => 'like', 
                'post_status' => 'publish', 
                'post_title' => 'My 8th PHP Create Post Test',
                'meta_input' => array(
                    'liked_' . $type .'_id' => $liked, 
                ), 
            ));
        } else {
            die("Invalid like id");
        }
    } else {
        die("Only logged in users can create a like.");
    }
}

function deleteLike() {
    return 'Thanks for NOT liking.';
}

add_action('rest_api_init', 'aittoojaLikeRoutes');