<?php

/** Timeline Template, page-timeline.php */
get_header(); 



$args = array(
    'post_type' => 'timeline-item',
    'posts_per_page' => 5,
    'paged' => get_query_var('paged'),
);

// if $_GET['aof'] is set, filter by area of focus

if (isset($_GET['aof'])) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'area-of-focus',
            'field' => 'slug',
            'terms' => $_GET['aof'],
            'per_page' => 5,
            'paged' => get_query_var('paged'),
        ),
    );
}

$timeline_items = new WP_Query($args);


?>


<div class="row">
    <div class="col-md-12" style="margin-top: 50px;">
        <h1 class="text-white timeline__sectionHead">Priorities in Action.</h1>
        <p class="text-white timeline__lede ">
            The priorities of UConn's strategic plan are brought to life through the work of our students, faculty, and staff.
            Every day, the UConn community is executing on the goals of our strategic plan, across all areas of focus.
            Explore the timeline below to see how the University is making an impact in the areas of focus that are most important to our community.
        </p>

    </div>
</div>
<div class="row">
        <div class="col-md-12">
            <div class="pagination">
                <?php
                $pagination_links = paginate_links(array(
                    'total' => $timeline_items->max_num_pages,
                    'type' => 'array', // Return the links as an array
                    'prev_text' => __('&laquo; Prev'),
                    'next_text' => __('View More'), // Change "Next" to "View More"
                ));

                if (!empty($pagination_links)) {
                    foreach ($pagination_links as $link) {
                        // Only modify the "next" page link to append content
                        if (strpos($link, 'next page-numbers')) {
                            echo str_replace('<a', '<a hx-get="' . esc_url(get_pagenum_link()) . '" hx-select="#timeline-app" hx-target="#timeline-app" hx-swap="beforeend"', $link);
                        } else {
                            echo $link;
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
<section id="timeline-app">

    <div class="row">
        <div class="timeline-wrap mt-4 timeline container">

            <div class="col-md-6 timeline-filter">
                <h4>Filter by Area of Focus <small>[<a href="<?php the_permalink(); ?>">View All</a>]</small></h4>
                <ul>
                    <?php
                    $args = array(
                        'taxonomy' => 'area-of-focus',
                        'hide_empty' => false,
                    );

                    $terms = get_terms($args);

                    foreach ($terms as $term) {
                        echo '<li class="timeline-filter-item';

                        if (isset($_GET['aof']) && $_GET['aof'] == $term->slug) {
                            echo ' active"';
                        } else echo '"';

                        echo '>';

                        echo '<a href="?aof=' . $term->slug . '"' . ' class="filter" data-filter=".' . $term->slug . '">';
                        echo '<span class="circle" style="background-color:' . get_field('color', $term) . '"></span>' . $term->name . '</a></li>';
                    }
                    ?>
                </ul>
            </div>

            <?php


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
                    $priority_action_text_2 = get_field('priority_action_text_2');




            ?>

                    <div class="timeline-element
            col-md-6
            <?php if ($timeline_items->current_post % 2 == 0 && $timeline_items->current_post != 0) {
                        echo 'col-md-offset-6';
                    } ?>
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

                        </div>
                        <div class="timeline-details">
                            <small class="timeline-date"><?php echo $timeline_date; ?></small>
                            <h3><?php echo $timeline_title; ?></h3>
                            <p><?php echo $timeline_content; ?></p>

                            <?php
                            $count = 1;
                            foreach ($areas_of_focus as $area) :

                            ?>
                                <div class="focus-area-wrap">
                                    <p class="timeline-tag tag-<?php echo $area['color']; ?>
                            <?php echo "timeline-tag-" . $count++; ?>
                        ">
                                        <small>Area of Focus</small>
                                        <?php echo $area['name']; ?>
                                    </p>

                                    <!-- if there is a priority action text, display it -->
                                    <?php if ($priority_action_text and $count == 2) { ?>
                                        <div class="priority-action bg-<?php echo $areas_of_focus[array_key_first($areas_of_focus)]['color']; ?>">
                                            <p class="priority-action-text">
                                                <small>Priority Action</small>
                                                <?php echo $priority_action_text; ?>
                                            </p>
                                        </div>
                                    <?php       } ?>

                                    <!-- if there is a priority action text 2, display it -->
                                    <?php if ($priority_action_text_2 and $count == 3) { ?>
                                        <div class="priority-action bg-<?php echo $areas_of_focus[array_key_last($areas_of_focus)]['color']; ?>">
                                            <p class="priority-action-text"><?php echo $priority_action_text_2; ?></p>
                                        </div>
                                    <?php       } ?>

                                </div>


                            <?php endforeach;
                            ?>


                            <a href="<?php echo $timeline_link; ?>" class="btn btn-default">CONTINUE READING</a>
                        </div>
                    </div>


            <?php

                }
                wp_reset_postdata();
            }
            ?>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="pagination">
                <?php
                $pagination_links = paginate_links(array(
                    'total' => $timeline_items->max_num_pages,
                    'type' => 'array', // Return the links as an array
                    'prev_text' => __('&laquo; Prev'),
                    'next_text' => __('View More'), // Change "Next" to "View More"
                ));

                if (!empty($pagination_links)) {
                    foreach ($pagination_links as $link) {
                        // Only modify the "next" page link to append content
                        if (strpos($link, 'next page-numbers')) {
                            echo str_replace('<a', '<a hx-get="' . esc_url(get_pagenum_link()) . '" hx-select="#timeline-app" hx-target="#timeline-app" hx-swap="beforeend"', $link);
                        } else {
                            echo $link;
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>

</section>

<?php get_footer(); ?>