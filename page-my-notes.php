<?php 

if (!is_user_logged_in()) {
    wp_redirect(esc_url(site_url('/')));
    exit;
}

get_header();
pageBanner();

while(have_posts()) {
    the_post(); 
    ?>

    <div class="container container--narrow page-section">
        Custom code
    </div>

<?php }

get_footer();
