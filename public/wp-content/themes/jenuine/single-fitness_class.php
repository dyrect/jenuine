<?php

/**
 * Post Template
 *
 * This template is loaded when browsing a Wordpress post.
 *
 * @package FitPro
 * @subpackage Template
 */

if (!function_exists('mo_display_trainer_thumbnails')) {
    function mo_display_trainer_thumbnails($trainer_ids) {

        $args = array(
            'post_type' => 'trainer',
            'post__in' => $trainer_ids
        );
        $trainers = get_posts($args);

        foreach ($trainers as $trainer_post) {

            $trainer_id = $trainer_post->ID;

            echo '<div class="trainer-info">';
            mo_thumbnail(array(
                'post_id' => $trainer_id,
                'image_size' => 'small',
                'wrapper' => false,
                'image_alt' => get_the_title($trainer_id),
                'size' => 'thumbnail'
            ));

            echo '<h3 class="entry-title"><a href="' . get_permalink($trainer_id) . '" title="' . get_the_title($trainer_id) . '" rel="bookmark">' . get_the_title($trainer_id) . '</a></h3>';

            echo '</div>';
        }
        wp_reset_postdata();
    }
}

$image_size = 'large';

get_header();
?>

<?php mo_exec_action('before_content'); ?>

    <div id="content" class="<?php echo mo_get_content_class(); ?>">

        <?php mo_exec_action('start_content'); ?>

        <div class="hfeed">

            <?php if (have_posts()) :

                while (have_posts()) :
                    the_post();

                    mo_exec_action('before_entry'); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <?php

                        mo_exec_action('start_entry');

                        ?>

                        <div class="entry-content clearfix">

                            <?php

                            mo_thumbnail(array(
                                'image_size' => $image_size,
                                'before_html' => '<div class="wrap">',
                                'after_html' => '</div>',
                                'wrapper' => false
                            ));

                            ?>

                            <div class="sixcol">

                                <?php

                                $characteristics = get_post_meta($post->ID, 'mo_characteristics', true);

                                if (!empty($characteristics)) {
                                    echo '<div class="characteristics info-section">';
                                    echo '<h5 class="subheading">' . __('Characteristics:', 'mo_theme') . '</h5>';
                                    echo '<div class="characteristics">' . do_shortcode($characteristics) . '</div>';
                                    echo '</div>';
                                }


                                ?>

                            </div>
                            <!-- .sixcol -->

                            <div class="sixcol last">

                                <?php

                                $trainer_names = array();
                                $trainer_ids = get_post_meta($post->ID, 'mo_trainers_for_class', true);
                                if (!empty($trainer_ids)) {
                                    echo '<div class="trainers info-section">';
                                    echo '<h5 class="subheading">' . __('Trainers:', 'mo_theme') . '</h5>';
                                    mo_display_trainer_thumbnails($trainer_ids);
                                    echo '</div>';
                                }

                                ?>

                            </div>
                            <!--- .sixcol.last -->

                            <div class="clear"></div>

                            <?php

                            echo '<div class="class-details info-section">';

                            the_content();

                            echo '</div>';

                            $class_stats = get_post_meta($post->ID, 'mo_class_stats', true);

                            if (!empty($class_stats)) {
                                echo '<div class="class-stats info-section">';
                                echo '<h5 class="subheading">' . __('Facts about ', 'mo_theme') . get_the_title() . ' -</h5>';
                                echo '<div class="class-stats">' . do_shortcode($class_stats) . '</div>';
                                echo '</div>';
                            }

                            wp_link_pages(array(
                                'link_before' => '<span class="page-number">',
                                'link_after' => '</span>',
                                'before' => '<p class="page-links">' . __('Pages:', 'mo_theme'),
                                'after' => '</p>'
                            ));

                            ?>

                        </div>
                        <!-- .entry-content -->

                        <?php mo_exec_action('end_entry'); ?>

                    </article>
                    <!-- .hentry -->

                    <?php mo_exec_action('after_entry');

                    echo '<h4 class="subheading">' . __('Related Classes', 'mo_theme') . '</h4>';

                    mo_display_related_posts('fitness_category');

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