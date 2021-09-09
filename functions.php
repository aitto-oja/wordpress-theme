<?php

function aittooja_files() {
    wp_enqueue_script('main-aittooja-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('aittooja_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('aittooja_extra_styles', get_theme_file_uri('/build/index.css'));
}

add_action('wp_enqueue_scripts', 'aittooja_files');

function aittooja_features() {
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerLocationOne', 'Footer Location One');
    register_nav_menu('footerLocationTwo', 'Footer Location Two');
    add_theme_support('title-tag');
}

add_action('after_setup_theme', 'aittooja_features');

function aittooja_post_types() {
    // Event post type
    register_post_type('event', array(
        'supports' => array('title', 'editor', 'excerpt'), 
        'rewrite' => array(
            'slug' => 'events', 
        ), 
        'has_archive' => true, 
        'public' => true, 
        'show_in_rest' => true, 
        'labels' => array(
            'name' => 'Events', 
            'add_new_item' => 'Add New Event', 
            'edit_item' => 'Edit Event', 
            'all_items' => 'All Events', 
            'singular_name' => 'Event', 
        ), 
        'menu_icon' => 'dashicons-calendar', 
    ));

    // Project post type
    register_post_type('project', array(
        'supports' => array('title', 'editor', 'excerpt'), 
        'rewrite' => array(
            'slug' => 'projects', 
        ), 
        'has_archive' => true, 
        'public' => true, 
        'show_in_rest' => true, 
        'labels' => array(
            'name' => 'Projects', 
            'add_new_item' => 'Add New Project', 
            'edit_item' => 'Edit Project', 
            'all_items' => 'All Projects', 
            'singular_name' => 'Project', 
        ), 
        'menu_icon' => 'dashicons-database', 
    ));

    // Language post type
    register_post_type('language', array(
        'supports' => array('title', 'editor', 'excerpt'),  
        'public' => true, 
        'show_in_rest' => true, 
        'labels' => array(
            'name' => 'Languages', 
            'add_new_item' => 'Add New Language', 
            'edit_item' => 'Edit Language', 
            'all_items' => 'All Languages', 
            'singular_name' => 'Language', 
        ), 
        'menu_icon' => 'dashicons-translation', 
    ));

    // Framework post type
    register_post_type('framework', array(
        'supports' => array('title', 'editor', 'excerpt'),  
        'public' => true, 
        'show_in_rest' => true, 
        'labels' => array(
            'name' => 'Frameworks', 
            'add_new_item' => 'Add New Framework', 
            'edit_item' => 'Edit Framework', 
            'all_items' => 'All Frameworks', 
            'singular_name' => 'Framework', 
        ), 
        'menu_icon' => 'dashicons-media-interactive', 
    ));

}

add_action('init', 'aittooja_post_types');

function aittooja_adjust_queries($query) {
    if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
                'key' => 'event_date', 
                'compare' => '>=', 
                'value' => $today, 
                'type' => 'numeric', 
            ), 
        ));
    }

    if (!is_admin() AND is_post_type_archive('project') AND $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }
}

add_action('pre_get_posts', 'aittooja_adjust_queries');
