<?php

namespace Symbiosis\TbcInstallment;

class TBC_Request
{
	private string $baseUrl = "";
	private string $secret = "";
	private string $key = "";
	private int $campaignId = 0;
	private string $merchantKey = "";

	private string $bearer = "";

	public function __construct($baseUrl, $secret, $key, $campaignId, $merchantKey)
	{

		$this->baseUrl = $baseUrl;
		$this->secret = $secret;
		$this->key = $key;
		$this->campaignId = $campaignId;
		$this->merchantKey = $merchantKey;

		$this->bearer = $this->auth();
	}

	public function auth()
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->baseUrl . '/oauth/token',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => 'grant_type=client_credentials&scope=online_installments',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/x-www-form-urlencoded',
				'Authorization: Basic ' . base64_encode($this->key . ':' . $this->secret)
			),
		));
		$response = json_decode(curl_exec($curl));
		curl_close($curl);
		return $response->access_token;
	}

	public function curlPost($url, $data, $header = [])
	{
		$apiResponse = wp_remote_post(
			$this->baseUrl . $url,
			[
				'method'    => 'POST',
				'headers'   => $header,
				'body' => $data
			]
		);
		$apiBody     = json_decode(wp_remote_retrieve_body($apiResponse));

		return [
			'body' => $apiBody,
			'header' => wp_remote_retrieve_headers($apiResponse),
			'code' => wp_remote_retrieve_response_code($apiResponse)
		];
	}

	public function createOrder($order)
	{
		$header = [
			'Content-Type' => 'application/json',
			'Authorization' => "Bearer {$this->bearer}"
		];
		$json = json_encode($order);
		$response = $this->curlPost('/v1/online-installments/applications', $json, $header);

		if ($response['code'] == '201') {
			return [
				'success' => true,
				'redirect' => $response['header']['location'],
				'id' => $response['body']->sessionId,
			];
		} else {
			return [
				'success' => false,
			];
		}
	}
}
