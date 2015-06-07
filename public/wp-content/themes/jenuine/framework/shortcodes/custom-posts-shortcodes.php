<?php

/* Classes Shortcode -

Displays a list of fitness classes. These classes are entered by creating Fitness Class custom post types in the Classes tab of the WordPress Admin.
Usage:

[classes post_count=4 class_ids="234,235,236"]

Parameters -

post_count - The number of classes to be displayed. By default displays all of the custom posts entered as fitness class in the Classes tab of the WordPress Admin (optional).
class_ids - A comma separated post ids of the Fitness Class custom post types created in the Classes tab of the WordPress Admin. Helps to filter the classes for display (optional).
number_of_columns - number (default 3) - Number of columns of posts to display
display_title - boolean (default - true) - Specify if the title of the post needs to be displayed below the thumbnail image.
excerpt_count - number ( default - 0) - The number of characters of excerpt to display. Specify zero(0) will hide the excerpt.
show_content - boolean (default - false) - If set to true, displays the content of the post instead of excerpt and WP more tags should be inserted to generate summary.
class  - string - The class name to be inserted for the element wrapping the list of posts displayed.
image_size - string (default - medium) - Can be mini, small, medium, large, full, square. The actual image size to use for displaying the thumbnails. Since the theme is responsive and due to limited space available depending on the number of columns shown, the images retain their aspect ratio and occupy only the width available to them, not more.
*/

if (!function_exists('mo_classes_shortcode')) {
    function mo_classes_shortcode($atts, $content = null, $code) {
        extract(shortcode_atts(array(
            'post_count' => '-1',
            'class_ids' => '',
            'number_of_columns' => 3,
            'excerpt_count' => 0,
            'show_content' => false,
            'display_title' => "false",
            'class' => '',
            'image_size' => 'medium'
        ), $atts));

        $query_args = array(
            'posts_per_page' => (int)$post_count,
            'post_type' => 'fitness_class',
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'no_found_rows' => true,
        );
        if (!empty($class_ids))
            $query_args['post__in'] = explode(',', $class_ids);

        $query = new WP_Query($query_args);

        $style_class = mo_get_column_style($number_of_columns);
        $display_title = mo_to_boolean($display_title);
        $show_content = mo_to_boolean($show_content);

        $classes = '';
        if ($query->have_posts()) {

            // Gather output
            ob_start(); ?>

            <ul class="classes image-grid post-snippets <?php echo $class; ?>">

                <?php

                while ($query->have_posts()) : $query->the_post();

                    ?>

                    <li data-id="<?php echo get_the_ID(); ?>" class="entry-item <?php echo $style_class; ?>">

                        <article id="post-<?php echo get_the_ID(); ?>"
                                 class="<?php echo join(' ', get_post_class()); ?> clearfix">


                            <div class="entry-snippet">

                                <div class="img-wrap">

                                    <?php mo_thumbnail(array(
                                        'image_size' => $image_size,
                                        'wrapper' => false
                                    )); ?>

                                    <div class="image-overlay"></div>

                                    <?php echo mo_get_type_info(); ?>

                                </div>
                                <!-- .img-wrap -->

                                <?php if ($display_title || $excerpt_count != 0): ?>

                                    <div class="entry-text-wrap">

                                        <?php
                                        if ($display_title)
                                            echo the_title('<div class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></div>', false);
                                        ?>

                                        <?php if ($excerpt_count != 0): ?>

                                            <div class="entry-summary">

                                                <?php

                                                if ($show_content) {
                                                    global $more;
                                                    $more = 0;
                                                    /*TODO: Remove the more link here since it will be shown later */
                                                    the_content(__('Read More <span class="meta-nav">&rarr;</span>', 'mo_theme'));
                                                }
                                                else {
                                                    echo mo_truncate_string(get_the_excerpt(), $excerpt_count);
                                                }

                                                ?>

                                            </div>
                                            <!-- .entry-summary -->

                                        <?php endif; ?>

                                    </div>
                                    <!-- .entry-text-wrap -->

                                <?php endif; ?>

                            </div>
                            <!-- .entry-snippet -->

                        </article>
                        <!-- .hentry -->

                    </li><!-- .isotope element -->

                <?php

                endwhile;

                wp_reset_postdata();

                ?>

            </ul><!-- post-snippets -->

            <?php
            // Save output
            $classes = ob_get_contents();
            ob_end_clean();
        }

        return $classes;
    }
}

add_shortcode('classes', 'mo_classes_shortcode');


/* Features Shortcode -

Displays a list of features for a gymnasium. These features are entered by creating Feature custom post types in the Features tab of the WordPress Admin.
Usage:

[features post_count=4 feature_ids="234,235,236"]

Parameters -

post_count - The number of features to be displayed. By default displays all of the custom posts entered as feature in the Features tab of the WordPress Admin (optional).
feature_ids - A comma separated post ids of the Feature custom post types created in the Features tab of the WordPress Admin. Helps to filter the features for display (optional).
number_of_columns - number (default 3) - Number of columns of posts to display
display_title - boolean (default - true) - Specify if the title of the post needs to be displayed below the thumbnail image.
excerpt_count - number ( default - 0) - The number of characters of excerpt to display. Specify zero(0) will hide the excerpt.
show_content - boolean (default - false) - If set to true, displays the content of the post instead of excerpt and WP more tags should be inserted to generate summary.
class  - string - The class name to be inserted for the element wrapping the list of posts displayed.
image_size - string (default - medium) - Can be mini, small, medium, large, full, square. The actual image size to use for displaying the thumbnails. Since the theme is responsive and due to limited space available depending on the number of columns shown, the images retain their aspect ratio and occupy only the width available to them, not more.
*/

if (!function_exists('mo_features_shortcode')) {
    function mo_features_shortcode($atts, $content = null, $code) {
        extract(shortcode_atts(array(
            'post_count' => '-1',
            'feature_ids' => '',
            'number_of_columns' => 3,
            'display_title' => "true",
            'excerpt_count' => 0,
            'show_content' => false,
            'class' => '',
            'image_size' => 'medium'
        ), $atts));

        $query_args = array(
            'posts_per_page' => (int)$post_count,
            'post_type' => 'feature',
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'no_found_rows' => true,
        );
        if (!empty($feature_ids))
            $query_args['post__in'] = explode(',', $feature_ids);

        $query = new WP_Query($query_args);

        $style_class = mo_get_column_style($number_of_columns);
        $display_title = mo_to_boolean($display_title);
        $show_content = mo_to_boolean($show_content);

        $features = '';
        if ($query->have_posts()) {

            // Gather output
            ob_start(); ?>

            <ul class="features image-grid post-snippets <?php echo $class; ?>">

                <?php

                while ($query->have_posts()) : $query->the_post();

                    ?>

                    <li data-id="<?php echo get_the_ID(); ?>" class="entry-item <?php echo $style_class; ?>">

                        <article id="post-<?php echo get_the_ID(); ?>"
                                 class="<?php echo join(' ', get_post_class()); ?> clearfix">


                            <div class="entry-snippet">

                                <div class="img-wrap">

                                    <?php mo_thumbnail(array(
                                        'image_size' => $image_size,
                                        'wrapper' => false
                                    )); ?>

                                    <div class="image-overlay"></div>

                                    <?php

                                    echo mo_get_type_info();

                                    ?>

                                </div>
                                <!-- .img-wrap -->

                                <?php if ($display_title || $excerpt_count != 0): ?>

                                    <div class="entry-text-wrap">

                                        <?php
                                        if ($display_title)
                                            echo the_title('<div class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></div>', false);
                                        ?>

                                        <?php if ($excerpt_count != 0): ?>

                                            <div class="entry-summary">

                                                <?php

                                                if ($show_content) {
                                                    global $more;
                                                    $more = 0;
                                                    /*TODO: Remove the more link here since it will be shown later */
                                                    the_content(__('Read More <span class="meta-nav">&rarr;</span>', 'mo_theme'));
                                                }
                                                else {
                                                    echo mo_truncate_string(get_the_excerpt(), $excerpt_count);
                                                }

                                                ?>

                                            </div>
                                            <!-- .entry-summary -->

                                        <?php endif; ?>

                                    </div>
                                    <!-- .entry-text-wrap -->

                                <?php endif; ?>

                            </div>
                            <!-- .entry-snippet -->

                        </article>
                        <!-- .hentry -->

                    </li><!-- .isotope element -->

                <?php

                endwhile;

                wp_reset_postdata();

                ?>

            </ul><!-- post-snippets -->

            <?php
            // Save output
            $features = ob_get_contents();
            ob_end_clean();
        }

        return $features;
    }
}

add_shortcode('features', 'mo_features_shortcode');

/* Upcoming Events Shortcode -

Displays a list of events. These events are entered by creating Event custom post types in the Events tab of the WordPress Admin.

The events are managed by The Events Calendar Pro plugin

Usage:

[upcoming_events post_count=4 all_events_link="true" class="simple-list"]

Parameters -

post_count - number (default - 5) The number of events to be displayed. By default displays all of the custom posts entered as feature in the Features tab of the WordPress Admin (optional).
category_ids - A comma separated category ids of the Event custom post types created in the Events tab of the WordPress Admin. Helps to filter the events for display (optional).
all_events_link - boolean (default true) - Specify if a link to all events must be displayed below the list of events.
no_upcoming_events - boolean (default - false) - Applies only when there are no upcoming events found. If set to true, no message will be displayed indicating that no upcoming events were found.
class  - string - The class name to be inserted for the element wrapping the list of posts displayed.
*/
if (!function_exists('mo_events_shortcode')) {
    function mo_events_shortcode($atts, $content = null, $code) {
        extract(shortcode_atts(array(
            'post_count' => '5',
            'category_ids' => '',
            'class' => '',
            'all_events_link' => 'true',
            'no_upcoming_events' => 'false'
        ), $atts));

        $no_upcoming_events = mo_to_boolean($no_upcoming_events);
        $all_events_link = mo_to_boolean($all_events_link);

        if (function_exists('tribe_get_events')) {

            $args = array(
                'eventDisplay' => 'list',
                'posts_per_page' => (int)$post_count,
            );

            if (!empty($category_ids)) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => TribeEvents::TAXONOMY,
                        'terms' => $category_ids,
                        'field' => 'ID',
                        'include_children' => false
                    )
                );
            }

            $posts = tribe_get_events($args);
        }

        // if no posts, and the don't show if no posts checked, let's bail
        if (!$posts && $no_upcoming_events) {
            return;
        }

        // Gather output
        ob_start();

        if ($posts) {

            ?>

            <ol class="hfeed vcalendar upcoming-events-list <?php echo $class; ?>">

                <?php

                /* Credit - http://wordpress.stackexchange.com/questions/9834/setup-postdata-does-not-seem-to-be-working
                *  Must use $global $post */
                global $post;

                foreach ($posts as $post) :

                    setup_postdata($post);

                    if (class_exists('TribeEventsPro')) {
                        $ecp = TribeEventsPro::instance();
                        $tooltip_status = $ecp->recurring_info_tooltip_status();
                        $ecp->disable_recurring_info_tooltip();
                    }

                    ?>

                    <li class="<?php tribe_events_event_classes() ?>">

                        <h4 class="entry-title summary">
                            <a href="<?php echo tribe_get_event_link(); ?>" rel="bookmark"><?php the_title(); ?></a>
                        </h4>

                        <div class="duration">
                            <?php echo tribe_events_event_schedule_details(); ?>
                        </div>

                    </li>

                    <?php

                    if (isset($tooltip_status)) {
                        $ecp->enable_recurring_info_tooltip();
                    }

                endforeach;

                ?>

            </ol><!-- .hfeed -->

            <?php

            if ($all_events_link) {

                // Link to the main events page (should work even if month/list views are disabled)
                $event_url = tribe_get_events_link();

                ?>


                <p>
                    <a href="<?php echo $event_url; ?>" rel="bookmark" class="all-events-link">
                        <?php

                        if (empty($category)) {
                            echo __('View All Events', 'mo_theme');
                        }
                        else {
                            echo __('View All Events in Category', 'mo_theme');
                        }

                        ?>
                    </a>
                </p>
            <?php

            }
        }
        else {
            echo '<p>' . __('There are no upcoming events at this time.', 'mo_theme') . '</p>';
        }

        /* resets the WordPress Query */
        wp_reset_postdata();

        // Save output
        $events = ob_get_contents();

        ob_end_clean();

        return $events;
    }

}

add_shortcode('upcoming_events', 'mo_events_shortcode');
