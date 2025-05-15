<?php

add_action('rest_api_init', function () {
  register_rest_route(
    'import',
    '/products',
    array(
      'methods' => 'GET',
      'callback' => function () {

        $products_json = file_get_contents(get_template_directory() . '/products.json');
        $categories = json_decode(file_get_contents(get_template_directory() . '/category.json'));
        $subcategories = json_decode(file_get_contents(get_template_directory() . '/subcategory.json'));
        $brands = json_decode(file_get_contents(get_template_directory() . '/brands.json'));
        $ages = json_decode(file_get_contents(get_template_directory() . '/ages.json'));

        $products = json_decode($products_json);
        $result = [];

        foreach ($products as $product) {
          if ($product->main_cat) {
            $cat_ids = explode(",", $product->main_cat);
            $product->main_cat = [];
            foreach ($categories as $cat) {
              if (in_array($cat->id, $cat_ids)) {
                $product->main_cat[] = $cat->title_ka;
              }
            }
          }

          if ($product->sub_cat) {
            $sub_ids = explode(",", $product->sub_cat);
            $product->sub_cat = [];
            foreach ($subcategories as $scat) {
              if (in_array($scat->id, $sub_ids)) {
                $product->sub_cat[] = $scat->title_ka;
              }
            }
          }

          if ($product->age_id) {
            $age_ids = explode(",", $product->age_id);
            $product->age_id = [];
            foreach ($ages as $age) {
              if (in_array($age->id, $age_ids)) {
                $product->age_id[] = $age->title_ka;
              }
            }
          }

          if ($product->brand_id) {
            foreach ($brands as $brand) {
              if ($brand->id == $product->brand_id) {
                $product->brand_id = $brand->title_ka;
              }
            }
          }

          if ($product -> mainImage) {
            $product -> mainImage = "https://pupazzo.ge/assets/images/products/{$product -> mainImage}";
          }

          if ($product -> galleryImages) {
            $images = explode(",", $product -> galleryImages);
            $product -> galleryImages = [];

            foreach($images as $image) {
              $product -> galleryImages[] = "https://pupazzo.ge/assets/images/products/$image";
            }
          }
        }

        // return $products;

        foreach($products as $product) {
          try {
            $created = (new \Pupazzo\Product((object) $product))
                ->createNewProduct()
                ->setName()
                ->setDescription()
                ->setCategory()
                ->setSku()
                ->setStock()
                ->setPrice()
                // ->setSalePrice()
                ->setAges()
                ->setThumb()
                ->setGallery()
                ->setStatus($product -> hide)
                ->save();
          } catch (\Throwable $th) {
            continue;
          }
        }
      },
      'permission_callback' => '__return_true'
    )
  );
});
