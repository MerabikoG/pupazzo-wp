<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

// This theme requires WordPress 5.3 or later.
if ( version_compare( $GLOBALS['wp_version'], '5.3', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'wp_empty_theme_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function wp_empty_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain( 'wp-empty-theme', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * This theme does not use a hard-coded <title> tag in the document head,
		 * WordPress will provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Add post-formats support.
		 */
		// add_theme_support(
		// 	'post-formats',
		// 	array(
		// 		'link',
		// 		'aside',
		// 		'gallery',
		// 		'image',
		// 		'quote',
		// 		'status',
		// 		'video',
		// 		'audio',
		// 		'chat',
		// 	)
		// );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'woocommerce' );
		set_post_thumbnail_size( 1568, 9999 );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);

		/*
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		$logo_width  = 300;
		$logo_height = 100;

		add_theme_support(
			'custom-logo',
			array(
				'height'               => $logo_height,
				'width'                => $logo_width,
				'flex-width'           => true,
				'flex-height'          => true,
				'unlink-homepage-logo' => true,
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );
	}
}
add_action( 'after_setup_theme', 'wp_empty_theme_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width Content width.
 */
function wp_empty_theme_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = 750;
}
add_action( 'after_setup_theme', 'wp_empty_theme_content_width', 0 );

/**
 * Prints the minimum theme stylesheet with WP-required directives.
 */
function wp_empty_theme_print_min_style() {
	$css = file_get_contents( get_stylesheet_directory() . '/min-style.css' );
	?>
	<style type="text/css">
		<?php echo $css; // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</style>
	<?php
}
add_action( 'wp_head', 'wp_empty_theme_print_min_style', 2 );

/**
 * Enqueues scripts and styles.
 */
function wp_empty_theme_scripts() {
	// Threaded comment reply styles.
	// This is the only script loaded by the theme, since it's effectively a
	// required default for WordPress themes.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_empty_theme_scripts' );

function enqueue_theme_styles()
{
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/vendor/bootstrap.min.css', array(), '0.1.0', 'all');
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/css/vendor/font-awesome.css', array(), '0.1.0', 'all');
    // wp_enqueue_style('slick', get_template_directory_uri() . '/assets/css/vendor/slick.css', array(), '0.1.0', 'all');
    // wp_enqueue_style('slick-theme', get_template_directory_uri() . '/assets/css/vendor/slick-theme.css', array(), '0.1.0', 'all');
    wp_enqueue_style('aksVideoPlayer', get_template_directory_uri() . '/assets/css/vendor/aksVideoPlayer.css', array(), '0.1.0', 'all');
    wp_enqueue_style('ionrangeslider', get_template_directory_uri() . '/assets/css/vendor/ionrangeslider.css', array(), '0.1.0', 'all');
    wp_enqueue_style('owl.carousel', get_template_directory_uri() . '/assets/css/vendor/owl.carousel.min.css', array(), '0.1.0', 'all');
    wp_enqueue_style('app', get_template_directory_uri() . '/assets/css/app.css', array(), '0.1.0', 'all');
    wp_enqueue_style('custom_app', get_template_directory_uri() . '/assets/css/custom_app.css', array(), '0.1.0', 'all');
    wp_enqueue_style('woocommerce_generalds', get_template_directory_uri() . '/assets/css/woocommerce.css', array(), '1', 'all');
    wp_enqueue_style('woocommerce_layoutds', get_template_directory_uri() . '/assets/css/woocommerce-layout.css', array(), '1', 'all');

		// Enqueue my scripts.
		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/vendor/bootstrap.min.js', array(), null, true );
		// wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/js/vendor/slick.min.js', array(), null, true );
		wp_enqueue_script( 'jquery-appear', get_template_directory_uri() . '/assets/js/vendor/jquery-appear.js', array(), null, true );    
		wp_enqueue_script( 'jquery-validator', get_template_directory_uri() . '/assets/js/vendor/jquery-validator.js', array(), null, true );    
		wp_enqueue_script( 'aksVideoPlayer', get_template_directory_uri() . '/assets/js/vendor/aksVideoPlayer.js', array(), null, true );    
		wp_enqueue_script( 'ionrangeslider', get_template_directory_uri() . '/assets/js/vendor/ionrangeslider.js', array(), null, true );    
		wp_enqueue_script( 'app', get_template_directory_uri() . '/assets/js/app.js', array(), null, true );    
		wp_enqueue_script( 'custom', get_template_directory_uri() . '/assets/js/custom.js', array(), null, true );
		wp_enqueue_script( 'owl.carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array(), null, false );
		
}
add_action('wp_enqueue_scripts', 'enqueue_theme_styles', 10);


function menu_items($location)
{
	if (!$location) {
		return [];
	}

	$locations = get_nav_menu_locations();
	if (!isset($locations[$location])) {
		return [];
	}

	$object = wp_get_nav_menu_object($locations[$location]);
	$menu_items = wp_get_nav_menu_items($object->name);
	$data = [];

	foreach ($menu_items as $item) {
		$item->title = mb_convert_encoding(str_replace("*", "", $item->title), 'UTF-8');
		$data[] = $item;
	}

	return $data;
}

function generate_menu_tree($menu, $parent = 0)
{
	$array = [];

	foreach ($menu as $item) {
		if ($item->menu_item_parent == $parent) {
			$children = generate_menu_tree($menu, $item->ID);
			if ($children) {
				$item->children = $children;
			}
			$array[] = $item;
		}
	}

	return $array;
}

// Enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/template-functions.php';

// Custom template tags for the theme.
require get_template_directory() . '/inc/template-tags.php';

// Theme Helper
require get_template_directory() . '/inc/classes/Helpers.php';
require get_template_directory() . '/inc/classes/Fina.php';
require get_template_directory() . '/inc/classes/Product.php';

// Symbiosis Actions
require get_template_directory() . '/inc/actions.php';

// Symbiosis Filters
require get_template_directory() . '/inc/filters.php';
require get_template_directory() . '/inc/woocommerce-actions.php';
require get_template_directory() . '/inc/routes.php';
