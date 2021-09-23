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

function createLike() {
    return 'Thanks for liking. ';
}

function deleteLike() {
    return 'Thanks for NOT liking.';
}

add_action('rest_api_init', 'aittoojaLikeRoutes');