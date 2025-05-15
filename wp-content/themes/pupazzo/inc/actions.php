<?php

if (! function_exists('pupazzo_menus')) {
	function pupazzo_menus()
	{
		register_nav_menus(array(
			'primary_menu' => __('Primary Menu', 'pupazzo'),
			'footer_menu'  => __('Footer Menu', 'pupazzo'),
		));
	}
	add_action('after_setup_theme', 'pupazzo_menus', 0);
}

// override woocommerce add to cart js
add_action('wp_enqueue_scripts', 'custom_override_woocommerce_add_cart_js', 100);
function custom_override_woocommerce_add_cart_js()
{
	// Remove WooCommerce default add-to-cart script
	wp_dequeue_script('wc-add-to-cart');
	wp_deregister_script('wc-add-to-cart');

	// Register your custom script
	wp_register_script(
		'wc-add-to-cart',
		get_stylesheet_directory_uri() . '/assets/js/woocommerce/custom-add-to-cart.js', // your file
		array('jquery', 'wp-util'),
		'1.0',
		true
	);

	// Enqueue it
	wp_enqueue_script('wc-add-to-cart');
}

// Add Sidebar
function add_shop_sidebar()
{
	register_sidebar([
		'name'          => __('Shop Sidebar', 'pupazzo'),
		'id'            => 'shop-sidebar',
		'description'   => __('Sidebar for WooCommerce product listings only.'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	]);
}
add_action('widgets_init', 'add_shop_sidebar');


add_action('template_redirect', function () {
	if (is_tax('product_cat')) {
		$term = get_queried_object();
		if ($term && !is_wp_error($term)) {
			$slug = $term->slug;
			$redirect_url = home_url('/shop/?category=' . $slug);
			wp_redirect($redirect_url, 301);
			exit;
		}
	}
});

add_filter('body_class', 'alter_search_classes');
function alter_search_classes($classes)
{

	foreach ($classes as $key => $class) {
		if ($class == 'search') {
			unset($classes[$key]);
		}
	}

	return $classes;
}
