<?php
global $product;
$regular_price = (float) $product->get_regular_price();
$sale_price    = (float) $product->get_sale_price();
$percentage    = $sale_price ? round(100 - ($sale_price / $regular_price * 100)) . '%' : $sale_price;

?>
<?php if($product -> is_on_sale()): ?>
<div class="discount z-1">
  <?php printf(__('ფასდაკლება %s', 'pupazzo'), $percentage); ?>
</div>
<?php endif; ?>