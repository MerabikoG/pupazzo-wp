<?php
// Template Name: Home

get_header();

$fields = get_fields();
?>

<div class="hero-banner-1">
    <div class="owl-carousel owl-theme">
        <?php foreach ($fields["home_slider"] as $item): ?>
            <div class="item">
                <img src="<?php echo $item["slide"]; ?>" class="d-block w-100">
            </div>
        <?php endforeach; ?>
    </div>
</div>


<div class="page-content">
    <?php if (isset($fields["home_popular_products"]) && !empty($fields["home_popular_products"])): ?>

        <?php
        $product_args = array(
            'post_type' => 'product',
            'posts_per_page' => 8,
        );

        $popular_loop = new WP_Query($product_args);
        ?>

        <?php if ($popular_loop->have_posts()): ?>
            <section class="top-seller py-5">
                <div class="container">
                    <div class="heading mb-48 text-center">
                        <h2><?php _e('პოპულარული პროდუქტები', 'pupazzo'); ?></h2>
                    </div>
                    <ul class="products">
                        <div class="row mb-16">
                            <?php while ($popular_loop->have_posts()): ?>
                                <?php $popular_loop->the_post(); ?>
                                <div class="col-xl-3 col-lg-4 col-sm-6 col-6 mb-sm-5">
                                    <?php
                                    wc_get_template_part('content', 'product'); // uses content-product.php 
                                    ?>
                                </div>
                            <?php endwhile; ?>

                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="<?php echo wc_get_page_permalink( 'shop' ); ?>" class="cus-btn primary"> <?php _e('ყველა პროდუქტი', 'pupazzo'); ?> </a>
                        </div>
                    </ul>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    $news_args = [
        'post_type' => 'post',
        'posts_per_page' => 3,
    ];

    $news_loop = new WP_Query($news_args);
    ?>

    <?php if ($popular_loop->have_posts()): ?>
        <!-- Blogs Area Start -->
        <section class="blog p-96">
            <div class="container">
                <div class="heading mb-48 text-center">
                    <h2>სიახლეები</h2>
                </div>
                <div class="row">
                    <?php while ($news_loop->have_posts()): ?>
                        <?php $news_loop->the_post(); ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="blog-card mb-24 mb-lg-0">
                                <img src="<?php echo get_the_post_thumbnail_url(get_post(), 'post-thumbnail'); ?>" class="w-100" alt="">
                                <div class="content">
                                    <a href="<?php echo get_permalink(); ?>" class="color-black h-27 mb-16">
                                        <?php echo get_the_title(); ?>
                                    </a>
                                    <div class="name-btn">
                                        <a href="<?php echo get_permalink(); ?>" class="light-btn primary">
                                            <?php _e('სრულად ნახვა', 'pupazzo') ?>
                                            <i class="far fa-angle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>

                </div>
            </div>
        </section>
        <!-- Blogs Area End -->
    <?php endif; ?>


</div>


<?php
get_footer();
