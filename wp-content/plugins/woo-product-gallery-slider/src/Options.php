<?php
namespace Product_Gallery_Sldier;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Options {
	public $jvmw_plugin_url;
	public $jvmw_title;
	public $jvmw_activate;

	public function __construct() {

		$this->jvmw_data();
		$this->pluginOptions();
		add_action( 'csf_wpgs_form_save_after', array( $this, 'save_after' ) );
	}
	public function save_after(): void {
		\WPGS_Variation_images::delete_transients();
	}
	/**
	 * Get data of wishlist plugin
	 *
	 * @return void
	 */
	public function jvmw_data() {
		include_once ABSPATH . 'wp-admin/includes/plugin.php';

		if ( is_plugin_active( 'jvm-woocommerce-wishlist/jvm-woocommerce-wishlist.php' ) ) {

			$this->jvmw_title      = __( 'Check Options', 'woo-product-gallery-slider' );
			$this->jvmw_activate   = true;
			$this->jvmw_plugin_url = apply_filters( 'cosm_admin_page', admin_url( 'admin.php?page=cixwishlist_settings' ) );

		} elseif ( file_exists( WP_PLUGIN_DIR . '/jvm-woocommerce-wishlist/jvm-woocommerce-wishlist.php' ) ) {

			$this->jvmw_title      = __( 'Activate Now', 'woo-product-gallery-slider' );
			$this->jvmw_activate   = false;
			$this->jvmw_plugin_url = wp_nonce_url( 'plugins.php?action=activate&plugin=jvm-woocommerce-wishlist/jvm-woocommerce-wishlist.php&plugin_status=all&paged=1', 'activate-plugin_jvm-woocommerce-wishlist/jvm-woocommerce-wishlist.php' );

		} else {

			$this->jvmw_title      = __( 'Install Now', 'woo-product-gallery-slider' );
			$this->jvmw_activate   = false;
			$this->jvmw_plugin_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=jvm-woocommerce-wishlist' ), 'install-plugin_jvm-woocommerce-wishlist' );

		}
	}
	public function pluginOptions() {

		// Set a unique slug-like ID
		$prefix = 'wpgs_form';

		\CSF::createOptions(
			$prefix,
			array(
				'menu_title'      => 'Product Gallery',
				'menu_slug'       => 'cix-gallery-settings',
				'menu_type'       => 'submenu',
				'menu_parent'     => 'codeixer',
				'framework_title' => 'Product Gallery Slider for WooCommerce <small>by Codeixer</small><br><a href="https://www.codeixer.com/docs-category/product-gallery-slider/" target="_" class="button">Docs</a>',
				'show_footer'     => true,
				'show_bar_menu'   => false,
				'save_defaults'   => true,
				'footer_credit'   => '',
				'footer_text'     => '',

			)
		);

		//
		// Create a section
		\CSF::createSection(
			$prefix,
			array(
				'title'  => 'General Options',
				'icon'   => 'fas fa-sliders-h',
				'fields' => array(
					
					array(
						'type'    => 'submessage',
						'style'   => 'info',
						'content' => '<p style="font-size:15px">🎉  We\'re excited to share our new free plugin - <strong>WooCommerce Wishlist</strong>. It\'s a fantastic tool that lets your customers create wishlists and enhances their shopping experience. Give it a try! <a href="' . esc_url( $this->jvmw_plugin_url ) . '">' . esc_html( $this->jvmw_title ) . '</a></p>',
					),

					array(
						'id'      => 'slider_animation',
						'type'    => 'radio',
						'title'   => 'Slider Animation',
						'inline'  => true,

						'desc'    => 'Effect Between Product Images',
						'options' => array(
							'false' => __( 'Slide', 'woo-product-gallery-slider' ),
							'true'  => __( 'Fade', 'woo-product-gallery-slider' ),

						),
						'default' => 'true',

					),
					array(
						'id'      => 'gallery_animation_speed',
						'type'    => 'slider',
						'title'   => 'Animation Speed',
						'desc'    => 'Slide/Fade animation speed',
						'min'     => 100,
						'max'     => 900,
						'step'    => 100,
						'default' => 400,
						'unit'    => 'ms',

					),
					array(
						'id'       => 'slider_lazy_laod',
						'type'     => 'radio',
						'title'    => __( 'Slider Lazy Load', 'woo-product-gallery-slider' ),
						'class'    => 'cix-only-pro',
						'subtitle' => 'Available in <a target="_blank" href="https://www.codeixer.com/product-gallery-slider-for-woocommerce?utm_source=freemium&utm_medium=settings_page&utm_campaign=upgrade_pro">Pro Version!</a>',
						'options'  => array(
							'disable'     => __( 'Disable', 'woo-product-gallery-slider' ),
							'ondemand'    => __( 'On Demand', 'woo-product-gallery-slider' ),
							'progressive' => __( 'Progressive', 'woo-product-gallery-slider' ),
						),
						'default'  => 'disable',

						'desc'     => __( 'Useful for Page Loading Speed', 'woo-product-gallery-slider' ),
					),
					array(
						'id'    => 'slider_infinity',
						'type'  => 'switcher',
						'title' => __( 'Slide Infinitely', 'woo-product-gallery-slider' ),
						'desc'  => __( 'Sliding Infinite Loop', 'woo-product-gallery-slider' ),
					),
					array(
						'id'      => 'slider_adaptiveHeight',
						'type'    => 'switcher',
						'title'   => __( 'Slide Adaptive Height', 'woo-product-gallery-slider' ),
						'default' => true,
						'desc'    => __( 'Resize the Gallery Section Height to Match the Image Height', 'woo-product-gallery-slider' ),
					),
					array(
						'id'       => 'slider_alt_text',
						'type'     => 'switcher',
						'default'  => false,
						'class'    => 'cix-only-pro',
						'subtitle' => 'Available in <a target="_blank" href="https://www.codeixer.com/product-gallery-slider-for-woocommerce?utm_source=freemium&utm_medium=settings_page&utm_campaign=upgrade_pro">Pro Version!</a>',
						'title'    => __( 'Slide Image Caption', 'woo-product-gallery-slider' ),
						'desc'     => __( 'Display Image Caption / Title Text Under the Image.', 'woo-product-gallery-slider' ),

					),

					array(
						'id'    => 'slider_dragging',
						'type'  => 'switcher',
						'title' => __( 'Mouse Dragging', 'woo-product-gallery-slider' ),
						'desc'  => __( 'Move Slide on Mouse Dragging ', 'woo-product-gallery-slider' ),
					),
					array(
						'id'    => 'slider_autoplay',
						'type'  => 'switcher',
						'title' => __( 'Slider Autoplay', 'woo-product-gallery-slider' ),

					),
					array(
						'id'         => 'slider_autoplay_pause',
						'type'       => 'switcher',
						'title'      => __( 'Pause Autoplay', 'woo-product-gallery-slider' ),
						'desc'       => __( 'Pause Autoplay when the Mouse Hovers Over the Product Image or Dots.', 'woo-product-gallery-slider' ),
						'dependency' => array( 'slider_autoplay', '==', 'true' ),
						'default'    => true,
					),
					array(

						'id'         => 'autoplay_timeout',
						'type'       => 'slider',
						'title'      => 'Autoplay Speed',
						'min'        => 1000,
						'max'        => 10000,
						'step'       => 1000,
						'unit'       => 'ms',
						'default'    => 4000,
						'desc'       => __( '1000 ms = 1 second', 'woo-product-gallery-slider' ),

						'dependency' => array( 'slider_autoplay', '==', 'true' ),
					),
					array(
						'id'    => 'dots',
						'type'  => 'switcher',
						'title' => __( 'Dots', 'woo-product-gallery-slider' ),
						'desc'  => __( 'Enable Dots/Bullets for Product Image', 'woo-product-gallery-slider' ),
					),
					array(
						'id'      => 'slider_nav',
						'type'    => 'switcher',
						'title'   => __( 'Navigation Arrows', 'woo-product-gallery-slider' ),
						'desc'    => __( 'Enable Navigation Arrows for Product Image Slider', 'woo-product-gallery-slider' ),
						'default' => true,
					),

					array(
						'id'         => 'slider_nav_animation',
						'type'       => 'switcher',
						'class'      => 'cix-only-pro',
						'title'      => __( 'Arrows Animation', 'woo-product-gallery-slider' ),
						'subtitle'   => 'Available in <a target="_blank" href="https://www.codeixer.com/product-gallery-slider-for-woocommerce?utm_source=freemium&utm_medium=settings_page&utm_campaign=upgrade_pro">Pro Version!</a>',
						'desc'       => __( 'Enable Animation Slide effect for Appearing Arrows', 'woo-product-gallery-slider' ),
						'default'    => false,
						'dependency' => array( 'slider_nav', '==', 'true' ),

					),
					array(
						'id'          => 'slider_nav_color',
						'type'        => 'color',
						'title'       => __( 'Arrows Color', 'woo-product-gallery-slider' ),
						'desc'        => __( 'Set Arrows Color', 'woo-product-gallery-slider' ),
						'default'     => '#000',
						'output_mode' => 'color',
						'output'      => '.wpgs-for .slick-arrow::before,.wpgs-nav .slick-prev::before, .wpgs-nav .slick-next::before',
						'dependency'  => array( 'slider_nav', '==', 'true' ),
					),

				),
			)
		);

		//
		// Create a section
		\CSF::createSection(
			$prefix,
			array(
				'title'  => 'Lightbox Options',
				'icon'   => 'fas fa-expand',
				'fields' => array(

					array(
						'id'      => 'lightbox_picker',
						'type'    => 'switcher',
						'default' => true,
						'desc'    => esc_html__( 'Lightbox Feature on Product Image ', 'woo-product-gallery-slider' ),
						'title'   => __( 'Image Lightbox', 'woo-product-gallery-slider' ),
					),

					array(
						'id'         => 'lightbox_thumb_axis',
						'type'       => 'radio',
						'title'      => __( 'Lightbox Thumbnails Position', 'woo-product-gallery-slider' ),
						'class'      => 'cix-only-pro',
						'subtitle'   => 'Available in <a target="_blank" href="https://www.codeixer.com/product-gallery-slider-for-woocommerce?utm_source=freemium&utm_medium=settings_page&utm_campaign=upgrade_pro">Pro Version!</a>',
						'options'    => array(
							'y' => __( 'Vertical', 'woo-product-gallery-slider' ),
							'x' => __( 'Horizontal', 'woo-product-gallery-slider' ),
						),

						'default'    => 'y',
						'dependency' => array( 'lightbox_picker', '==', 'true' ),
						'desc'       => __( 'Select Lightbox Thumbnails Position.', 'woo-product-gallery-slider' ),

					),
					array(
						'id'         => 'lightbox_thumb_autoStart',
						'dependency' => array( 'lightbox_picker', '==', 'true' ),
						'type'       => 'switcher',
						'class'      => 'cix-only-pro',
						'subtitle'   => 'Available in <a target="_blank" href="https://www.codeixer.com/product-gallery-slider-for-woocommerce?utm_source=freemium&utm_medium=settings_page&utm_campaign=upgrade_pro">Pro Version!</a>',
						'title'      => 'Lightbox Thumbnail Autostart',

					),
					array(
						'id'          => 'lightbox_oc_effect',
						'type'        => 'select',
						'class'       => 'cix-only-pro',
						'subtitle'    => 'Available in <a target="_blank" href="https://www.codeixer.com/product-gallery-slider-for-woocommerce?utm_source=freemium&utm_medium=settings_page&utm_campaign=upgrade_pro">Pro Version!</a>',
						'title'       => __( 'Lightbox Animation', 'woo-product-gallery-slider' ),
						'desc'        => __( 'Select Lightbox Open/close Animation Effect', 'woo-product-gallery-slider' ),
						'placeholder' => 'Select an option',
						'dependency'  => array( 'lightbox_picker', '==', 'true' ),
						'options'     => array(
							'fade' => __( 'Fade', 'woo-product-gallery-slider' ),

						),
						'default'     => 'fade',
					),
					array(
						'id'          => 'lightbox_slide_effect',
						'type'        => 'select',
						'class'       => 'cix-only-pro',
						'subtitle'    => 'Available in <a target="_blank" href="https://www.codeixer.com/product-gallery-slider-for-woocommerce?utm_source=freemium&utm_medium=settings_page&utm_campaign=upgrade_pro">Pro Version!</a>',
						'title'       => __( 'Slide Animation', 'woo-product-gallery-slider' ),
						'desc'        => __( 'Select Lightbox Slide Animation Effect', 'woo-product-gallery-slider' ),
						'placeholder' => 'Select an option',
						'dependency'  => array( 'lightbox_picker', '==', 'true' ),
						'options'     => array(
							'fade' => __( 'Fade', 'woo-product-gallery-slider' ),

						),
						'default'     => 'fade',
					),
					array(
						'id'          => 'lightbox_bg',
						'type'        => 'color',
						'title'       => __( 'Lightbox Background', 'woo-product-gallery-slider' ),
						'desc'        => __( 'Set Lightbox Background Color', 'woo-product-gallery-slider' ),
						'default'     => 'rgba(10,0,0,0.75)',
						'output_mode' => 'background-color',
						'output'      => '.fancybox-bg',
						'dependency'  => array( 'lightbox_picker', '==', 'true' ),
					),
					array(
						'id'          => 'lightbox_txt_color',
						'type'        => 'color',
						'title'       => __( 'Lightbox Text Color', 'woo-product-gallery-slider' ),
						'desc'        => __( 'Set Lightbox Text Color', 'woo-product-gallery-slider' ),
						'default'     => '#fff',
						'output_mode' => 'color',
						'output'      => '.fancybox-caption,.fancybox-infobar',
						'dependency'  => array( 'lightbox_picker', '==', 'true' ),
					),
					array(
						'id'         => 'lightbox_img_count',
						'type'       => 'switcher',
						'default'    => true,
						'title'      => __( 'Display image count', 'woo-product-gallery-slider' ),
						'desc'       => __( 'Display image count on top corner.', 'woo-product-gallery-slider' ),
						'dependency' => array( 'lightbox_picker', '==', 'true' ),
					),

					array(
						'id'         => 'lightbox_icon_color',
						'type'       => 'color',
						'title'      => __( 'Icon Color', 'woo-product-gallery-slider' ),
						'desc'       => __( 'Set lightbox icon color', 'woo-product-gallery-slider' ),
						'default'    => '#fff',
						'dependency' => array( 'lightbox_icon|lightbox_picker', '!=|==', 'none|true' ),
					),
					array(
						'id'         => 'lightbox_icon_bg_color',
						'type'       => 'color',
						'title'      => __( 'Icon Background', 'woo-product-gallery-slider' ),
						'desc'       => __( 'Set icon background color', 'woo-product-gallery-slider' ),
						'default'    => '#000',
						'dependency' => array( 'lightbox_icon|lightbox_picker', '!=|==', 'none|true' ),
					),

				),
			)
		);
		// Create a section
		\CSF::createSection(
			$prefix,
			array(
				'title'  => 'Zoom Options',
				'icon'   => 'fas fa-search-plus',
				'fields' => array(

					// A textarea field
					array(
						'id'      => 'image_zoom',
						'type'    => 'switcher',
						'default' => true,
						'title'   => __( 'Zoom', 'woo-product-gallery-slider' ),
						'desc'    => __( 'Enable Zoom Feature for Product Image.', 'woo-product-gallery-slider' ),

					),
					array(
						'id'         => 'wpgs_zis',
						'type'       => 'image_sizes',
						'class'      => 'cix-only-pro',
						'title'      => __( 'Zoom Image Size', 'wpgs-td' ),
						'default'    => 'large',
						'subtitle'   => 'Available in <a target="_blank" href="https://www.codeixer.com/product-gallery-slider-for-woocommerce?utm_source=freemium&utm_medium=settings_page&utm_campaign=upgrade_pro">Pro Version!</a>',
						'dependency' => array( 'image_zoom', '==', 'true' ),

					),
					array(
						'id'         => 'image_zoom_mode',
						'type'       => 'select',
						'title'      => __( 'Zoom Mode', 'wpgs-td' ),
						'class'      => 'cix-only-pro',
						'subtitle'   => 'Available in <a target="_blank" href="https://www.codeixer.com/product-gallery-slider-for-woocommerce?utm_source=freemium&utm_medium=settings_page&utm_campaign=upgrade_pro">Pro Version!</a>',
						'options'    => array(
							'inner' => __( 'Inner', 'wpgs-td' ),
						),
						'default'    => array( 'inner' ),
						'dependency' => array( 'image_zoom', '==', 'true' ),
					),
					array(
						'id'         => 'wpgs_ziac',
						'type'       => 'select',
						'class'      => 'cix-only-pro',
						'subtitle'   => 'Available in <a target="_blank" href="https://www.codeixer.com/product-gallery-slider-for-woocommerce?utm_source=freemium&utm_medium=settings_page&utm_campaign=upgrade_pro">Pro Version!</a>',
						'title'      => __( 'Zoom Action', 'wpgs-td' ),
						'dependency' => array( 'image_zoom', '==', 'true' ),
						'options'    => array(
							'mouseover' => __( 'Mouseover', 'wpgs-td' ),
						),
						'default'    => array( 'mouseover' ),

					),

				),
			)
		);
		// Create a top-tab
		\CSF::createSection(
			$prefix,
			array(
				'id'    => 'thumbnail_tab', // Set a unique slug-like ID
				'title' => 'Thumbnails Options',
				'icon'  => 'fas fa-image',
			)
		);
		// Create a section
		\CSF::createSection(
			$prefix,
			array(
				'parent' => 'thumbnail_tab', // The slug id of the parent section
				'title'  => 'Desktop',
				'fields' => array(

					array(
						'id'          => 'thumb_position',
						'type'        => 'select',
						'class'       => 'cix-only-pro',
						'subtitle'    => 'Available in <a target="_blank" href="https://www.codeixer.com/product-gallery-slider-for-woocommerce?utm_source=freemium&utm_medium=settings_page&utm_campaign=upgrade_pro">Pro Version!</a>',
						'title'       => __( 'Thumbnails Position', 'woo-product-gallery-slider' ),
						'subtitle'    => 'Available in <a target="_blank" href="https://www.codeixer.com/product-gallery-slider-for-woocommerce?utm_source=freemium&utm_medium=settings_page&utm_campaign=upgrade_pro">Pro Version!</a>',
						'placeholder' => 'Select an option',
						'options'     => array(
							'bottom' => __( 'Bottom', 'woo-product-gallery-slider' ),
							''       => __( 'Left', 'woo-product-gallery-slider' ),
							''       => __( 'Right', 'woo-product-gallery-slider' ),
						),
						'default'     => 'bottom',
						'desc'        => __( 'Select Thumbnails Position.', 'woo-product-gallery-slider' ),

					),
					array(
						'id'       => 'thumbnails_lightbox',
						'type'     => 'switcher',
						'subtitle' => 'Available in <a target="_blank" href="https://www.codeixer.com/product-gallery-slider-for-woocommerce?utm_source=freemium&utm_medium=settings_page&utm_campaign=upgrade_pro">Pro Version!</a>',
						'title'    => __( 'LightBox For Thumbnails', 'woo-product-gallery-slider' ),
						'class'    => 'cix-only-pro',
						'desc'     => __( 'Open Lightbox When click Thumbnails', 'woo-product-gallery-slider' ),

					),
					array(
						'id'      => 'thumb_to_show',
						'type'    => 'number',
						'title'   => __( 'Thumbnails To Show', 'woo-product-gallery-slider' ),
						'desc'    => __( 'Set the Number of Thumbnails to Display', 'woo-product-gallery-slider' ),
						'default' => 4,

					),
					array(
						'id'      => 'thumb_scroll_by',
						'type'    => 'number',
						'title'   => __( 'Thumbnails Scroll By', 'woo-product-gallery-slider' ),
						'desc'    => __( 'Set the Number of Thumbnails to Scroll when an Arrow is Clicked.', 'woo-product-gallery-slider' ),
						'default' => 1,

					),

					array(
						'id'      => 'thumb_nav',
						'type'    => 'switcher',
						'default' => true,
						'title'   => __( 'Thumbnails Arrows', 'woo-product-gallery-slider' ),

						'desc'    => __( 'Show Navigation Arrows for thumbnails.', 'woo-product-gallery-slider' ),

					),
					array(
						'id'      => 'thumbnails_layout',
						'type'    => 'image_select',
						'title'   => 'Thumbnails Layout',
						'class'   => 'image_picker_image',
						'options' => array(

							'border' => WPGS_ROOT_URL . '/assets/img/border.png',

						),
						'default' => 'border',

					),

					array(
						'id'      => 'thumb_border_non_active_color',
						'type'    => 'color',
						'title'   => __( 'Non-Active Thumbnail Border', 'woo-product-gallery-slider' ),
						'desc'    => __( 'Set Non-Active Thumbnail Border', 'woo-product-gallery-slider' ),
						'default' => 'transparent',
						'output'  => array( 'border-color' => '.wpgs-nav .slick-slide' ),

					),
					array(
						'id'      => 'thumb_border_active_color',
						'type'    => 'color',
						'title'   => __( 'Active Thumbnail Border', 'woo-product-gallery-slider' ),
						'desc'    => __( 'Set Active Thumbnails Border', 'woo-product-gallery-slider' ),
						'default' => '#000',
						'output'  => array( 'border-color' => '.wpgs-nav .slick-current' ),

					),

				),
			)
		);
		\CSF::createSection(
			$prefix,
			array(
				'parent' => 'thumbnail_tab', // The slug id of the parent section
				'title'  => 'Tablet',
				'fields' => array(
					array(
						'type'    => 'heading',
						'content' => 'Tablet : Screen width from 768px to 1024px',
					),

					array(
						'id'      => 'thumbnails_tabs_thumb_to_show',
						'type'    => 'number',
						'title'   => __( 'Thumbnails To Show', 'woo-product-gallery-slider' ),
						'desc'    => __( 'Set the Number of Thumbnails to Display', 'woo-product-gallery-slider' ),
						'default' => 4,

					),
					array(
						'id'      => 'thumbnails_tabs_thumb_scroll_by',
						'type'    => 'number',
						'title'   => __( 'Thumbnails Scroll By', 'woo-product-gallery-slider' ),
						'desc'    => __( 'Set the Number of Thumbnails to Scroll when an Arrow is Clicked.', 'woo-product-gallery-slider' ),
						'default' => 1,

					),

				),
			)
		);
		\CSF::createSection(
			$prefix,
			array(
				'parent' => 'thumbnail_tab', // The slug id of the parent section
				'title'  => 'Smartphone',
				'fields' => array(
					array(
						'type'    => 'heading',
						'content' => 'SmartPhones : Screen width less than  768px',
					),

					array(
						'id'      => 'thumbnails_mobile_thumb_to_show',
						'type'    => 'number',
						'title'   => __( 'Thumbnails To Show', 'woo-product-gallery-slider' ),
						'desc'    => __( 'Set the Number of Thumbnails to Display', 'woo-product-gallery-slider' ),
						'default' => 4,

					),
					array(
						'id'      => 'thumbnails_mobile_thumb_scroll_by',
						'type'    => 'number',
						'title'   => __( 'Thumbnails Scroll By', 'woo-product-gallery-slider' ),
						'desc'    => __( 'Set the Number of Thumbnails to Scroll when an Arrow is Clicked.', 'woo-product-gallery-slider' ),
						'default' => 1,

					),

				),
			)
		);
		\CSF::createSection(
			$prefix,
			array(
				'title'  => 'Video Options',
				'icon'   => 'fas fa-play',
				'fields' => array(

					// A textarea field
					array(
						'id'          => 'video_render',
						'type'        => 'select',
						'title'       => 'Video Render',

						'subtitle'    => 'Available in <a target="_blank" href="https://www.codeixer.com/product-gallery-slider-for-woocommerce?utm_source=freemium&utm_medium=settings_page&utm_campaign=upgrade_pro">Pro Version!</a>',
						'placeholder' => false,
						'options'     => array(
							'inner_section'    => 'Inner Gallery Section',
							'lightbox_section' => 'Lightbox Mode',

						),
						'default'     => 'lightbox_section',
					),
					array(
						'id'          => 'video_adjust_height',
						'type'        => 'number',
						'class'       => 'cix-only-pro',
						'subtitle'    => 'Available in <a target="_blank" href="https://www.codeixer.com/product-gallery-slider-for-woocommerce?utm_source=freemium&utm_medium=settings_page&utm_campaign=upgrade_pro">Pro Version!</a>',
						'title'       => __( 'Adjust Height', 'wpgs-td' ),
						'dependency'  => array( 'video_render', '==', 'inner_section' ),
						'unit'        => 'px',
						'output'      => '.wpgs-video-wrapper',
						'default'     => '500',
						'output_mode' => 'min-height',
					),
					array(
						'id'          => 'video_thumb',
						'type'        => 'radio',
						'title'       => 'Thumbnails Preview',
						'placeholder' => false,
						'class'       => 'cix-only-pro',
						'subtitle'    => 'Available in <a target="_blank" href="https://www.codeixer.com/product-gallery-slider-for-woocommerce?utm_source=freemium&utm_medium=settings_page&utm_campaign=upgrade_pro">Pro Version!</a>',
						'options'     => array(
							'video_thumb' => 'Video Thumbnail (Youtube & Vimeo)',
							'image_thumb' => 'Default Product Thumbnail',

						),
						'default'     => 'image_thumb',
					),

				),
			)
		);
		// Create a section
		\CSF::createSection(
			$prefix,
			array(
				'title'  => 'Advanced Options',
				'icon'   => 'fas fa-cog',
				'fields' => array(
					array(
						'id'    => 'check_divi_builder',
						'type'  => 'switcher',
						'title' => 'Divi Page Builder',
						'desc'  => 'Enable this option if Divi Page Builder was used to create a custom product page .',
					),
					array(
						'id'         => 'wpgs-shortcode',
						'type'       => 'text',
						'title'      => 'Gallery Shortcode',
						'desc'       => 'If you\'re using the Elementor, Divi or any other page Builders, you can display the gallery slider by using this shortcode for the Product page.',
						'default'    => '[product_gallery_slider]',
						'attributes' => array(
							'readonly' => 'readonly',
						),
					),
					array(
						'id'      => 'slider_image_size',
						'type'    => 'image_sizes',
						'title'   => __( 'Main Image Size', 'woo-product-gallery-slider' ),
						'default' => 'woocommerce_single',
					),
					array(
						'id'      => 'thumbnail_image_size',
						'type'    => 'image_sizes',
						'title'   => __( 'Thumbnail Image Size', 'woo-product-gallery-slider' ),
						'default' => 'woocommerce_gallery_thumbnail',
					),
					array(
						'type'    => 'submessage',
						'style'   => 'info',
						'content' => 'If the image size is not loading correctly on the single product page, that becasue the image size you selected is not available for the product images. <br> To solve this problem download this plugin <a target="_blank" href="https://wordpress.org/plugins/regenerate-thumbnails/">Regenerate Thumbnails</a> and regenerate all images from "Tools > Regenerate Thumbnails" Menu',
					),
					
					array(
						'id'       => 'custom_css',
						'type'     => 'code_editor',
						'title'    => 'Custom CSS',
						'desc'     => 'Add your custom CSS here',
						'settings' => array(
							'theme' => 'mbo',
							'mode'  => 'css',
						),

						'sanitize' => false,
					),

				),
			)
		);

		\CSF::createSection(
			$prefix,
			array(
				'title'  => 'Backup Settings',
				'icon'   => 'fas fa-sync',
				'fields' => array(

					array(
						'type' => 'backup',
					),

				),
			)
		);
	}
}
