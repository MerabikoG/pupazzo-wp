<?php get_header('page'); ?>
<?php
while (have_posts()):
  the_post(); ?>

  <?php if (function_exists('is_woocommerce') && (is_shop() || is_product_category() || is_product_tag())) : ?>
    <div class="container p-4">
      <div class="row">
        <div class="col-xl-8 order-2">
          <?php the_content(); ?>
        </div>
        <div class="col-xl-4 order-1">
          <?php dynamic_sidebar('shop-sidebar'); ?>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="container p-4">
      <div class="row">
        <div class="content br-30 bg-white dark-shadow">
          <?php the_content(); ?>
        </div>
      </div>
    </div>
  <?php endif; ?>

<?php endwhile; ?>
<?php
get_footer();
