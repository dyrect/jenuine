<?php

if (!function_exists('mo_register_custom_post_types')) {
    function mo_register_custom_post_types() {

        mo_register_taxonomies();

        if (current_theme_supports('portfolio')) {
            mo_register_portfolio_type();
        }

        mo_register_gallery_type();

        if (current_theme_supports('composite-page'))
            mo_register_page_section_type();

        mo_register_showcase_slide_type();

        mo_register_trainer_profile_post_type();

        mo_register_testimonials_post_type();

        mo_register_pricing_post_type();

        mo_register_fitness_class_post_type();

        mo_register_features_post_type();

        /* Manage Portfolio Columns */
        add_filter('manage_edit-page_section_columns', 'mo_page_section_type_edit_columns');
        add_action('manage_posts_custom_column', 'mo_page_section_type_custom_columns');

        add_filter('manage_edit-gallery_item_columns', 'mo_gallery_item_type_edit_columns');
        add_action('manage_posts_custom_column', 'mo_gallery_item_type_custom_columns');

        /* Manage Testimonials Columns */
        add_filter('manage_edit-testimonials_columns', 'mo_testimonials_edit_columns');
        add_action('manage_posts_custom_column', 'mo_testimonials_columns');

        /* Manage Testimonials Columns */
        add_filter('manage_edit-fitness_class_columns', 'mo_fitness_classes_edit_columns');
        add_action('manage_posts_custom_column', 'mo_fitness_classes_columns');

        /* Manage Testimonials Columns */
        add_filter('manage_edit-feature_columns', 'mo_features_edit_columns');
        add_action('manage_posts_custom_column', 'mo_features_columns');

        /* Manage Trainer Columns */
        add_filter('manage_edit-trainer_columns', 'mo_trainer_profiles_edit_columns');
        add_action('manage_posts_custom_column', 'mo_trainer_profiles_columns');

        add_filter('manage_edit-pricing_columns', 'mo_pricing_edit_columns');
        add_action('manage_posts_custom_column', 'mo_pricing_columns');
    }
}

if (!function_exists('mo_register_taxonomies')) {
    function mo_register_taxonomies() {
        register_taxonomy('fitness_category', array(), array('hierarchical' => true,
            'label' => __('Fitness Category', 'mo_theme'),
            'singular_label' => __('Fitness Category', 'mo_theme'),
            'rewrite' => true,
            'query_var' => true
        ));
    }
}

if (!function_exists('mo_register_testimonials_post_type')) {
    function mo_register_testimonials_post_type() {
        $labels = array(
            'name' => _x('Testimonials', 'post type general name', 'mo_theme'),
            'singular_name' => _x('Testimonial', 'post type singular name', 'mo_theme'),
            'menu_name' => _x('Testimonials', 'post type menu name', 'mo_theme'),
            'add_new' => _x("Add New", "testimonial item", 'mo_theme'),
            'add_new_item' => __('Add New Testimonial', 'mo_theme'),
            'edit_item' => __('Edit Testimonial', 'mo_theme'),
            'new_item' => __('New Testimonial', 'mo_theme'),
            'view_item' => __('View Testimonial', 'mo_theme'),
            'search_items' => __('Search Testimonials', 'mo_theme'),
            'not_found' => __('No Testimonials found', 'mo_theme'),
            'not_found_in_trash' => __('No Testimonials in the trash', 'mo_theme'),
            'parent_item_colon' => '',
        );

        register_post_type('testimonials', array(
            'labels' => $labels,
            'public' => false,
            'publicly_queryable' => true,
            'show_ui' => true,
            'exclude_from_search' => true,
            'query_var' => true,
            'rewrite' => false,
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => false,
            'menu_position' => 10,
            'menu_icon' => MO_THEME_URL . '/images/admin/balloon-quotation.png',
            'supports' => array('title', 'editor', 'thumbnail', 'page-attributes')
        ));
    }
}

if (!function_exists('mo_register_fitness_class_post_type')) {
    function mo_register_fitness_class_post_type() {
        $labels = array(
            'name' => 'Classes',
            'singular_name' => 'Class',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Class',
            'edit_item' => 'Edit Class',
            'new_item' => 'New Class',
            'view_item' => 'View Class',
            'search_items' => 'Search Classes',
            'not_found' => 'No Classes found',
            'not_found_in_trash' => 'No Classes in the trash',
            'parent_item_colon' => '',
        );

        register_post_type('fitness_class', array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'exclude_from_search' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'fitness-class'),
            'capability_type' => 'post',
            'taxonomies' => array('fitness_category'),
            'has_archive' => false,
            'hierarchical' => false,
            'menu_position' => 10,
            'menu_icon' => MO_THEME_URL . '/images/admin/balloon-quotation.png',
            'supports' => array('title', 'editor', 'thumbnail', 'page-attributes', 'custom-fields')
        ));

        register_taxonomy_for_object_type('fitness_class', 'fitness_category');

    }
}

if (!function_exists('mo_register_features_post_type')) {
    function mo_register_features_post_type() {
        $labels = array(
            'name' => 'Features',
            'singular_name' => 'Feature',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Feature',
            'edit_item' => 'Edit Feature',
            'new_item' => 'New Feature',
            'view_item' => 'View Feature',
            'search_items' => 'Search Features',
            'not_found' => 'No Features found',
            'not_found_in_trash' => 'No Features in the trash',
            'parent_item_colon' => '',
        );

        register_post_type('feature', array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'exclude_from_search' => true,
            'query_var' => true,
            'rewrite' => false,
            'capability_type' => 'post',
            'taxonomies' => array('fitness_category'),
            'has_archive' => false,
            'hierarchical' => false,
            'menu_position' => 10,
            'menu_icon' => MO_THEME_URL . '/images/admin/balloon-quotation.png',
            'supports' => array('title', 'editor', 'thumbnail', 'page-attributes', 'custom-fields')
        ));

        register_taxonomy_for_object_type('feature', 'fitness_category');
    }
}

if (!function_exists('mo_register_pricing_post_type')) {
    function mo_register_pricing_post_type() {
        $labels = array(
            'name' => _x('Pricing Plans', 'post type general name', 'mo_theme'),
            'singular_name' => _x('Pricing Plan', 'post type singular name', 'mo_theme'),
            'menu_name' => _x('Pricing Plan', 'post type menu name', 'mo_theme'),
            'add_new' => _x('Add New', 'pricing plan item', 'mo_theme'),
            'add_new_item' => __('Add New Pricing Plan', 'mo_theme'),
            'edit_item' => __('Edit Pricing Plan', 'mo_theme'),
            'new_item' => __('New Pricing Plan', 'mo_theme'),
            'view_item' => __('View Pricing Plan', 'mo_theme'),
            'search_items' => __('Search Pricing Plans', 'mo_theme'),
            'not_found' => __('No Pricing Plans found', 'mo_theme'),
            'not_found_in_trash' => __('No Pricing Plans in the trash', 'mo_theme'),
            'parent_item_colon' => ''
        );

        register_post_type('pricing', array(
            'labels' => $labels,
            'public' => false,
            'publicly_queryable' => true,
            'show_ui' => true,
            'exclude_from_search' => true,
            'query_var' => true,
            'rewrite' => false,
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => false,
            'menu_position' => 10,
            'menu_icon' => MO_THEME_URL . '/images/admin/price-tag.png',
            'supports' => array('title', 'editor', 'page-attributes')
        ));
    }
}

if (!function_exists('mo_register_trainer_profile_post_type')) {
    function mo_register_trainer_profile_post_type() {
        // Labels
        $labels = array(
            'name' => _x("Trainers", "post type general name", 'mo_theme'),
            'singular_name' => _x("Trainer Profile", "post type singular name", 'mo_theme'),
            'menu_name' => 'Trainer Profiles',
            'add_new' => _x("Add New", "trainer item", 'mo_theme'),
            'add_new_item' => __("Add New Trainer Profile", 'mo_theme'),
            'edit_item' => __("Edit Trainer Profile", 'mo_theme'),
            'new_item' => __("New Trainer Profile", 'mo_theme'),
            'view_item' => __("View Profile", 'mo_theme'),
            'search_items' => __("Search Trainer Profiles", 'mo_theme'),
            'not_found' => __("No Trainer Profiles Found", 'mo_theme'),
            'not_found_in_trash' => __("No Trainer Profiles Found in Trash", 'mo_theme'),
            'parent_item_colon' => ''
        );

        // Register post type
        register_post_type('trainer', array(
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'hierarchical' => false,
            'publicly_queryable' => true,
            'query_var' => true,
            'exclude_from_search' => false,
            'taxonomies' => array('fitness_category'),
            'show_in_nav_menus' => false,
            'menu_position' => 20,
            'has_archive' => false,
            'menu_icon' => get_template_directory_uri() . '/images/admin/users.png',
            'rewrite' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'page-attributes', 'custom-fields')
        ));

        register_taxonomy_for_object_type('trainer', 'fitness_category');
    }

}

if (!function_exists('mo_register_portfolio_type')) {
    function mo_register_portfolio_type() {

        $labels = array(
            'name' => _x('Portfolio', 'portfolio name', 'mo_theme'),
            'singular_name' => _x('Portfolio Entry', 'portfolio type singular name', 'mo_theme'),
            'menu_name' => _x('Portfolio', 'portfolio type menu name', 'mo_theme'),
            'add_new' => _x('Add New', 'portfolio item', 'mo_theme'),
            'add_new_item' => __('Add New Portfolio Entry', 'mo_theme'),
            'edit_item' => __('Edit Portfolio Entry', 'mo_theme'),
            'new_item' => __('New Portfolio Entry', 'mo_theme'),
            'view_item' => __('View Portfolio Entry', 'mo_theme'),
            'search_items' => __('Search Portfolio Entries', 'mo_theme'),
            'not_found' => __('No Portfolio Entries Found', 'mo_theme'),
            'not_found_in_trash' => __('No Portfolio Entries Found in Trash', 'mo_theme'),
            'parent_item_colon' => ''
        );

        register_post_type('portfolio', array('labels' => $labels,

                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'publicly_queryable' => true,
                'query_var' => true,
                'exclude_from_search' => false,
                'rewrite' => array('slug' => 'portfolio'),
                'taxonomies' => array('portfolio_category'),
                'show_in_nav_menus' => false,
                'menu_position' => 20,
                'menu_icon' => MO_THEME_URL . '/images/admin/portfolio.png',
                'supports' => array('title', 'editor', 'thumbnail', 'comments', 'excerpt', 'custom-fields')
            )
        );

        register_taxonomy('portfolio_category', array('portfolio'), array('hierarchical' => true,
            'label' => __('Portfolio Categories', 'mo_theme'),
            'singular_label' => __('Portfolio Category', 'mo_theme'),
            'rewrite' => true,
            'query_var' => true
        ));
    }
}

if (!function_exists('mo_register_gallery_type')) {
    function mo_register_gallery_type() {

        $labels = array(
            'name' => _x('Gallery', 'gallery name', 'mo_theme'),
            'singular_name' => _x('Gallery Entry', 'gallery type singular name', 'mo_theme'),
            'menu_name' => _x('Gallery', 'gallery type menu name', 'mo_theme'),
            'add_new' => _x('Add New', 'gallery', 'mo_theme'),
            'add_new_item' => __('Add New Gallery Entry', 'mo_theme'),
            'edit_item' => __('Edit Gallery Entry', 'mo_theme'),
            'new_item' => __('New Gallery Entry', 'mo_theme'),
            'view_item' => __('View Gallery Entry', 'mo_theme'),
            'search_items' => __('Search Gallery Entries', 'mo_theme'),
            'not_found' => __('No Gallery Entries Found', 'mo_theme'),
            'not_found_in_trash' => __('No Gallery Entries Found in Trash', 'mo_theme'),
            'parent_item_colon' => ''
        );

        register_post_type('gallery_item', array('labels' => $labels,

                'public' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'publicly_queryable' => true,
                'query_var' => true,
                'exclude_from_search' => false,
                'rewrite' => array('slug' => 'gallery'),
                'taxonomies' => array('gallery_category'),
                'show_in_nav_menus' => false,
                'menu_position' => 20,
                'menu_icon' => MO_THEME_URL . '/images/admin/portfolio.png',
                'supports' => array('title', 'thumbnail', 'excerpt')
            )
        );

        register_taxonomy('gallery_category', array('gallery_item'), array('hierarchical' => true,
            'label' => __('Gallery Categories', 'mo_theme'),
            'singular_label' => __('Gallery Category', 'mo_theme'),
            'rewrite' => true,
            'query_var' => true
        ));
    }

}

if (!function_exists('mo_register_page_section_type')) {
    function mo_register_page_section_type() {

        $labels = array(
            'name' => _x('Page Section', 'page section general name', 'mo_theme'),
            'singular_name' => _x('Page Section', 'page section singular name', 'mo_theme'),
            'add_new' => _x('Add New', 'page ', 'mo_theme'),
            'add_new_item' => __('Add New Page Section', 'mo_theme'),
            'edit_item' => __('Edit Page Section', 'mo_theme'),
            'new_item' => __('New Page Section', 'mo_theme'),
            'view_item' => __('View Page Section', 'mo_theme'),
            'search_items' => __('Search Page Sections', 'mo_theme'),
            'not_found' => __('No Page Sections Found', 'mo_theme'),
            'not_found_in_trash' => __('No Page Sections Found in Trash', 'mo_theme'),
            'parent_item_colon' => ''
        );

        register_post_type('page_section', array('labels' => $labels,
                'description' => __('A custom post type which represents a section like about, work, services, trainer etc. part of a typical single page site. Can be made up of one or more segments.', 'mo_theme'),
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'capability_type' => 'page',
                'hierarchical' => false,
                'publicly_queryable' => true,
                'query_var' => true,
                'exclude_from_search' => true,
                'show_in_nav_menus' => false,
                'menu_position' => 15,
                'menu_icon' => MO_THEME_URL . '/images/admin/blogs-stack.png',
                'rewrite' => array('slug' => 'page-section'),
                'supports' => array('title', 'editor', 'page-attributes', 'revisions')
            )
        );

    }
}

if (!function_exists('mo_register_showcase_slide_type')) {
    function mo_register_showcase_slide_type() {
        register_post_type('showcase_slide', array(
            'labels' => array(
                'name' => __('Showcase Slides', 'mo_theme'),
                'singular_name' => __('Showcase Slide', 'post type singular name', 'mo_theme'),
                'menu_name' => _x('Showcase Slides', 'post type menu name', 'mo_theme'),
                'add_new' => _x('Add New', 'showcase slide item', 'mo_theme'),
                'add_new_item' => __('Add New Slide', 'mo_theme'),
                'edit_item' => __('Edit Slide', 'mo_theme'),
                'new_item' => __('New Slide', 'mo_theme'),
                'view_item' => __('View Slide', 'mo_theme'),
                'search_items' => __('Search Slides', 'mo_theme'),
                'not_found' => __('No Slides Found', 'mo_theme'),
                'not_found_in_trash' => __('No Slides Found in Trash', 'mo_theme'),
                'parent_item_colon' => ''
            ),
            'description' => __('A custom post type which has the required information to display showcase slides in a slider', 'mo_theme'),
            'public' => false,
            'show_ui' => true,
            'publicly_queryable' => false,
            'capability_type' => 'post',
            'hierarchical' => false,
            'exclude_from_search' => true,
            'menu_position' => 20,
            'menu_icon' => MO_THEME_URL . '/images/admin/slides-stack.png',
            'supports' => array('title', 'thumbnail', 'page-attributes')
        ));
    }
}

if (!function_exists('mo_page_section_type_edit_columns')) {
    function mo_page_section_type_edit_columns($columns) {

        $new_columns = array(

            'page_section_order' => __('Order', 'mo_theme')
        );

        $columns = array_merge($columns, $new_columns);

        return $columns;
    }
}

if (!function_exists('mo_page_section_type_custom_columns')) {
    function mo_page_section_type_custom_columns($column) {
        global $post;
        switch ($column) {
            case 'page_section_order':
                echo $post->menu_order;
                break;
        }
    }
}

if (!function_exists('mo_gallery_item_type_edit_columns')) {
    function mo_gallery_item_type_edit_columns($columns) {

        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Gallery Title', 'mo_theme'),
            'gallery_thumbnail' => __('Thumbnail', 'mo_theme'),
            'gallery_category' => __('Category', 'mo_theme')
        );

        return $columns;
    }
}

if (!function_exists('mo_gallery_item_type_custom_columns')) {

    function mo_gallery_item_type_custom_columns($column) {
        global $post;
        switch ($column) {
            case 'gallery_category':
                echo get_the_term_list($post->ID, 'gallery_category', '', ', ', '');
                break;
            case 'gallery_thumbnail':
                mo_thumbnail(array('image_size' => 'mini', 'wrapper' => false, 'image_alt' => get_the_title(), 'size' => 'thumbnail'));
                break;
        }
    }
}

if (!function_exists('mo_trainer_profiles_edit_columns')) {
    function mo_trainer_profiles_edit_columns($columns) {

        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Trainer Name', 'mo_theme'),
            'trainer_thumbnail' => __('Trainer Photo', 'mo_theme'),
            'trainer_certifications' => __('Certifications', 'mo_theme'),
            'trainer_order' => __('Order', 'mo_theme')
        );

        return $columns;
    }
}

if (!function_exists('mo_trainer_profiles_columns')) {

    function mo_trainer_profiles_columns($column) {
        global $post;
        switch ($column) {
            case 'trainer_thumbnail':
                mo_thumbnail(array('image_size' => 'mini', 'wrapper' => false, 'image_alt' => get_the_title(), 'size' => 'thumbnail'));
                break;
            case 'trainer_certifications':
                echo get_post_meta($post->ID, 'mo_certifications', true);
                break;
            case 'trainer_order':
                echo $post->menu_order;
                break;
        }
    }
}

if (!function_exists('mo_testimonials_edit_columns')) {
    function mo_testimonials_edit_columns($columns) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title', 'mo_theme'),
            'testimonial' => __('Testimonial', 'mo_theme'),
            'testimonial-customer-image' => __('Customer\'s Photo', 'mo_theme'),
            'testimonial-customer-name' => __('Customer\'s Name', 'mo_theme'),
            'testimonial-customer-details' => __('Customer\'s Details', 'mo_theme'),
            'testimonial-order' => __('Testimonial Order', 'mo_theme')
        );

        return $columns;
    }
}

/**
 * Customizing the list view columns
 *
 * This functions is attached to the 'manage_posts_custom_column' action hook.
 */
if (!function_exists('mo_testimonials_columns')) {
    function mo_testimonials_columns($column) {
        global $post;
        switch ($column) {
            case 'testimonial':
                the_excerpt();
                break;
            case 'testimonial-customer-image':
                mo_thumbnail(array('image_size' => 'mini', 'wrapper' => false, 'image_alt' => get_the_title(), 'size' => 'thumbnail'));
                break;
            case 'testimonial-customer-name':
                echo get_post_meta($post->ID, 'mo_customer_name', true);
                break;
            case 'testimonial-customer-details':
                echo get_post_meta($post->ID, 'mo_customer_details', true);
                break;
            case 'testimonial-order':
                echo $post->menu_order;
                break;
        }
    }
}

if (!function_exists('mo_fitness_classes_edit_columns')) {
    function mo_fitness_classes_edit_columns($columns) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Class Name', 'mo_theme'),
            'class-image' => __('Thumbnail', 'mo_theme'),
            'class-description' => __('Description', 'mo_theme'),
            'class-trainers' => __('Trainers', 'mo_theme'),
            'class-order' => __('Class Order', 'mo_theme')
        );

        return $columns;
    }
}

/**
 * Customizing the list view columns
 *
 * This functions is attached to the 'manage_posts_custom_column' action hook.
 */
if (!function_exists('mo_fitness_classes_columns')) {
    function mo_fitness_classes_columns($column) {
        global $post;
        switch ($column) {
            case 'class-image':
                mo_thumbnail(array('image_size' => 'mini', 'wrapper' => false, 'image_alt' => get_the_title(), 'size' => 'thumbnail'));
                break;
            case 'class-description':
                the_excerpt();
                break;
            case 'class-trainers':
                $trainer_names = array();
                $trainer_ids = get_post_meta($post->ID, 'mo_trainers_for_class', true);
                if (!empty($trainer_ids)) {
                    foreach ($trainer_ids as $trainer_id) {
                        $trainer_names[] = get_the_title($trainer_id);
                    }
                }
                echo implode(', ', $trainer_names);
                break;
            case 'class-order':
                echo $post->menu_order;
                break;
        }
    }
}

if (!function_exists('mo_features_edit_columns')) {
    function mo_features_edit_columns($columns) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title', 'mo_theme'),
            'feature-image' => __('Thumbnail', 'mo_theme'),
            'feature-description' => __('Description', 'mo_theme'),
            'feature-order' => __('Order', 'mo_theme')
        );

        return $columns;
    }
}

/**
 * Customizing the list view columns
 *
 * This functions is attached to the 'manage_posts_custom_column' action hook.
 */
if (!function_exists('mo_features_columns')) {
    function mo_features_columns($column) {
        global $post;
        switch ($column) {
            case 'feature-name':
                echo get_the_title();
                break;
            case 'feature-description':
                the_excerpt();
                break;
            case 'feature-image':
                mo_thumbnail(array('image_size' => 'mini', 'wrapper' => false, 'image_alt' => get_the_title(), 'size' => 'thumbnail'));
                break;
            case 'feature-order':
                echo $post->menu_order;
                break;
        }
    }
}

if (!function_exists('mo_pricing_edit_columns')) {
    function mo_pricing_edit_columns($columns) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Pricing Plan Name', 'mo_theme'),
            'pricing-plan-price-tag' => __('Price Tag', 'mo_theme'),
            'pricing-tagline' => __('Tagline', 'mo_theme'),
            'pricing-image' => __('Image', 'mo_theme'),
            'pricing-plan-url' => __('Pricing Plan URL', 'mo_theme'),
            'pricing-plan-order' => __('Pricing Plan Order', 'mo_theme')
        );

        return $columns;
    }
}

/**
 * Customizing the list view columns
 *
 * This functions is attached to the 'manage_posts_custom_column' action hook.
 */
if (!function_exists('mo_pricing_columns')) {
    function mo_pricing_columns($column) {
        global $post;
        switch ($column) {
            case 'pricing-plan-price-tag':
                echo get_post_meta($post->ID, 'mo_price_tag', true);
                break;
            case 'pricing-plan-url':
                echo get_post_meta($post->ID, 'mo_pricing_url', true);
                break;
            case 'pricing-tagline':
                echo get_post_meta($post->ID, 'mo_pricing_tagline', true);
                break;
            case 'pricing-image':
                $image_url = get_post_meta($post->ID, 'mo_pricing_img', true);
                if (!empty($image_url))
                    echo '<img alt="' . $post->post_title . '" src="' . $image_url . '" /><br>';
                break;
            case 'pricing-plan-order':
                echo $post->menu_order;
                break;

        }
    }
}
