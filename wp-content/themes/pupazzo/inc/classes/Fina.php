<?php

class Fina
{

  protected $user = "pupazzo";
  protected $password = "ds!s0#1";
  protected $base_uer = "http://109.172.210.179:8085/api/";

  protected $bearer = null;

  public function __construct()
  {

    $auth_cred = json_encode([
      "login" => $this->user,
      "password" => $this->password
    ]);

    $this->bearer = json_decode($this->AuthRequest('authentication/authenticate', $auth_cred))->token;
  }

  public function GetAllProducts()
  {
    return json_decode($this->GetRequest('operation/getProducts'));
  }

  public function GetAllProductsQuantity()
  {
    return json_decode($this->GetRequest('operation/getProductsRest'));
  }

  public function GetAllProductsPrice()
  {
    return json_decode($this->GetRequest('operation/getProductPrices'));
  }

  public function SaveDocProductOut($products, $costs)
  {
    $data = [
      "id" => 0,
      "date" => Date('Y-m-d h:i:s'),
      "num_pfx" => "",
      "num" => 0,
      "purpose" => "Web",
      "amount" => $costs,
      "currency" => "GEL",
      "rate" => 1,
      "store" => 5,
      "user" => 2,
      "staff" => 3,
      "is_vat" => true,
      "make_entry" => true,
      "pay_type" => 1,
      "w_type" => 2,
      "t_type" => 1,
      "t_payer" => 2,
      "foreign" => false,
      "overlap_type" => 0,
      "overlap_amount" => 0,
      "products" => $products,
    ];


    return json_decode($this->PostRequst('operation/saveDocProductOut', $data));
  }

  public function GetProductByCode($code) {
    $products = json_decode($this->GetRequest('operation/getProducts'));
    $result = [];

    foreach($products -> products as $product) {
      if ($product -> code == $code) {
        $result = $product -> id;
        break;
      }
    }
    return $result;
  }

  public function GetRequest($url)
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://109.172.210.179:8085/api/' . $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer " . $this->bearer
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
  }

  public function PostRequst($url, $data)
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $this->base_uer . $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode($data),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        "Authorization: Bearer " . $this->bearer
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
  }

  public function AuthRequest($url, $data)
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $this->base_uer . $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $data,
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
  }
}
