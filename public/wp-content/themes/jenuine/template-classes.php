<?php
/**
 *
 * Template Name: Fitness Classes
 *
 * Displays all the fitness classes configured for the site
 *
 * @package FitPro
 * @subpackage Template
 */

get_header();

$paged = (get_query_var('paged')) ? get_query_var('paged') : 0; // Do NOT paginate

$query_args = array('post_type' => 'fitness_class', 'posts_per_page' => -1);

$number_of_columns = 3;
$image_size = 'medium';
$excerpt_count = 138;

$show_content = false;

$style_class = mo_get_column_style($number_of_columns);

mo_exec_action('before_content');
?>

    <div id="content" class="twelvecol">

        <?php mo_exec_action('start_content'); ?>

        <div class="hfeed">

            <?php
            mo_show_page_content();

            if (isset($query_args) && !empty($query_args)) {
                query_posts($query_args);
            }

            if (have_posts()) :

                echo '<ul class="image-grid post-snippets">';

                while (have_posts()) : the_post();

                    mo_exec_action('before_entry'); ?>

                    <li data-id="<?php echo get_the_ID(); ?>" class="entry-item <?php echo $style_class; ?>">

                        <article id="post-<?php echo get_the_ID(); ?>"
                                 class="<?php echo join(' ', get_post_class()); ?> clearfix">

                            <?php

                            mo_exec_action('start_entry');

                            ?>

                            <div class="entry-snippet">

                                <?php

                                echo '<div class="img-wrap">';

                                mo_thumbnail(array('image_size' => $image_size, 'wrapper' => false));

                                echo '<div class="image-overlay"></div>';

                                echo mo_get_type_info();

                                echo '</div><!-- .img-wrap -->';

                                echo '<div class="entry-text-wrap">';

                                echo mo_get_entry_title();

                                echo '<div class="entry-summary">';

                                if ($show_content) {
                                    global $more;
                                    $more = 0;
                                    /*TODO: Remove the more link here since it will be shown later */
                                    the_content(__('Read More <span class="meta-nav">&rarr;</span>', 'mo_theme'));
                                }
                                else {
                                    echo mo_truncate_string(get_the_excerpt(), $excerpt_count);
                                }

                                echo '</div><!-- .entry-summary -->';

                                echo '</div><!-- .entry-text-wrap -->';

                                ?>

                            </div>
                            <!-- .entry-snippet -->

                            <?php mo_exec_action('end_entry'); ?>

                        </article>
                        <!-- .hentry -->

                    </li><!-- .isotope element -->

                    <?php mo_exec_action('after_entry');

                endwhile;

                echo '</ul><!-- post-snippets -->';

            else :

                get_template_part('loop-error'); // Loads the loop-error.php template.

            endif; ?>

        </div>
        <!-- .hfeed -->

        <?php mo_exec_action('end_content'); ?>

        <?php get_template_part('loop-nav'); // Loads the loop-nav.php template.
        ?>

    </div><!-- #content -->

<?php mo_exec_action('after_content');

wp_reset_query(); /* Right placement to help not lose context information */

get_footer();