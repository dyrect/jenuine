<?php

/**
 * Post Template
 *
 * This template is loaded when browsing a Wordpress post.
 *
 * @package FitPro
 * @subpackage Template
 */

$image_size = array('width' => 350, 'height' => 410);

get_header();
?>

<?php mo_exec_action('before_content'); ?>

    <div id="content" class="<?php echo mo_get_content_class(); ?>">

        <?php mo_exec_action('start_content'); ?>

        <div class="hfeed">

            <?php if (have_posts()) :

                while (have_posts()) : the_post();

                    mo_exec_action('before_entry'); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <?php

                        mo_exec_action('start_entry');

                        ?>

                        <div class="entry-content clearfix">

                            <div class="sixcol trainer-img">

                                <?php

                                mo_thumbnail(array('image_size' => $image_size, 'before_html' => '<div class="wrap">', 'after_html' => '</div>', 'wrapper' => false));

                                ?>

                            </div>
                            <!-- .sixcol -->

                            <div class="sixcol last">

                                <?php

                                $certifications = get_post_meta($post->ID, 'mo_certifications', true);

                                if (!empty($certifications)) {
                                    echo '<div class="certification info-section first">';
                                    echo '<h5 class="subheading">' . __('Certifications:', 'mo_theme') . '</h5>';
                                    echo '<div class="certifications">' . $certifications . '</div>';
                                    echo '</div>';
                                }

                                $specializations = get_post_meta($post->ID, 'mo_specializations', true);

                                if (!empty($specializations)) {
                                    echo '<div class="specialization info-section">';
                                    echo '<h5 class="subheading">' . __('Specializations:', 'mo_theme') . '</h5>';
                                    echo '<div class="specializations">' . do_shortcode($specializations) . '</div>';
                                    echo '</div>';
                                }

                                ?>

                                <div class="socials info-section">

                                    <?php

                                    $post_id = $post->ID;
                                    $email = get_post_meta($post_id, 'mo_email', true);
                                    $twitter = get_post_meta($post_id, 'mo_twitter', true);
                                    $linkedin = get_post_meta($post_id, 'mo_linkedin', true);
                                    $googleplus = get_post_meta($post_id, 'mo_googleplus', true);
                                    $facebook = get_post_meta($post_id, 'mo_facebook', true);
                                    $dribbble = get_post_meta($post_id, 'mo_dribbble', true);
                                    $instagram = get_post_meta($post_id, 'mo_instagram', true);

                                    echo '<h5 class="subheading">' . __('Get in Touch:', 'mo_theme'). '</h5>';
                                    $shortcode_text = '[social_list';
                                    $shortcode_text .= $email ? ' email="' . $email . '"' : '';
                                    $shortcode_text .= $twitter ? ' twitter_url="' . $twitter . '"' : '';
                                    $shortcode_text .= $googleplus ? ' googleplus_url="' . $googleplus . '"' : '';
                                    $shortcode_text .= $linkedin ? ' linkedin_url="' . $linkedin . '"' : '';
                                    $shortcode_text .= $facebook ? ' facebook_url="' . $facebook . '"' : '';
                                    $shortcode_text .= $dribbble ? ' dribbble_url="' . $dribbble . '"' : '';
                                    $shortcode_text .= $instagram ? ' instagram_url="' . $instagram . '"' : '';
                                    $shortcode_text .= ' align="right"]';

                                    echo do_shortcode($shortcode_text);

                                    ?>

                                </div>

                            </div>
                            <!--- .sixcol.last -->

                            <div class="clear"></div>

                            <?php

                            echo '<div class="trainer-bio info-section">';

                            the_content();

                            echo '</div>';

                            $experience = get_post_meta($post->ID, 'mo_experience', true);

                            if (!empty($experience)) {
                                echo '<div class="experience info-section">';
                                echo '<h5 class="subheading">'. __('Facts about ' , 'mo_theme') . get_the_title() . ' -</h5>';
                                echo '<div class="experience">' . do_shortcode($experience) . '</div>';
                                echo '</div>';
                            }

                            wp_link_pages(array('link_before' => '<span class="page-number">', 'link_after' => '</span>', 'before' => '<p class="page-links">' . __('Pages:', 'mo_theme'), 'after' => '</p>'));

                            ?>

                        </div>
                        <!-- .entry-content -->

                        <?php mo_exec_action('end_entry'); ?>

                    </article><!-- .hentry -->

                    <?php mo_exec_action('after_entry');

                    mo_exec_action('after_singular');

                endwhile;

            endif; ?>

        </div>
        <!-- .hfeed -->

        <?php mo_exec_action('end_content'); ?>

        <?php get_template_part('loop-nav'); // Loads the loop-nav.php template.   ?>

    </div><!-- #content -->

<?php mo_exec_action('after_content'); ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>