<?php

/** Timeline Template, page-timeline.php */
get_header(); ?>

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
                $areas_of_focus[] = $term->name;
            }
           
            $timeline_date = get_the_date();
            $timeline_title = get_the_title();
            $timeline_content = get_the_excerpt();
            // external_link is a custom field
            $timeline_link = get_field('external_link');

            $timeline_tag_1 = $areas_of_focus[0];
            $timeline_tag_2 = $areas_of_focus[1];
        ?>

            <div class="timeline-element circle-orange-green <?php echo ($count % 2 == 0) ? 'left' : 'right'; ?>">
                <div class="timeline-photo">
                    <img class="timeline-photo" src="<?php echo $timeline_photo; ?>" width="100%" height="200px" alt="husky">
                    <p class="timeline-tag tag-orange"><?php echo $timeline_tag_1; ?></p>
                    <?php if ($timeline_tag_2) { ?>
                        <p class="timeline-tag-2 tag-green"><?php echo $timeline_tag_2; ?></p>
                    <?php } ?>
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