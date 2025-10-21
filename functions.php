<?php
if ( ! function_exists( 'trovium_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function trovium_setup() {
    // Add support for HTML5 tags
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

    // Add support for title tag
    add_theme_support( 'title-tag' );

    // Add support for post thumbnails
    add_theme_support( 'post-thumbnails' );

    // Add support for post formats
    add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

    // Add support for block styles
    add_theme_support( 'wp-block-styles' );

    // Make theme available for translation properly
    load_theme_textdomain( 'trovium', get_template_directory() . '/languages' );
}
endif;
add_action( 'after_setup_theme', 'trovium_setup' );


// Enqueue styles and scripts
function trovium_enqueue_styles_and_scripts() {
    // Enqueue normalize.css
    wp_enqueue_style( 'normalize-css', get_template_directory_uri() . '/assets/css/normalize.css', array(), '1.0' );

    // Enqueue block.css
    wp_enqueue_style( 'trovium-blocks-style', get_template_directory_uri() . '/assets/css/block.css', array(), '1.0' );

    // Enqueue main stylesheet
    wp_enqueue_style( 'style-css', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'trovium_enqueue_styles_and_scripts' );


// Enqueue editor styles
add_theme_support( 'editor-styles' );
add_editor_style( 'style.css' );


// Core includes
require_once get_template_directory() . '/inc/core/init.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/get-started/get-started.php';


// Admin Notice
if ( ! function_exists( 'trovium_admin_notice' ) ) {
    function trovium_admin_notice() {
        if ( get_option('trovium_admin_notice') ) {
            return;
        }

        if ( ! current_user_can('manage_options') ) {
            return;
        }

        $theme_args = wp_get_theme();

        $dismiss_url = add_query_arg(
            'trovium-dismissed',
            '1',
            admin_url()
        );
        ?>
            <div class="notice notice-success is-dismissible" style="padding:15px;">
                <p>
                    <?php
                    printf(
                        esc_html__('You are using the free version of %s. Upgrade to PRO for more features.', 'trovium'),
                        esc_html($theme_args->Name)
                    );
                    ?>
                </p>
                <div style="margin-top:10px;">
                    <a href="<?php echo esc_url(TROVIUM_BUY_NOW); ?>" class="button button-primary" target="_blank">
                        <?php esc_html_e('Upgrade to PRO', 'trovium'); ?>
                    </a>
                    <a href="<?php echo esc_url(add_query_arg('trovium-dismissed', '1', admin_url())); ?>" class="button" style="margin-left:5px;">
                        <?php esc_html_e('Dismiss', 'trovium'); ?>
                    </a>
                </div>
            </div>
        <?php
    }
    add_action('admin_notices', 'trovium_admin_notice');
}

if ( ! function_exists( 'trovium_notice_dismissed' ) ) {
    function trovium_notice_dismissed() {
        if ( isset( $_GET['trovium-dismissed'] ) && current_user_can('manage_options') ) {
            update_option( 'trovium_admin_notice', true );
        }
    }
    add_action('admin_init', 'trovium_notice_dismissed');
}



if ( ! function_exists( 'trovium_notice_dismissed' ) ) {
    function trovium_notice_dismissed() {
        if ( isset( $_GET['trovium-dismissed'] ) ) {
            update_option( 'trovium_admin_notice', true );
        }
    }
    add_action('admin_init', 'trovium_notice_dismissed');
}

// Reset admin notice on theme switch
add_action('after_switch_theme', function() {
    update_option('trovium_admin_notice', false );
});


// Theme credit links
define( 'TROVIUM_BUY_NOW',  'https://effethemes.com/themes/trovium-wordpress-theme/' );
define( 'TROVIUM_PRO_DEMO', 'https://preview.effethemes.com/trovium-wordpress-theme/' );
define( 'TROVIUM_REVIEW',   'https://wordpress.org/support/theme/trovium/reviews/#new-post' );
define( 'TROVIUM_SUPPORT',  'https://wordpress.org/support/theme/trovium' );
