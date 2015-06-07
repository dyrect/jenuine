<?php


/* Stats Shortcode -

Wraps an animated percentage stats list.

Usage:

[stats]

[stats_bar title="Web Design 87%" value="87"]

[stats_bar title="Logo Design 60%" value="60"]

[stats_bar title="Brand Marketing 70%" value="70"]

[/stats_bar][stats_bar title="SEO Services 67%" value="67"]

[stats_bar title="Print Collateral 40%" value="40"]

[/stats]


Parameters -

None


*/


function mo_stats($atts, $content) {
    extract(shortcode_atts(array(),
        $atts));
    return '<div class="stats-bars">' . do_shortcode($content) . '</div>';
}

add_shortcode('stats', 'mo_stats');

/* Stats Bar Shortcode -

Displays an animated percentage stats bar. The bar animates to indicate the percentage.

Usage:

[stats]

[stats_bar title="Web Design 87%" value="87"]

[stats_bar title="Logo Design 60%" value="60"]

[stats_bar title="Brand Marketing 70%" value="70"]

[/stats_bar][stats_bar title="SEO Services 67%" value="67"]

[stats_bar title="Print Collateral 40%" value="40"]

[/stats]


Parameters -

title - The title indicating the stats title.
value - The percentage value for the percentage stats to be displayed.

*/
function mo_stats_bar($atts, $content) {
    extract(shortcode_atts(array(
        'title' => 'Web Development 85%',
        'value' => '83'
    ), $atts));
    return '<div class="stats-bar"><div class="stats-title">' . $title . '</div><div class="stats-bar-content" data-perc="' . $value . '"></div></div>';
}

add_shortcode('stats_bar', 'mo_stats_bar');

function mo_animating_stats_bar($atts, $content) {
    extract(shortcode_atts(array(
        'title' => 'Web Development 85%',
        'value' => '83'
    ), $atts));
    return '<div class="stats-bar"><div class="stats-title">' . $title . '</div><div class="stats-bar-content" data-perc="' . $value . '"></div></div>';
}

add_shortcode('animating_stats_bar', 'mo_animating_stats_bar');


/* Animating numbers shortcode -

A wrapper element for the list of numbers, each of which indicate a statistic. The element animates from a start value to display the end number when the user scrolls to the stats section.

Usage:

[animate-numbers]

[animate-number icon="icon-lab4" title="Pixels Pushed" start_value="87"]26492[/animate-number]

[animate-number icon="icon-java" title="Coffees Consumed" start_value="60"]613[/animate-number]

[animate-number icon="icon-heart11" title="Wide-Grip Pushups" start_value="70"]1277[/animate-number]

[animate-number icon="icon-clock10" title="Hours Worked" start_value="67"]458[/animate-number]

[/animate-numbers]


Parameters -

None

*/

function mo_animate_numbers($atts, $content) {
    extract(shortcode_atts(array(),
        $atts));
    return '<div class="animate-numbers">' . do_shortcode($content) . '</div>';
}

add_shortcode('animate-numbers', 'mo_animate_numbers');

/* Animating numbers shortcode -

Displays a number to indicate a statistic. The element animates from a start value to display the end number when the user scrolls to the stats section.

Usage:

[animate-numbers]

[animate-number icon="icon-lab4" title="Pixels Pushed" start_value="87"]26492[/animate-number]

[animate-number icon="icon-java" title="Coffees Consumed" start_value="60"]613[/animate-number]

[animate-number icon="icon-heart11" title="Wide-Grip Pushups" start_value="70"]1277[/animate-number]

[animate-number icon="icon-clock10" title="Hours Worked" start_value="67"]458[/animate-number]

[/animate-numbers]


Parameters -

title - The title indicating the stats title.
start_value - The starting value for the animation which displays a counter that animates to the end value specified as the content of the [animate-number] shortcode.
icon - The font icon to be displayed for the statistic being displayed, chosen from the list of icons listed at http://portfoliotheme.org/support/faqs/how-to-use-1500-icons-bundled-with-the-agile-theme/
icon_image_url - The
*/

function mo_animate_number($atts, $content) {
    extract(shortcode_atts(array(
        'title' => 'Hours Burnt',
        'start_value' => '0',
        'icon' => false,
        'icon_image_url' => false
    ), $atts));

    $font_icon = '';
    $image_element = '';

    if (!empty ($icon_image_url)) {
        $image_element = '<img src="' . $icon_image_url . '"/>';
    }
    else if (!empty ($icon)) {
        $font_icon = '<i class="' . $icon . '"></i>';
    }

    return '<div class="stats"><div class="number" data-stop="' . $content . '">' . $start_value . '</div><div class="stats-title">' . $font_icon . $image_element . $title . '</div></div>';
}

add_shortcode('animate-number', 'mo_animate_number');



function mo_animate_single_number($atts, $content) {
    extract(shortcode_atts(array(
        'title' => 'Hours Burnt',
        'start_value' => '0',
        'end_value' => '0',
        'icon' => false,
        'icon_image_id' => false
    ), $atts));

    $font_icon = '';
    $image_element = '';

    if (!empty ($icon_image_id)) {
        $image_element = '<img src="' . wp_get_attachment_url($icon_image_id) . '"/>';
    }
    else if (!empty ($icon)) {
        $font_icon = '<i class="' . $icon . '"></i>';
    }

    return '<div class="stats"><div class="number" data-stop="' . $end_value . '">' . $start_value . '</div><div class="stats-title">' . $font_icon . $image_element . $title . '</div></div>';
}

add_shortcode('animate_number', 'mo_animate_single_number');

/* Piechart Shortcode -

Displays a piechart for a percentage statistic with a title in the middle of the piechart displayed.
While the piechart animates to indicate the percentage specified, a textual representation of the statistic is also displayed in the center of the piechart.

Usage:

[piechart percent=70 title="Repeat Customers"]

[piechart percent=92 title="Referral Work"]

Parameters -

title - The title indicating the stats title.
value - The percentage value for the percentage stats.


*/


function mo_piechart($atts, $content) {
    extract(shortcode_atts(array(
        'percent' => 85,
        'title' => ''
    ), $atts));

    $output = '<div class="piechart">';
    $output .= '<div class="percentage" data-percent="' . $percent . '"><span>' . $percent . '<sup>%</sup></span></div>';
    $output .= '<div class="label">' . $title . '</div>';
    $output .= '</div>';

    return $output;
}

add_shortcode('piechart', 'mo_piechart');

/* Marketing Offer Shortcode -

Displays a marketing offer with an image header on the top and text with title below the image. Examples of offers include free guest passes, personal trainings, classes etc.

Usage:

[marketing_offer title="3 Day Guest Pass"  image_header_url="http://portfoliotheme.org/fitpro/wp-content/uploads/2014/05/guest-pass.jpg"]Content Here[/marketing_offer]

Parameters -

title - The title displayed below the image header, above the content.
image_header_url - The URL of the image displayed at the top of the box displaying the marketing offer.


*/
function mo_marketing_offer_shortcode($atts, $content) {

    extract(shortcode_atts(array(
        'title' => '',
        'image_header_url' => ''
    ), $atts));

    $output = '<div class="marketing-offer">';

    $output .= '<img class="header-img" src="' . $image_header_url . '" alt="' . $title . '"/>';

    $output .= '<div class="text">';

    $output .= '<h3>' . $title . '</h3>';

    $output .= do_shortcode($content);

    $output .= '</div><!-- .text -->';

    $output .= '</div><!-- .marketing-offer -->';

    return $output;
}

add_shortcode('marketing_offer', 'mo_marketing_offer_shortcode');

/* Service Item Shortcode -

Display a service item with an image or a font icon specified by the user on the top, followed by title and description below the image/icon.

Usage:

[service_item image_url="http://portfoliotheme.org/fitpro/wp-content/uploads/2014/05/muscles.png" title="Personal Training" description="Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut."]

Parameters -

title - The title displayed below the image or font icon, above the description.
image_url - The URL of the image displayed at the top of the box displaying the marketing offer.
icon_class - The class name for the icon font as documented in the http://portfoliotheme.org/support/faqs/how-to-use-1500-icons-bundled-with-the-agile-theme/.
If an image_url has been specified, this font icon parameter is ignored.
description - The textual description to be displayed below the title.


*/
function mo_service_item_shortcode($atts, $content) {

    extract(shortcode_atts(array(
        'image_url' => '',
        'image_id' => '',
        'icon' => '',
        'title' => '',
        'description' => ''
    ), $atts));

    $output = '<div class="service-item">';

    if (!empty($image_id)) {

        $output .= '<img src="' . wp_get_attachment_url($image_id) . '" alt="' . $title . '"/>';
    }
    elseif (!empty($image_url)) {

        $output .= '<img src="' . $image_url . '" alt="' . $title . '"/>';
    }
    elseif (!empty($icon)) {
        $output .= '<i class="' . $icon . '"></i>';
    }

    $output .= '<h3>' . $title . '</h3>';

    $output .= '<div class="description">';

    $output .= $description;

    $output .= '</div>';

    $output .= '</div>';

    return $output;
}

add_shortcode('service_item', 'mo_service_item_shortcode');