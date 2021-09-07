<?php 

get_header(); ?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/gray-satellite-disc-on-field-copy.jpg'); ?>)"></div>
    <div class="page-banner__content container t-center c-white">
        <h1 class="headline headline--large">Hello, World!</h1>
        <h2 class="headline headline--medium">My name is Reeta.</h2>
        <h3 class="headline headline--small">Why don&rsquo;t you check out my <strong>projects</strong>?</h3>
        <a href="#" class="btn btn--large btn--blue">Explore Projects</a>
    </div>
</div>

<div class="full-width-split group">
    <div class="full-width-split__one">
        <div class="full-width-split__inner">
            <h2 class="headline headline--small-plus t-center">Latest Projects</h2>

            <div class="event-summary">
                <a class="event-summary__date t-center" href="#">
                    <span class="event-summary__month">Mar</span>
                    <span class="event-summary__day">25</span>
                </a>
                <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny"><a href="#">My First Project</a></h5>
                    <p>This is a placeholder for a summary of my first project. <a href="#" class="nu gray">Learn more</a></p>
                </div>
            </div>
            <div class="event-summary">
                <a class="event-summary__date t-center" href="#">
                    <span class="event-summary__month">Apr</span>
                    <span class="event-summary__day">02</span>
                </a>
                <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny"><a href="#">My Second Project</a></h5>
                    <p>This is a placeholder for a summary of my second project. <a href="#" class="nu gray">Learn more</a></p>
                </div>
            </div>

            <p class="t-center no-margin"><a href="#" class="btn btn--blue">View All Projects</a></p>
        </div>
    </div>
    <div class="full-width-split__two">
        <div class="full-width-split__inner">
            <h2 class="headline headline--small-plus t-center">From My Blogs</h2>
            <?php 
                $homepagePosts = new WP_Query(array(
                    'posts_per_page' => 2, 
                ));
                while ($homepagePosts->have_posts()) {
                    $homepagePosts->the_post(); ?>
                    <div class="event-summary">
                        <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
                            <span class="event-summary__month"><?php the_time('M'); ?></span>
                            <span class="event-summary__day"><?php the_time('j'); ?></span>
                        </a>
                        <div class="event-summary__content">
                            <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                            <p><?php echo wp_trim_words(get_the_content(), 10); ?> <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a></p>
                        </div>
                    </div>
                <?php } 
                    wp_reset_postdata();
            ?>

            <p class="t-center no-margin"><a href="#" class="btn btn--yellow">View All Blog Posts</a></p>
        </div>
    </div>
</div>

<div class="hero-slider">
    <div data-glide-el="track" class="glide__track">
        <div class="glide__slides">
            <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/MK_Kansikuva_blogi_4.jpeg'); ?> ">
                <div class="hero-slider__interior container">
                    <div class="hero-slider__overlay">
                        <h2 class="headline headline--medium t-center">Mimmit Koodaa</h2>
                        <p class="t-center">Mimmit koodaa program increases gender equality in the Finnish software industry.</p>
                        <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
                    </div>
                </div>
            </div>
            <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/ahkio-intro-kuva.png'); ?>)">
                <div class="hero-slider__interior container">
                    <div class="hero-slider__overlay">
                        <h2 class="headline headline--medium t-center">Ahkio Consulting Oy</h2>
                        <p class="t-center">Pupesoft ERP solutions and services with years of experience.</p>
                        <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
                    </div>
                </div>
            </div>
            <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/saranen-intro-kuva.jpeg'); ?>)">
                <div class="hero-slider__interior container">
                    <div class="hero-slider__overlay">
                        <h2 class="headline headline--medium t-center">Saranen Consulting</h2>
                        <p class="t-center">Fast skill development - sustainable growth.</p>
                        <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
        </div>
    </div>
</div>

<?php
get_footer();