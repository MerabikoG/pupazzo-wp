<?php global $product; ?>
<div class="d-flex w-100 product-actions">
  <a href="?add-to-cart=<?php echo $product -> get_id(); ?>" class="add-to-cart product_type_simple add_to_cart_button ajax_add_to_cart" data-quantity="1" data-product_id="<?php echo $product -> get_id(); ?>" data-product_sku="">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/cart.svg" alt="">
  </a>
  <div class="add-to-favorites" data-pid="1613" data-uid="383">
    <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/images/heart-cyan.svg" alt=""> -->
     <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
  </div>
</div>