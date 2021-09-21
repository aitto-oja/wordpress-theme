<?php

add_action('rest_api_init', 'aittoojaRegisterSearch');

function aittoojaRegisterSearch() {
    register_rest_route('aittooja/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE, 
        'callback' => 'aittoojaSearchResults', 
    ));
}

function aittoojaSearchResults($data) {
    $mainQuery = new WP_Query(array(
        'post_type' => array('post', 'page', 'language', 'project', 'framework', 'event'), 
        's' => sanitize_text_field($data['term']), 
    ));

    $results = array(
        'generalInfo' => array(), 
        'languages' => array(), 
        'projects' => array(), 
        'events' => array(), 
        'frameworks' => array(), 
    );

    while($mainQuery->have_posts()) {
        $mainQuery->the_post();
        
        if (get_post_type() == 'post' OR get_post_type() == 'page') {
            array_push($results['generalInfo'], array(
                'title' => get_the_title(), 
                'permalink' => get_the_permalink(), 
                'postType' => get_post_type(), 
                'authorName' => get_the_author(), 
            ));
        }
        
        if (get_post_type() == 'language') {
            array_push($results['languages'], array(
                'title' => get_the_title(), 
                'permalink' => get_the_permalink(), 
                'image' => get_the_post_thumbnail_url(0), 
            ));
        }

        if (get_post_type() == 'project') {
            array_push($results['projects'], array(
                'title' => get_the_title(), 
                'permalink' => get_the_permalink(), 
            ));
        }

        if (get_post_type() == 'framework') {
            array_push($results['frameworks'], array(
                'title' => get_the_title(), 
                'permalink' => get_the_permalink(), 
                'image' => get_the_post_thumbnail_ulr(0), 
            ));
        }

        if (get_post_type() == 'event') {
            $eventDate = new DateTime(get_field('event_date'));
            $description = null;
            if (has_excerpt()) {
                $description = get_the_excerpt();
            } else {
                $description = wp_trim_words(get_the_content(), 10);
            }

            array_push($results['events'], array(
                'title' => get_the_title(), 
                'permalink' => get_the_permalink(),
                'month' => $eventDate->format('M'), 
                'day' => $eventDate->format('d'),   
                'description' => $description, 
            ));
        }

    }

    return $results;
}

