<?php

function symbiosis_acf_save($path)
{
  return get_stylesheet_directory() . '/acf';
}
add_filter('acf/settings/save_json', 'symbiosis_acf_save');

function symbiosis_load_fields($paths)
{
  // Remove the original path (optional).
  unset($paths[0]);

  // Append the new path and return it.
  $paths[] = get_stylesheet_directory() . '/acf';

  return $paths;
}
add_filter('acf/settings/load_json', 'symbiosis_load_fields');

add_filter('woocommerce_enqueue_styles', 'custom_remove_wc_layout_css', 20);

function custom_remove_wc_layout_css($styles)
{
  if (! is_admin()) {
    unset($styles['woocommerce-general']);      // Main WooCommerce styling
    unset($styles['woocommerce-layout']);       // Layout CSS (structure/responsive)
    // unset($styles['woocommerce-smallscreen']);  // Mobile-specific tweaks
    // unset($styles['woocommerce-blocks-style']); // Styles for Gutenberg blocks
  }
  return $styles;
}

add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = 24;
  return $cols;
}
