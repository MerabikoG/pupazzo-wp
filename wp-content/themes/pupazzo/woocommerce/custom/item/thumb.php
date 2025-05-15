<?php
global $product;
$thumbnail_url = get_the_post_thumbnail_url($product->get_id(), 'woocommerce_thumbnail');
?>
<div class="img-block">
  <img src="<?php echo $thumbnail_url; ?>" alt="<?php echo $product->get_title(); ?>">
</div>