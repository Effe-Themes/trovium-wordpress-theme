<?php
if ( ! function_exists( 'trovium_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress
 * features.
 *
 * @since trovium 1.0
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

// Enqueue core
require_once get_template_directory() . '/inc/core/init.php';

// Add Customizer
require get_template_directory() . '/inc/customizer.php';

// Upsell in the customizer
if ( class_exists( 'WP_Customize_Section' ) ) {
	class Trovium_Upsell_Section extends WP_Customize_Section {
		public $type = 'trovium-upsell';
		public $button_text = '';
		public $url = '';
		public $background = '';
		public $text_color = '';
		protected function render() {
			$background = ! empty( $this->background ) ? esc_attr( $this->background ) : '#07E3D4';
			$text_color = ! empty( $this->text_color ) ? esc_attr( $this->text_color ) : '#fff';
			?>
			<li id="accordion-section-<?php echo esc_attr( $this->id ); ?>" class="trovium_upsell_section accordion-section control-section control-section-<?php echo esc_attr( $this->id ); ?> cannot-expand">
				<h3 class="accordion-section-title" style="border: 0; color:#fff; background:<?php echo esc_attr( $background ); ?>;">
					<?php echo esc_html( $this->title ); ?>
					<a href="<?php echo esc_url( $this->url ); ?>" class="button button-secondary alignright" target="_blank" style="margin-top: -4px;"><?php echo esc_html( $this->button_text ); ?></a>
				</h3>
			</li>
			<?php
		}
	}
}

// Add Get Started
require get_template_directory() . '/inc/get-started/get-started.php';

// Add Getstart admin notice
function trovium_admin_notice() { 
    global $pagenow;
    $theme_args = wp_get_theme();
    $meta = get_option('trovium_admin_notice');
    $name = $theme_args->__get('Name');
    $current_screen = get_current_screen();

    if(!$meta){
        if(is_network_admin()){
            return;
        }

        if(!current_user_can('manage_options')){
            return;
        } 
        
        if($current_screen->base != 'appearance_page_trovium-guide-page') { 
            ?>
            <div class="notice notice-success trovium-pro-promotion is-dismissible" style="border-left: 4px solid #2271b1; padding: 15px 20px; position: relative;">
                <style>
                    .trovium-pro-promotion {
                        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                        border-radius: 8px;
                        margin: 15px 0;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                    }
                    .trovium-pro-promotion h1 {
                        color: #1e293b;
                        margin: 10px 0 15px;
                        font-size: 24px;
                        font-weight: 700;
                    }
                    .trovium-pro-promotion p {
                        font-size: 16px;
                        line-height: 1.6;
                        margin-bottom: 15px;
                        color: #475569;
                    }
                    .trovium-pro-promotion .stars {
                        font-size: 22px;
                        color: #f59e0b;
                        margin-bottom: 5px;
                    }
                    .trovium-pro-promotion .features-list {
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                        gap: 12px;
                        margin: 15px 0;
                    }
                    .trovium-pro-promotion .feature-item {
                        display: flex;
                        align-items: center;
                        font-size: 14px;
                    }
                    .trovium-pro-promotion .feature-icon {
                        color: #10b981;
                        margin-right: 8px;
                        font-weight: bold;
                    }
                    .trovium-pro-promotion .cta-buttons {
                        display: flex;
                        gap: 10px;
                        margin-top: 20px;
                        flex-wrap: wrap;
                    }
                    .trovium-pro-promotion .button-primary {
                        background: #10b981;
                        border-color: #10b981;
                        padding: 10px 20px;
                        font-weight: 600;
                        border-radius: 4px;
                        box-shadow: 0 2px 5px rgba(16, 185, 129, 0.3);
                    }
                    .trovium-pro-promotion .button-primary:hover {
                        background: #059669;
                        border-color: #059669;
                        transform: translateY(-1px);
                        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.4);
                    }
                    @media (max-width: 768px) {
                        .trovium-pro-promotion .features-list {
                            grid-template-columns: 1fr;
                        }
                        .trovium-pro-promotion .cta-buttons {
                            flex-direction: column;
                        }
                    }
                </style>
                
                <div class="stars">⭐⭐⭐⭐⭐</div>
                
                <h1><?php esc_html_e('Unlock the Full Power of Trovium!', 'trovium'); ?></h1>
                
                <p>You're using the <strong>free version</strong> of Trovium. Upgrade to <strong>Trovium PRO</strong> and unlock exclusive features that will transform your website!</p>
                
                <div class="features-list">
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Advanced customization options</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Premium blocks and templates</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Priority customer support</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Regular updates and new features</span>
                    </div>
                </div>
                
                <div class="cta-buttons">
                    <a class="button button-primary" href="<?php echo esc_url( TROVIUM_BUY_NOW ); ?>" target="_blank">
                        <?php esc_html_e('Upgrade to PRO Now', 'trovium'); ?>
                    </a>
                </div>
            </div>
            <?php
        }
    }
}

add_action( 'admin_notices', 'trovium_admin_notice' );

function trovium_notice_dismissed() {
	if ( isset( $_GET['trovium-dismissed'] ) ) {
		update_option( 'trovium_admin_notice', true );
	}
}
add_action( 'admin_init', 'trovium_notice_dismissed' );

if( ! function_exists( 'trovium_update_admin_notice' ) ) :
/**
* Updating admin notice on dismiss
*/
function trovium_update_admin_notice(){
	if ( isset( $_GET['trovium_admin_notice'] ) && $_GET['trovium_admin_notice'] === '1' ) {
		update_option( 'trovium_admin_notice', true );
	}
}
endif;
add_action( 'admin_init', 'trovium_update_admin_notice' );

// After switch theme function
add_action('after_switch_theme', 'trovium_getstart_setup_options');
function trovium_getstart_setup_options () {
	update_option('trovium_admin_notice', false );
}

// Theme credit link
define( 'TROVIUM_BUY_NOW',  'https://effethemes.com/themes/trovium-wordpress-theme/' );
define( 'TROVIUM_PRO_DEMO', 'https://preview.effethemes.com/trovium-wordpress-theme/' );
define( 'TROVIUM_REVIEW',   'https://wordpress.org/support/theme/trovium/reviews/#new-post' );
define( 'TROVIUM_SUPPORT',  'https://wordpress.org/support/theme/trovium' );
