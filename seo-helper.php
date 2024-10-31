<?php
/**
 * @package All-Things-SEO.com
 * @author Michael Henke
 * @version 0.2
 */
/*
Plugin Name: SEO Helper
Plugin URI: http://www.all-things-seo.com/seo/seo-helper/
Description: Have your SEO in mind while writing your blog post with this small SEO Helper plugin. Check your draft for SEO while writing. This plugin is proudly provided by <a href="http://www.all-things-seo.com" target="_blank">all-things-seo.com</a>.
Version: 0.2
Author: Michael Henke
Author URI: http://www.all-things-seo.com/
 */

add_action( 'add_meta_boxes', 'seo_helper_box' ) || add_action( 'admin_init', 'seo_helper_box', 1 );

function seo_helper_box() {
    $title = 'SEO Helper<small><em> by <a href="http://www.all-things-seo.com" target="_blank" style="text-decoration:none">all-things-seo.com</a></em>&nbsp;'.
             '<a href="http://www.all-things-seo.com/feed/" target="_blank" rel="_nofollow"><span style="background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAYAAABWdVznAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAHwSURBVHjaHJLPS1RRHMU/99437z1nfEmTNNkwRf4oBUPINtWisMA2BS3DTbjKaBlBq/4Co1oXtGkbgQoRCBFBtZOCNMIcyYacVJ7NjL15c9+73dfuu/mec/icI4wxrN8+aXTUQEoHkcQInYAC6TggBJAivQLlx8tCVGdGzN+9Jt6pyxTPXCXdXsPUVzA738jtVckV8ijfRaqEzaVdHB3WET0H8CqDuIcHEMfGcHsrmPAn8dJzVPUVUv9BuD56ZxlH5RxUlyJamqP+9TVStHH6BgnOTtN94S56dQzz8RGivYtQOWSWMU0j8qMT9E09oHhxBjcJaSzcYevNQ9TAJOLIeZLwF5g0ewC30AXJLlH4A29kkuL1ZwRD54jezdL4PIcavoZ2ejGdjgUjJIXAxavOE7+cpv70Cs3Vt3RP3MffXyFcnEXnS1Aax2hLLrE22kSo0gmC/tPk4xo78/dI0gR/fJpO+Bvd3MbsG8AogWy3NVFQpvvGAt7UAn55DNnYpLX2AW/okpUMbBcSeXAYHB+H1ObKKbIC/5eUCDyl6KwswvonZBTTfP+CZGODtG1LXb85aHqOW6vSKLmMWO0L7VaM1i66pe1t6MRWt7WHH9glZMobt/qN3qplwKyt3YSFZ5KEzNRkt05xioc4+uS7+CfAAJuxz+d4SoyCAAAAAElFTkSuQmCC) no-repeat center;display: inline-block;width: 12px;height: 12px;padding:0">&nbsp;</span></a>&nbsp;'.
             '<a href="http://twitter.com/AllThingsSEOcom" target="_blank" rel="_nofollow"><span style="background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAIAAADZF8uwAAAAAXNSR0IArs4c6QAAAURJREFUeJxkkDtLA0EUhc9s1iRuInamCJYBC0ETawt/iJbW+ju0sBARezuxs5GAjSC+ah+FigRThLia7IOdmXvHmd0UiofLZZj5OPfMFWdvYbf3NVUqASBAMzJGnFeiEQt/Y2FObN8PatNBJQgaZcxXcD3CUCMijDVGtkuO+u8+/DKqgTRYb6DqwQAnA0Q58a2hjKFk7Ftzj92bJazqJTQrSHzEhJtQGdJGKz9haIIxKLQ666rQ7gsfv2eW86Lc9lPjv5yNks7JBjQakicPRz06fE2LKa4z2YNnA4YKI0UF1Kpyp0adOq/MoI4cZcLyRdi5ytqX8a2N+VcHD8PF0+fW/rnHWrrBSu48jT9S+p3pMUzdOMNiqTso/jYJQRpEboS9tEtKYzXs+5tNsde9Y5nlBIHt0mx3BISw9NZa+wcAAP//AwCzbPKFHoCbQQAAAABJRU5ErkJggg%3D%3D) no-repeat center;display: inline-block;width: 12px;height: 12px;padding:0">&nbsp;</span></a> '.
             '</small>';

    add_meta_box(
        'seo_helper_sectionid',
        __( $title, 'seo_helper_textdomain' ),
        'seo_helper_inner_custom_box',
        'post'
    );
    add_meta_box(
        'seo_helper_sectionid',
        __( $title, 'seo_helper_textdomain' ),
        'seo_helper_inner_custom_box',
        'page'
    );
}

function seo_helper_inner_custom_box() {
    if ( get_post_status( get_the_ID() ) == "auto-draft" ) {
        echo __("<em>Your post needs to be saved first for SEO Helper to work. Currently your post does not contain any information.</em>");
        return true;
    }

    include_once 'seo_helper_evaluate_title.php';
    include_once 'seo_helper_evaluate_body.php';
    echo "<br /><em>Social Media Optimization</em><br />";
    include_once 'seo_helper_evaluate_smo.php';
    include_once 'seo_helper_footer.php';
}

if (is_admin()) {
    $myStyleUrl  = WP_PLUGIN_URL . '/seo-helper/seo_helper.css';
    $myStyleFile = WP_PLUGIN_DIR . '/seo-helper/seo_helper.css';
    if ( file_exists($myStyleFile) ) {
        wp_register_style('SEO_HELPER_STYLE', $myStyleUrl);
        wp_enqueue_style( 'SEO_HELPER_STYLE');
    } else {
        
    }
}

if (!function_exists('AllThingsSEO_widget_setup')) {

    if (is_admin()) {
        add_action('wp_dashboard_setup', 'AllThingsSEO_widget_setup' );
    }

    function AllThingsSEO_widget_setup() {
        wp_enqueue_script('newscript', plugins_url('/SEOrss_ajax.js', __FILE__), array('jquery'), '1.0' );
        wp_add_dashboard_widget("AllThingsSEO_feed", apply_filters( 'AllThingsSEO_feed_title', __( 'All-Things-SEO.com Tips & Tricks' ) ), "AllThingsSEO_widget" );
    }

    function AllThingsSEO_widget() {
        include_once 'widget.php';
    }
}