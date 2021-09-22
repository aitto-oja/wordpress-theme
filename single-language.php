<?php 

get_header();
pageBanner();

while(have_posts()) {
    the_post(); 
    ?>
    
    <div class="container container--narrow page-section">
        
        <div class="generic-content">
            <div class="row group">

                <div class="one-third">
                    <?php the_post_thumbnail(); ?>
                </div>

                <div class="two-third">
                    <?php 
                    $likeCount = new WP_Query(array(
                        'post_type' => 'like', 
                        'meta_query' => array(
                            array(
                                'key' => 'liked_language_id', 
                                'compare' => '=', 
                                'value' => get_the_ID(), 
                            ), 
                        ), 
                    ));
                    ?>
                    <span class="like-box">
                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                        <i class="fa fa-heart" aria-hidden="true"></i>
                        <span class="like-count"><?php echo $likeCount->found_posts; ?></span>
                    </span>
                    <?php the_content(); ?>
                </div>

            </div>
        </div>

        <?php 
            $relatedProjects = get_field('related_projects');
            
            if ($relatedProjects) {
                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium">Language Used in Project(s)</h2>';
                echo '<ul class="link-list min-list">';
                foreach($relatedProjects as $project) { ?>
                    <li>
                        <a href="<?php echo get_the_permalink($project); ?>">
                            <?php echo get_the_title($project); ?>
                        </a>
                    </li>
                <?php }
                echo '</ul>';
            }?>

    </div>
<?php }

get_footer();
