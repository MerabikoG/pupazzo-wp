<?php

// Remove Actions
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);

// remove_action('woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_header', 10);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);


// Add Actions To products
add_action('woocommerce_shop_loop_item_title', 'product_price_and_title', 10);
add_action('woocommerce_before_shop_loop_item_title', 'product_item_start_content', 10);
add_action('woocommerce_after_shop_loop_item_title', 'product_item_end_content', 40);
add_action('woocommerce_before_shop_loop_item', 'product_sale_badge');
add_action('woocommerce_before_shop_loop_item_title', 'product_add_to_cart', 15);
add_action('woocommerce_before_shop_loop_item_title', 'product_thumbnail', 10);

add_action('woocommerce_before_shop_loop', function() {
  return wc_get_template('custom/loop/start.php');
});

add_action('woocommerce_after_shop_loop', function() {
  return wc_get_template('custom/loop/end.php');
});

add_action('woocommerce_single_product_summary', function() {
  return wc_get_template('custom/item/fina.php');
});

















// Template Functions
function product_price_and_title() {
  return wc_get_template('custom/item/title.php');
}

function product_item_start_content() {
  echo '<div class="content">';
}

function product_item_end_content() {
  echo '</div>';
}

function product_sale_badge() {
  return wc_get_template('custom/item/sale.php');
}

function product_add_to_cart() {
  return wc_get_template('custom/item/cart.php');
}

function product_thumbnail() {
  return wc_get_template('custom/item/thumb.php');
}