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
                    <?php the_content(); ?>
                </div>

                </div>
        </div>
        <?php 
            $relatedProjects = get_field('related_projects');
            
            if ($relatedProjects) {
                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium">Framework Used in Project(s)</h2>';
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
