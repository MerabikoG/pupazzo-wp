<?php global $product; ?>
<div class="name-price">
  <div class="product-name">
    <a href="<?php echo get_the_permalink(); ?>">
      <?php echo get_the_title(); ?>
    </a>
  </div>
  <div class="product-price">
    <?php if($product -> is_on_sale()): ?>
      <h3 class="bold new-price"><?php echo $product -> get_sale_price(); ?>₾</h3>
      <h3 class="bold old-price sale-price"><?php echo $product -> get_regular_price(); ?>₾</h3>
    <?php else: ?>
      <h3 class="bold old-price"><?php echo $product -> get_regular_price(); ?>₾</h3>
    <?php endif; ?>
  </div>
</div>