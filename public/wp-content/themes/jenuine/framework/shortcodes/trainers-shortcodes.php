<?php

/* Trainers Shortcode -

Displays a list of trainers. These trainers are entered by creating Trainer custom post types in the Trainer Profiles tab of the WordPress Admin.
Usage:

[trainers post_count=4 class_ids="234,235,236"]

Parameters -

post_count - The number of trainers to be displayed. By default displays all of the custom posts entered as fitness class in the Trainer Profiles tab of the WordPress Admin (optional).
class_ids - A comma separated post ids of the Trainer custom post types created in the Trainer Profiles tab of the WordPress Admin. Helps to filter the trainers for display (optional).
number_of_columns - number (default 3) - Number of columns of posts to display
display_title - boolean (default - true) - Specify if the title of the post needs to be displayed below the thumbnail image.
excerpt_count - number ( default - 0) - The number of characters of excerpt to display. Specify zero(0) will hide the excerpt.
show_content - boolean (default - false) - If set to true, displays the content of the post instead of excerpt and WP more tags should be inserted to generate summary.
class  - string - The class name to be inserted for the element wrapping the list of posts displayed.
image_size - string (default - medium) - Can be mini, small, medium, large, full, square. The actual image size to use for displaying the thumbnails. Since the theme is responsive and due to limited space available depending on the number of columns shown, the images retain their aspect ratio and occupy only the width available to them, not more.
*/

if (!function_exists('mo_trainers_shortcode')) {
    function mo_trainers_shortcode($atts, $content = null, $code) {
        extract(shortcode_atts(array(
            'post_count' => '-1',
            'trainer_ids' => '',
            'number_of_columns' => 3,
            'excerpt_count' => 0,
            'show_content' => false,
            'display_title' => "true",
            'display_certifications' => "true",
            'class' => '',
            'image_size' => 'medium'
        ), $atts));

        $query_args = array(
            'posts_per_page' => (int)$post_count,
            'post_type' => 'trainer',
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'no_found_rows' => true,
        );
        if (!empty($trainer_ids))
            $query_args['post__in'] = explode(',', $trainer_ids);

        $query = new WP_Query($query_args);

        $style_class = mo_get_column_style($number_of_columns);
        $display_title = mo_to_boolean($display_title);
        $display_certifications = mo_to_boolean($display_certifications);
        $show_content = mo_to_boolean($show_content);

        $trainers = '';
        if ($query->have_posts()) {

            // Gather output
            ob_start(); ?>

            <ul class="trainers image-grid post-snippets <?php echo $class; ?>">

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

                                    echo mo_get_type_info(__('View Bio', 'mo_theme'));

                                    ?>

                                </div>
                                <!-- .img-wrap -->

                                <?php if ($display_title || $display_certifications || $excerpt_count != 0): ?>

                                    <div class="entry-text-wrap">

                                        <?php

                                        if ($display_title)
                                            echo the_title('<div class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></div>', false);

                                        if ($display_certifications) {
                                            $certifications = get_post_meta(get_the_ID(), 'mo_certifications', true);

                                            if (!empty($certifications)) {
                                                echo '<div class="certifications">' . $certifications . '</div>';
                                            }
                                        }

                                        if ($excerpt_count != 0):

                                            ?>

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
            $trainers = ob_get_contents();
            ob_end_clean();
        }

        return $trainers;
    }
}

add_shortcode('trainers', 'mo_trainers_shortcode');


/* Trainers Slider Shortcode 2 -

Displays a slider for the trainers entered by creating Trainer custom post types in the Trainer Profiles tab of the WordPress Admin.
Usage:

[trainers_slider post_count=4 class_ids="234,235,236"]

Parameters -

post_count - The number of trainers to be displayed. By default displays all of the custom posts entered as fitness class in the Trainer Profiles tab of the WordPress Admin (optional).
class_ids - A comma separated post ids of the Trainer custom post types created in the Trainer Profiles tab of the WordPress Admin. Helps to filter the trainers for display (optional).

*/

/* Shortcode for source code formatting */
function mo_trainers_slider_shortcode($atts, $content = null, $shortcode_name = "") {

    extract(shortcode_atts(array(
        'post_count' => '-1',
        'trainer_ids' => ''
    ), $atts));


    global $post;

    $query_args = array(
        'posts_per_page' => (int)$post_count,
        'post_type' => 'trainer',
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'no_found_rows' => true,
    );
    if (!empty($trainer_ids))
        $query_args['post__in'] = explode(',', $trainer_ids);

    // Get 'team' posts
    $team_posts = get_posts($query_args);

    $output = null;
    if ($team_posts):

        // Gather output
        ob_start();
        ?>

        <div class="team-slider-profiles flexslider">

            <ul class="slides">

                <?php

                $member_names = array(); // store the names for populating the member name indices later
                $member_count = 0;

                foreach ($team_posts as $post):
                    setup_postdata($post);
                    $post_id = $post->ID;
                    $member_name = get_the_title();
                    $member_names[] = $member_name;
                    $position = htmlspecialchars_decode(get_post_meta($post_id, 'mo_position', true));
                    $member_quote = htmlspecialchars_decode(get_post_meta($post_id, 'mo_member_quote', true));
                    $certifications = get_post_meta(get_the_ID(), 'mo_certifications', true);

                    ?>

                    <li id="<?php echo 'slider-member' . ++$member_count ?>">

                        <div class="fivecol">

                            <div class="center">

                                <div class="team-member">

                                    <div class="img-wrap">
                                        <?php mo_thumbnail(array(
                                            'before_html' => '<p>',
                                            'after_html' => '</p>',
                                            'image_size' => 'square',
                                            'image_class' => 'alignleft',
                                            'wrapper' => false,
                                            'image_alt' => 'Testimonial',
                                            'size' => 'full'
                                        )); ?>
                                    </div>

                                    <h3><?php echo $member_name; ?> </h3>

                                    <?php if (!empty($certifications)): ?>

                                        <p class="certifications"><?php echo $certifications; ?></p>

                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>

                        <div class="sevencol last">

                            <?php if (!empty($member_quote)) : ?>
                                <h3 class="member-quote"><?php echo '&#34;' . $member_quote . '&#34;'; ?> </h3>
                            <?php else: ?>
                                <h3 class="member-title"><?php echo __('About ', 'mo_theme') . $member_name; ?> </h3>
                            <?php endif; ?>

                            <div class="member-content">

                                <?php
                                global $more;
                                $more = 0;
                                echo do_shortcode(get_the_content(__('Read More <span class="meta-nav">&rarr;</span>', 'mo_theme')));
                                ?>

                            </div>

                            <div class="footer">
                                <span class="trainer-bio"><a class="button theme" href="<?php the_permalink() ?>"
                                                             title="<?php the_title() ?>"><?php echo __('See Trainer Bio', 'mo_theme') ?></a></span>
                                <?php
                                $page_id = mo_get_theme_option('mo_trainers_page');
                                if (!empty($page_id)):
                                    ?>
                                    <span class="trainers-archive"><a class="button theme"
                                                                      href="<?php echo get_the_permalink($page_id) ?>"
                                                                      title="<?php echo get_the_title($page_id) ?>"><?php echo __('Meet Our Trainers', 'mo_theme') ?></a></span>
                                <?php endif; ?>

                            </div>
                        </div>
                    </li>

                    <?php wp_reset_postdata(); ?>

                <?php endforeach; ?>

            </ul>
            <!-- /.row -->
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                jQuery('.team-slider-profiles').flexslider({
                    animation: 'slide',
                    controlsContainer: ".member-list",
                    controlNav: true,
                    directionNav: false,
                    animationLoop: false,
                    slideshow: false,
                    manualControls: ".member-list li a"
                });
            });
        </script>

        <?php

        $member_count = 0;

        $output = '<ul class="member-list">';

        foreach ($member_names as $name) {
            $output .= '<li><a href="#slider-member' . ++$member_count . '">' . $name . '</a></li>';
        }

        $output .= '</ul>';

        // Save output
        $output .= ob_get_contents();
        ob_end_clean();

    endif; // end if $team_posts

    // Output the HTML if it exists
    return ($output) ? $output : '';
}


add_shortcode('trainers_slider', 'mo_trainers_slider_shortcode');