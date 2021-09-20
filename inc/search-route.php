<?php

add_action('rest_api_init', 'aittoojaRegisterSearch');

function aittoojaRegisterSearch() {
    register_rest_route('aittooja/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE, 
        'callback' => 'aittoojaSearchResults', 
    ));
}

function aittoojaSearchResults() {
    return 'congrats';
}

