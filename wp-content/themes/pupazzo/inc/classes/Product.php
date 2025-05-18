<?php

namespace Pupazzo;

class Product
{

  protected $product;
  protected $params;
  protected $attributes = [];
  protected $cats = [];

  public function __construct($params)
  {
    $this->params = $this->convertData($params);
  }

  public function createNewProduct(): Product
  {
    $this->product = new \WC_Product_Simple();
    return $this;
  }

  public function setProduct($product_id)
  {
    $this->product = wc_get_product($product_id);
    return $this;
  }

  public function setName(): Product
  {
    $this->product->set_name($this->params['name']);
    return $this;
  }

  public function setCategory(): Product
  {
    $ids = Helper::SetProductCategoryByName($this->product->get_id(), array_merge($this->params['category'], $this->params['sub_category']));
    if ($ids) $this->product->set_category_ids($ids);
    return $this;
  }

  public function setSupplier($supplier)
  {
    wp_set_object_terms($this->product->get_id(), array($supplier), 'supplier');
    return $this;
  }

  public function setDescription(): Product
  {
    if ($this->params['full_description']) {
      preg_match('/<body>(.*?)<\/body>/s', $this->params['full_description'], $match);

      if (!isset($match[0]) || !$match[0]) {
        $this->product->set_description($this->params['full_description']);
      } else {
        $this->product->set_description($match[0]);
      }
    }

    return $this;
  }

  public function setSku(): Product
  {
    $this->product->set_sku($this->params['code']);
    return $this;
  }

  public function setPrice(): Product
  {
    if (!isset($this->params['sale'])) {
      $this->product->set_regular_price($this->params['price']);
    } else {
      $price = $this->params['price'] > $this->params['sale'] ? $this->params['price'] : $this->params['sale'];
      $this->product->set_regular_price($price);
    }

    return $this;
  }

  public function setSalePrice(): Product
  {
    $this->product->set_sale_price($this->params['sale']);
    return $this;
  }

  public function setStock(): Product
  {
    $this->product->set_manage_stock(true);
    $this->product->set_stock_quantity($this->params['amount']);
    return $this;
  }

  public function setWeight(): Product
  {
    $this->product->set_weight($this->params['weight_kg']);
    return $this;
  }

  public function setBrand(): Product
  {
    $this->generateAttributes('pa_brands', $this->params['brand']);
    return $this;
  }

  public function setAges(): Product
  {
    if ($this->params['age'] && !empty($this->params['age'])) {
      foreach ($this->params['age'] as $age) {
        $this->generateAttributes('pa_age', $age);
      }
    }
    return $this;
  }

  public function setCountry(): Product
  {
    $this->generateAttributes('pa_country', $this->params['manufacturer_country']);
    return $this;
  }

  public function setThumb(): Product
  {

    if ($this->params['thumb']) {
      $image = Helper::UploadImage($this->params['thumb']);
      $this->product->set_image_id($image['attachment_id']);
    }

    return $this;
  }

  public function setGallery(): Product
  {

    if ($this->params['gallery']) {
      $gallery = [];

      foreach ($this->params['gallery'] as $img) {
        $gallery_image = Helper::UploadImage($img);

        if ($gallery_image && isset($gallery_image['attachment_id'])) {
          $gallery[] = $gallery_image['attachment_id'];
        }
      }
      $this->product->set_gallery_image_ids($gallery);
    }

    return $this;
  }

  public function setUnit(): Product
  {
    return $this;
  }

  public function setMetas(): Product
  {
    return $this;
  }

  public  function setInstalment(): Product
  {
    $product_id = $this->product->get_id();
    $instalment_type_value = false;
    $product_installment_consumer_value = false;
    update_field('instalment_type', $instalment_type_value, $product_id);
    update_field('product_installment_consumer', $product_installment_consumer_value, $product_id);

    return $this;
  }

  public function setStatus($status = false)
  {

    $published = $status == 1 ? 'draft' : 'publish';
    $this->product->set_status($published);

    return $this;
  }

  public function save()
  {
    $this->product->set_attributes($this->attributes);
    $this->product->save();

    return $this->product;
  }

  public function update()
  {
    $this->product->save();
    return $this;
  }

  public function convertData($params)
  {
    $this->params = [
      'name' => $params->title_ka,
      'price' => $params->price,
      // 'sale' => $params->sale_price,
      'amount' => $params->storage,
      'code' => $params->finaCode,
      'thumb' => $params->mainImage,
      'gallery' => $params->galleryImages,
      'full_description' => $params->description,
      'brand' => $params->brand_id,
      'category' => $params->main_cat ? $params->main_cat : [],
      'sub_category' => $params->sub_cat ? $params->sub_cat : [],
      'age' => $params->age_id,
      'status' => $params->hide == 1 ? 'draft' : 'publish',
    ];

    return $this->params;
  }

  public function generateAttributes($name, $attrs)
  {
    $attribute = new \WC_Product_Attribute();
    $attribute->set_id(wc_attribute_taxonomy_id_by_name($name));
    $attribute->set_name($name);
    $attribute->set_options([$attrs]);
    $attribute->set_visible(true);
    $attribute->set_variation(false);
    $this->attributes[] = $attribute;
  }
}
