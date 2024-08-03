<?php

/** Timeline Template, page-timeline.php */
get_header(); ?>


    <div class="row">
        <div class="col-md-12 text-center" style="margin-top: 50px;">
            <h1 class="text-white"> Lede Content and Filters</h1>
            <p class="text-white"> This is the lede content for the timeline page. It can be edited in the page-timeline.php file.</p>
            <!-- BUTTON GROUP -->
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary">All</button>
                <button type="button" class="btn btn-secondary">Husky Pride and Resilience</button>
                <button type="button" class="btn btn-secondary">A Stronger, More Inclusive Community</button>
                <button type="button" class="btn btn-secondary">Wellness of People and Planet</button>
                <button type="button" class="btn btn-secondary">Excellence in Research, Innovation, and Engagement
                </button>
                <button type="button" class="btn btn-secondary">Seven World-Class Campuses, One Flagship University
                </button>
                <button type="button" class="btn btn-secondary">Student Success Journey</button>


            </div>
        </div>
    </div>

<div class="timeline-wrap mt-4 timeline">

    <!-- <div class="timeline-element circle-orange-green left">
        <div class="timeline-photo">
            <img class="timeline-photo" src="img/husky-1.jpg" width="100%" height="200px" alt="husky">
            <p class="timeline-tag tag-orange">A STRONGER, MORE INCLUSIVE COMMUNITY<sup>2</sup>
            <span class="tooltiptext">Identify and pursue new revenue opportunities, including industry partnerships and joint ventures that expand technology commercialization and startup creation.</span></p>
            <p class="timeline-tag-2 tag-green">WELLNESS OF PEOPLE AND PLANET<sup>3</sup>
            <span class="tooltiptext">Recruit diverse faculty and staff and strengthen strategies that increase their retention.</span></p>
        </div>
        <div class="timeline-details">
            <small class="timeline-date">05/28/24</small>
            <h3>Helping Teachers Recognize Gifted Learners and Elevate Classroom Conversation</h3>
            <p>'Project Focus' brings more learners into gifted programs — and more strategies from gifted education into general classrooms.</p>
            <a href="#" class="btn btn-default">CONTINUE READING</a>
        </div>
    </div>

    <div class="timeline-element circle-blue right">
        <div class="timeline-photo">
            <img class="timeline-photo" src="img/husky-2.jpg" width="100%" height="200px" alt="husky">
            <p class="timeline-tag tag-blue">HUSKY PRIDE AND RESILIENCE<sup>4</sup>
            <span class="tooltiptext">Translate and disseminate UConn's impactful research that improves the human experience and contributes to philanthropy, innovation, and entrepreneurship.</span></p>
        </div>
        <div class="timeline-details">
            <small class="timeline-date">05/20/24</small>
            <h3>UConn Health Selected for Duffy Status Health Equity Project</h3>
            <p>UConn Health has been selected among 24 health and hospital systems for the American Society of Hematology project to establish new blood reference ranges that better reflect diverse patient populations.</p>
            <a href="#" class="btn btn-default">CONTINUE READING</a>
        </div>
    </div> -->

    <?php
    $args = array(
        'post_type' => 'timeline-item',
        'posts_per_page' => -1,
    );

    $timeline_items = new WP_Query($args);

    if ($timeline_items->have_posts()) {
        while ($timeline_items->have_posts()) {

            $timeline_items->the_post();
            // get the featured image
            $timeline_photo = get_the_post_thumbnail_url(get_the_ID(), 'full');
           
            $areas_of_focus = array();
            // the tags are custom taxonomy area-of-focus
            $terms = get_the_terms($post->ID, 'area-of-focus');
            foreach ($terms as $term) {
                $areas_of_focus[$term->slug] = array(
                    'name' => $term->name,
                    'slug' => $term->slug,
                    'color' => get_field('color', $term)
                );
            }
           
            $timeline_date = get_the_date();
            $timeline_title = get_the_title();
            $timeline_content = get_the_excerpt();
            // external_link is a custom field
            $timeline_link = get_field('external_link');

            $priority_action_text = get_field('priority_action_text');


            
        ?>

            <div class="timeline-element
            <?php 
            // if there are two areas of focus, add the class hyphenating the two colors, otherwise just the one
            if (count($areas_of_focus) > 1) {
                echo 'circle-' . $areas_of_focus[array_key_first($areas_of_focus)]['color'] . '-' . $areas_of_focus[array_key_last($areas_of_focus)]['color'];
            } else {
                echo 'circle-' . $areas_of_focus[array_key_first($areas_of_focus)]['color'];
            }
            ?>
            ">
                <div class="timeline-photo">
                    <img class="timeline-photo" src="<?php echo $timeline_photo; ?>" width="100%" height="200px" alt="husky">
                    <?php
                    $count = 1;
                    foreach ($areas_of_focus as $area) {
                        
                    ?>
                        <p class="timeline-tag tag-<?php echo $area['color']; ?>
                        <?php echo "timeline-tag-" . $count++; ?>
                        "><?php echo $area['name']; ?>
                            <span class="tooltiptext"><?php echo $priority_action_text; ?></span>
                        </p>
                    <?php
                    }
                    ?>
                </div>
                <div class="timeline-details">
                    <small class="timeline-date"><?php echo $timeline_date; ?></small>
                    <h3><?php echo $timeline_title; ?></h3>
                    <p><?php echo $timeline_content; ?></p>
                    <a href="<?php echo $timeline_link; ?>" class="btn btn-default">CONTINUE READING</a>
                </div>
            </div>

        <?php

        }
        wp_reset_postdata();
    }
    ?>

</div>

<?php get_footer(); ?>