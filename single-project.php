<?php 

get_header();
pageBanner();

while(have_posts()) {
    the_post(); 
    ?>
    
    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('project'); ?>">
                    <i class="fa fa-home" aria-hidden="true"></i> All Projects
                </a> 
                <span class="metabox__main"><?php the_title(); ?></span>
                    </p>
                </div>

        <div class="generic-content">
            <?php the_field('main_body_content'); ?>
        </div>
        
        <?php 

        $relatedLanguages = new WP_Query(array( 
            'posts_per_page' => -1, 
            'post_type' => 'language', 
            'orderby' => 'title', 
            'order' => 'ASC', 
            'meta_query' => array( 
                array(
                    'key' => 'related_projects', 
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"',  
                ), 
            ), 
        ));

        if ($relatedLanguages->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Languages in this project</h2>';

            // TODO: change class name
            echo '<ul class="professor-cards">';
            while ($relatedLanguages->have_posts()) {
                $relatedLanguages->the_post(); ?>
                <li class="professor-card__list-item">
                    <a class="professor-card" href="<?php the_permalink(); ?>">
                        <img class="professor-card__image" src="<?php the_post_thumbnail_url(); ?>">
                        <span class="professor-card__name">
                            <?php the_title(); ?>
                        </span>
                    </a>
                </li>
            <?php }
            echo '</ul>';
        }
        wp_reset_postdata();

        $relatedFrameworks = new WP_Query(array( 
            'posts_per_page' => -1, 
            'post_type' => 'framework', 
            'orderby' => 'title', 
            'order' => 'ASC', 
            'meta_query' => array( 
                array(
                    'key' => 'related_projects', 
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"',  
                ), 
            ), 
        ));

        if ($relatedFrameworks->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Frameworks in this project</h2>';

            echo '<ul class="professor-cards">';
            while ($relatedFrameworks->have_posts()) {
                $relatedFrameworks->the_post(); ?>
                <li class="professor-card__list-item">
                    <a class="professor-card" href="<?php the_permalink(); ?>">
                        <img class="professor-card__image" src="<?php the_post_thumbnail_url(); ?>">
                        <span class="professor-card__name">
                            <?php the_title(); ?>
                        </span>
                    </a>
                </li>
            <?php }
            echo '</ul>';
        }
        wp_reset_postdata();

        $today = date('Ymd');
        $relatedEvents = new WP_Query(array( 
            'post_type' => 'event', 
            'meta_key' => 'event_date', 
            'orderby' => 'meta_value_num', 
            'order' => 'ASC', 
            'meta_query' => array(
                array(
                    'key' => 'event_date', 
                    'compare' => '>=', 
                    'value' => $today,
                    'type'  => 'numeric', 
                ), 
                array(
                    'key' => 'related_projects', 
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"',  
                ), 
            ), 
        ));

        if ($relatedEvents->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Upcoming Events</h2>';

            while ($relatedEvents->have_posts()) {
                $relatedEvents->the_post(); 
                get_template_part('template-parts/content', 'event');
            }
        }



         ?>
    </div>
<?php }

get_footer();
