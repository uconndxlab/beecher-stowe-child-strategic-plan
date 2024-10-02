<?php

/** Timeline Template, page-timeline.php */
get_header();



$args = array(
    'post_type' => 'timeline-item',
    'posts_per_page' => -1,
    'paged' => get_query_var('paged'),
);

// if $_GET['aof'] is set, filter by area of focus

if (isset($_GET['aof'])) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'area-of-focus',
            'field' => 'slug',
            'terms' => $_GET['aof'],
            'per_page' => -1,
            'paged' => get_query_var('paged'),
        ),
    );
}

$timeline_items = new WP_Query($args);


?>


<div class="row">
    <div class="col-md-12" style="margin-top: 50px;">
        <!-- get the conent of the page -->
        <?php if (have_posts()) : while (have_posts()) : the_post();
                the_content();
            endwhile;
        endif; ?>
    </div>
</div>

<section id="timeline-app">
    <div class="container">

    <div class="row">

    <div class="col-md-6 timeline-filter">

        <h4>Filter by Area of Focus &#8628;</h4>


        <ul>
            <li>
                <a href="<?php the_permalink(); ?>" class=" filter view-all" data-filter="*">
                    <span class="circle" style="background-color: #000e2f"></span>All Areas of Focus
                </a>

            </li>
            <?php
            $args = array(
                'taxonomy' => 'area-of-focus',
                'hide_empty' => false,
            );

            $terms = get_terms($args);

            foreach ($terms as $term) {
                $term_description = $term->description;
                echo '<li class="timeline-filter-item';

                if (isset($_GET['aof']) && $_GET['aof'] == $term->slug) {
                    echo ' active"';
                } else echo '"';

                echo '>';

                echo '<a 
                hx-get="?aof=' . $term->slug . '"
                hx-select="#timeline-app"
                hx-target="#timeline-app"
                hx-swap="outerHTML"
                href="?aof=' . $term->slug . '"' . ' class="filter" data-filter=".' . $term->slug . '">';
                echo '<span class="circle bg-' . get_field('color', $term) . '"></span> ' . $term->name . '</a>';
                if ($term_description) {
                    echo '<p class="timeline-filter-description">' . $term_description . '</p>';
                }
                echo '</li>';
            }
            ?>
        </ul>
    </div>
</div>

        <div class="timeline-wrap mt-4 timeline row">

            <div class="col-md-6"></div>

            <?php


            if ($timeline_items->have_posts()) {
                while ($timeline_items->have_posts()) {

                    $timeline_items->the_post();
                    // get the featured image
                    $timeline_photo = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    // get the image caption
                    // Get the caption
                    $timeline_photo_alt = get_post(get_post_thumbnail_id())->post_excerpt;

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
                        <div class="timeline-photo-wrap">
                            <img class="timeline-photo" src="<?php echo $timeline_photo; ?>" width="100%" height="200px" 
                            alt="<?php echo $timeline_photo_alt; ?>">

                        </div>
                        <div class="timeline-details">
                            <small class="timeline-date"><?php echo $timeline_date; ?></small>
                            <h3>
                                <a href="<?php echo $timeline_link; ?>" target="_blank">
                                    <?php echo $timeline_title; ?>
                                </a>
                            </h3>
                            <p><?php echo $timeline_content; ?></p>

                            <?php
                            $count = 1;
                            foreach ($areas_of_focus as $area) :

                            ?>
                                <div class="focus-area-wrap">
                                    <p class="timeline-tag tag-<?php echo $area['color']; ?>
                            <?php echo "timeline-tag-" . $count++; ?>
                        ">
                                        <?php if ($count == 2): ?>
                                            <small>Area of Focus</small>
                                        <?php else : ?>
                                            <small>Area of Focus</small>
                                        <?php endif; ?>

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
                                            
                                            <p class="priority-action-text">
                                            <small>Priority Action</small>    
                                            <?php echo $priority_action_text_2; ?></p>
                                        </div>
                                    <?php       } ?>

                                </div>


                            <?php endforeach;
                            ?>

                            <div class='timeline-link-wrap'>
                                <a target="_blank" href="<?php echo $timeline_link; ?>" class="btn btn-default">CONTINUE READING</a>
                            </div>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            function isElementInViewport(el) {
                const rect = el.getBoundingClientRect();
                return (
                    rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.8 && // Adjust this value for sooner activation
                    rect.bottom >= 0
                );
            }

            function checkElements() {
                const elements = document.querySelectorAll('.timeline-element');

                console.log('checking elements');
                elements.forEach(function(el) {
                    if (isElementInViewport(el)) {

                        var details = el.querySelector('.timeline-details');
                        var photo = el.querySelector('.timeline-photo');

                        details.style.opacity = 1;
                        details.style.transform = 'translateX(0)'; // Reset to the neutral position

                        photo.style.opacity = 1;
                        photo.style.transform = 'translateX(0)'; // Reset to the neutral position
                    }
                });
            }

            window.addEventListener('scroll', checkElements);
            window.addEventListener('resize', checkElements);

            // Initial check
            checkElements();

            // when filter h4 is clicked, toggle the class active on .timeline-filter
            document.querySelector('.timeline-filter h4').addEventListener('click', function() {
                document.querySelector('.timeline-filter').classList.toggle('active');
            });

            document.addEventListener('htmx:afterSwap', function(evt) {
                // after the swap is complete, check the elements again
                checkElements();
            });
        });
    </script>

</section>

<?php get_footer(); ?>