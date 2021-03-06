<?php

require get_theme_file_path('/inc/like-route.php');
require get_theme_file_path('/inc/search-route.php');

function aittooja_custom_rest() {
    register_rest_field('post', 'authorName', array(
        'get_callback' => function() {
            return get_the_author();
        }
    ));
    register_rest_field('note', 'userNoteCount', array(
        'get_callback' => function() {
            return count_user_posts(get_current_user_id(), 'note');
        }
    ));
}

add_action('rest_api_init', 'aittooja_custom_rest');

function pageBanner($args = NULL) {
    
    if (!$args['title']) {
        $args['title'] = get_the_title();
    }
    if (!$args['subtitle']) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }

    if (!$args['photo']) {
        if (get_field('page_banner_background_image')) {
            $args['photo'] = get_field('page_banner_background_image')['sizes']['large'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }

    ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);">
        </div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
            <div class="page-banner__intro">
                <p><?php echo $args['subtitle']; ?></p>
            </div>
        </div>
    </div>

<?php }

function aittooja_files() {
    wp_enqueue_script('main-aittooja-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('aittooja_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('aittooja_extra_styles', get_theme_file_uri('/build/index.css'));

    wp_localize_script('main-aittooja-js', 'aittoojaData', array(
        'root_url' => get_site_url(), 
        'nonce' => wp_create_nonce('wp_rest'), 
    ));

}

add_action('wp_enqueue_scripts', 'aittooja_files');

function aittooja_features() {
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerLocationOne', 'Footer Location One');
    register_nav_menu('footerLocationTwo', 'Footer Location Two');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'aittooja_features');

function aittooja_post_types() {
    // Event post type
    register_post_type('event', array(
        'capability_type' => 'event', 
        'map_meta_cap' => true,
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
        'supports' => array('title', 'excerpt'), 
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
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),  
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
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),  
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

    // Note post type
    register_post_type('note', array(
        'capability_type' => 'note', 
        'map_meta_cap' => true, 
        'supports' => array('title', 'editor'),  
        'public' => false, 
        'show_ui' => true, 
        'show_in_rest' => true, 
        'labels' => array(
            'name' => 'Notes', 
            'add_new_item' => 'Add New Note', 
            'edit_item' => 'Edit Note', 
            'all_items' => 'All Notes', 
            'singular_name' => 'Note', 
        ), 
        'menu_icon' => 'dashicons-welcome-write-blog', 
    ));

    // Like post type
    register_post_type('like', array(
        'supports' => array('title'),  
        'public' => false, 
        'show_ui' => true, 
        'labels' => array(
            'name' => 'Like', 
            'add_new_item' => 'Add New Like', 
            'edit_item' => 'Edit Like', 
            'all_items' => 'All Likes', 
            'singular_name' => 'Like', 
        ), 
        'menu_icon' => 'dashicons-heart', 
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


// Redirect subscriber accounts out of admin and onto homopage
function redirectSubsToFrontend() {
    $ourCurrentUser = wp_get_current_user();
    if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
        wp_redirect(site_url('/'));
        exit;
    }
}

add_action('admin_init', 'redirectSubsToFrontend');

function noSubsAdminBar() {
    $ourCurrentUser = wp_get_current_user();
    if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
}

add_action('wp_loaded', 'noSubsAdminBar');

// Customize Login Screen
function myHeaderUrl() {
    return esc_url(site_url('/'));
}

add_filter('login_headerurl', 'myHeaderUrl');

function myLoginCSS() {
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('aittooja_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('aittooja_extra_styles', get_theme_file_uri('/build/index.css'));
}

add_action('login_enqueue_scripts', 'myLoginCSS');

// Customize Login Screen Logo
function myLoginTitle() {
    return get_bloginfo('name');
}

add_filter('login_headertitle', 'myLoginTitle');

// Force note posts to be private
function makeNotePrivate($data, $post_arr) {

    if ($data['post_type'] == 'note') {
        if (count_user_posts(get_current_user_id(), 'note')>4 AND !$post_arr['ID']) {
            die("You have reached your note limit.");
        }

        $data['post_content'] = sanitize_textarea_field($data['post_content']);
        $data['post_title'] = sanitize_text_field($data['post_title']);
    }

    if ($data['post_type'] == 'note' AND $data['post_status'] != 'trash') {
        $data['post_status'] = "private";
    }
    return $data;
}

add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);