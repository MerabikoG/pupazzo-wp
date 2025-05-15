<?php

/**
 * Product taxonomy archive header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

if (! defined('ABSPATH')) {
	exit;
}

?>
<?php if (!is_singular(['product']) && !is_home() && !is_front_page()): ?>
	<div class="page-title-banner">
		<div class="container">
			<div class="left-right-image">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-1.png"
					class="left-img" alt>
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-2.png"
					class="right-img" alt>
			</div>
			<div class="content">
				<div class="title">
					<h2><?php woocommerce_page_title(); ?></h2>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>