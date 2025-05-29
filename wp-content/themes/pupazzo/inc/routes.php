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

          if ($product->mainImage) {
            $product->mainImage = "https://pupazzo.ge/products/{$product->mainImage}";
          }

          if ($product->galleryImages) {
            $images = explode(",", $product->galleryImages);
            $product->galleryImages = [];

            foreach ($images as $image) {
              $product->galleryImages[] = "https://pupazzo.ge/products/$image";
            }
          }
        }

        foreach ($products as $product) {
          //           print_r($product); exit;
          try {
            $created = (new \Pupazzo\Product((object) $product))
              ->createNewProduct()
              ->setName()
              ->setDescription()
              ->setCategory()
              ->setSku()
              ->setStock()
              ->setPrice()
              ->setBrand()
              // ->setSalePrice()
              ->setAges()
              ->setThumb()
              ->setGallery()
              ->setStatus($product->hide)
              ->save();
            wp_set_object_terms($created->get_id(), $product->brand_id, 'product_brand', true);
          } catch (\Throwable $th) {
            echo $th->getMessage();
          }
        }
      },
      'permission_callback' => '__return_true'
    )
  );
});


add_action(
  'rest_api_init',
  function () {
    register_rest_route(
      'import',
      '/fina',
      array(
        'methods' => 'GET',
        'callback' => function () {

          global $wpdb;

          $prods = $wpdb->get_results("SELECT meta_value as sku, post_id as id FROM wp_postmeta WHERE meta_key = '_sku' AND post_id IN (SELECT ID FROM wp_posts WHERE post_type = 'product')");
          $WebProductCodes = wp_list_pluck($prods, 'sku');
          $pupazzo_id = wp_list_pluck($prods, 'id');

          // return [$pupazzo_sku, $pupazzo_id];


          $fina = new Fina();
          $FineProducts = $fina->GetAllProducts();
          $FinaProductsQuantity = $fina->GetAllProductsQuantity();
          $FinaProductPrices = $fina->GetAllProductsPrice();

          $ExistedProductIds = [];
          $ProductPricesAndQuantity = [];

          $NotExistedProductIds = [];
          $NotExistedProductsQuantity = [];


          foreach ($FineProducts->products as $finaProd) {
            if (in_array($finaProd->code, $WebProductCodes)) {
              $ExistedProductIds[$finaProd->id] = $finaProd->code;
            } else {
              $NotExistedProductIds[$finaProd->id] = [
                "id" => $finaProd->code,
                "name" => $finaProd->name,
              ];
            }
          }

          foreach ($FinaProductsQuantity->rest as $prodRest) {
            if (in_array($prodRest->id, array_keys($ExistedProductIds))) {
              if (isset($ProductPricesAndQuantity[$prodRest->id])) {
                $ProductPricesAndQuantity[$prodRest->id]["storage"] = $ProductPricesAndQuantity[$prodRest->id]["storage"] + $prodRest->rest;
              } else {
                $ProductPricesAndQuantity[$prodRest->id] = [
                  "storage" => $prodRest->rest,
                  "finaCode" => $ExistedProductIds[$prodRest->id]
                ];
              }
            } else {
              if (isset($NotExistedProductsQuantity[$prodRest->id])) {
                $NotExistedProductsQuantity[$prodRest->id]["storage"] = $NotExistedProductsQuantity[$prodRest->id]["storage"] + $prodRest->rest;
              } else {
                $NotExistedProductsQuantity[$prodRest->id] = [
                  "storage" => $prodRest->rest,
                  "finaCode" => $NotExistedProductIds[$prodRest->id]["id"],
                  "name" => $NotExistedProductIds[$prodRest->id]["name"],
                ];
              }
            }
          }


          foreach ($FinaProductPrices->prices as $price) {
            if (in_array($price->product_id, array_keys($ProductPricesAndQuantity))) {
              if (isset($ProductPricesAndQuantity[$price->product_id]["price"])) {
                $ProductPricesAndQuantity[$price->product_id]["price"] = $price->price > $ProductPricesAndQuantity[$price->product_id]["price"] ? $price->price : $ProductPricesAndQuantity[$price->product_id]["price"];
              } else {
                $ProductPricesAndQuantity[$price->product_id]["price"] = $price->price;
              }
            } else {
              if (isset($NotExistedProductsQuantity[$price->product_id]["price"])) {
                $NotExistedProductsQuantity[$price->product_id]["price"] = $price->price > $NotExistedProductsQuantity[$price->product_id]["price"] ? $price->price : $NotExistedProductsQuantity[$price->product_id]["price"];
              } else {
                $NotExistedProductsQuantity[$price->product_id]["price"] = $price->price;
              }
            }
          }

          foreach ($FinaProductPrices->prices as $price) {
            if (in_array($price->product_id, array_keys($ProductPricesAndQuantity))) {
              if (isset($ProductPricesAndQuantity[$price->product_id]["price"])) {
                $ProductPricesAndQuantity[$price->product_id]["price"] = $price->price > $ProductPricesAndQuantity[$price->product_id]["price"] ? $price->price : $ProductPricesAndQuantity[$price->product_id]["price"];
              } else {
                $ProductPricesAndQuantity[$price->product_id]["price"] = $price->price;
              }
            } else {
              if (isset($NotExistedProductsQuantity[$price->product_id]["price"])) {
                $NotExistedProductsQuantity[$price->product_id]["price"] = $price->price > $NotExistedProductsQuantity[$price->product_id]["price"] ? $price->price : $NotExistedProductsQuantity[$price->product_id]["price"];
              } else {
                $NotExistedProductsQuantity[$price->product_id]["price"] = $price->price;
              }
            }
          }


          $InStoreNotExistedProducts = array_filter($NotExistedProductsQuantity, function ($value) {
            return $value['storage'] > 0;
          });

          $select_existed_products = "";

          // return $ProductPricesAndQuantity;
          // return $prods;
          $existed_values = array_values($ProductPricesAndQuantity);

          if ($ProductPricesAndQuantity && $prods) {
            foreach ($prods as $existed_id) {
              // return $existed_id -> sku;
              $key_in_existed  = array_search($existed_id->sku, array_column($ProductPricesAndQuantity, 'finaCode'));

              if ($key_in_existed) {
                $update_product_data = [
                  'title_ka' => "",
                  'price' => $existed_values[$key_in_existed]['price'],
                  'storage' => $existed_values[$key_in_existed]['storage'],
                  'finaCode' => false,
                  'mainImage' => false,
                  'galleryImages' => false,
                  'description' => "",
                  'brand_id' => false,
                  'main_cat' => [],
                  'sub_cat' => [],
                  'age_id' => false,
                  'hide' => 1,
                ];

                // return [$existed_values[$key_in_existed], $existed_id];
                // return $update_product_data;

                try {
                  (new \Pupazzo\Product((object) $update_product_data))
                    ->setProduct($existed_id->id)
                    // ->setName()
                    // ->setDescription()
                    // ->setSku()
                    ->setStock()
                    ->setPrice()
                    // ->setStatus(true)
                    ->save();
                } catch (\Throwable $th) {
                  echo $th->getMessage();
                }
              }

              continue;
            }
          }


          if ($InStoreNotExistedProducts) {
            foreach ($InStoreNotExistedProducts as $product) {

              $add_data = [
                'title_ka' => $product['name'],
                'price' => $product['price'],
                'storage' => $product['storage'],
                'finaCode' => $product['finaCode'],
                'mainImage' => false,
                'galleryImages' => false,
                'description' => "",
                'brand_id' => false,
                'main_cat' => [],
                'sub_cat' => [],
                'age_id' => false,
                'hide' => 1,
              ];

              try {
                $created = (new \Pupazzo\Product((object) $add_data))
                  ->createNewProduct()
                  ->setName()
                  ->setDescription()
                  ->setSku()
                  ->setStock()
                  ->setPrice()
                  ->setStatus(true)
                  ->save();
              } catch (\Throwable $th) {
                echo $th->getMessage();
              }
            }
          }




          return [$InStoreNotExistedProducts, $ProductPricesAndQuantity];
        }
      )
    );
  }
);
