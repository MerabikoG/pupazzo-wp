<?php

namespace Symbiosis\TbcInstallment\Traits;

trait Options
{
  public function init_form_fields()
  {
    $this->form_fields = [
      'enabled' => [
        'title' => 'Enable/Disable',
        'label' => 'Enable TBC Installments',
        'type' => 'checkbox',
        'description' => '',
        'default' => 'no'
      ],
      'title' => [
        'title' => 'Title',
        'type' => 'text',
        'description' => 'This controls the title which the user sees during checkout.',
        'default' => 'თიბისი განვადება',
        'desc_tip' => true,
      ],
      'description' => [
        'title' => 'Description',
        'type' => 'textarea',
        'description' => 'This controls the description which the user sees during checkout.',
        'default' => '',
      ],
      'url' => [
        'title' => 'TBC APP Endpoint',
        'type' => 'select',
        'description' => 'Test: https://test-api.tbcbank.ge, Prod: https://api.tbcbank.ge',
        'default' => '',
        'options' => [
          'https://test-api.tbcbank.ge' => 'Test',
          'https://api.tbcbank.ge' => 'Prod'
        ]
      ],
      'api_secret' => [
        'title' => 'Secret',
        'label' => 'TBC api Secret',
        'type' => 'text',
        'description' => '',
      ],
      'api_key' => [
        'title' => 'Key',
        'label' => 'TBC api key',
        'type' => 'text',
        'description' => '',
      ],
      'merchant' => [
        'title' => 'Mechant',
        'label' => 'TBC Merchant ID',
        'type' => 'text',
        'description' => 'Test Mechant ID: 000000000-ce21da5e-da92-48f3-8009-4d438cbcc137',
      ],
      'campaign' => [
        'title' => 'Campaign',
        'label' => 'Campaign ID',
        'type' => 'text',
        'description' => 'Test ID: 204',
      ],
    ];
  }
}
