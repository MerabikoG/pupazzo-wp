<?php
function register_tbc_installments_order_status()
{
  register_post_status('wc-tbc-pen-auth', array(
    'label'                     => 'Pending for authentication (TBC Installment)',
    'public'                    => false,
    'show_in_admin_status_list' => true,
    'show_in_admin_all_list'    => true,
    'exclude_from_search'       => true,
    'label_count'               => _n_noop('Pending for authentication (TBC Installment) <span class="count">(%s)</span>', 'Pending for authentication (TBC Installment) <span class="count">(%s)</span>')
  ));

  register_post_status('wc-tbc-in-progress', array(
    'label'                     => 'In Progress (TBC Installment)',
    'public'                    => false,
    'show_in_admin_status_list' => true,
    'show_in_admin_all_list'    => true,
    'exclude_from_search'       => true,
    'label_count'               => _n_noop('In Progress (TBC Installment) <span class="count">(%s)</span>', 'In Progress (TBC Installment) <span class="count">(%s)</span>')
  ));

  register_post_status('wc-tbc-approved', array(
    'label'                     => 'Approved by TBC Bank (TBC Installment)',
    'public'                    => false,
    'show_in_admin_status_list' => true,
    'show_in_admin_all_list'    => true,
    'exclude_from_search'       => true,
    'label_count'               => _n_noop('Approved by TBC Bank (TBC Installment) <span class="count">(%s)</span>', 'Approved by TBC Bank (TBC Installment) <span class="count">(%s)</span>')
  ));

  register_post_status('wc-tbc-expired', array(
    'label'                     => 'Expired (TBC Installment)',
    'public'                    => false,
    'show_in_admin_status_list' => true,
    'show_in_admin_all_list'    => true,
    'exclude_from_search'       => true,
    'label_count'               => _n_noop('Expired (TBC Installment) <span class="count">(%s)</span>', 'Expired (TBC Installment) <span class="count">(%s)</span>')
  ));

  register_post_status('wc-tbc-canceled', array(
    'label'                     => 'Canceled (TBC Installment)',
    'public'                    => false,
    'show_in_admin_status_list' => true,
    'show_in_admin_all_list'    => true,
    'exclude_from_search'       => true,
    'label_count'               => _n_noop('Canceled (TBC Installment) <span class="count">(%s)</span>', 'Canceled (TBC Installment) <span class="count">(%s)</span>')
  ));

  register_post_status('wc-tbc-w-merchant', array(
    'label'                     => 'Waiting For Merchant (TBC Installment)',
    'public'                    => false,
    'show_in_admin_status_list' => true,
    'show_in_admin_all_list'    => true,
    'exclude_from_search'       => true,
    'label_count'               => _n_noop('Waiting For Merchant (TBC Installment) <span class="count">(%s)</span>', 'Waiting For Merchant (TBC Installment) <span class="count">(%s)</span>')
  ));

  register_post_status('wc-tbc-declined', array(
    'label'                     => 'Declined by TBC Bank (TBC Installment)',
    'public'                    => false,
    'show_in_admin_status_list' => true,
    'show_in_admin_all_list'    => true,
    'exclude_from_search'       => true,
    'label_count'               => _n_noop('Declined by TBC Bank (TBC Installment) <span class="count">(%s)</span>', 'Declined by TBC Bank (TBC Installment) <span class="count">(%s)</span>')
  ));

  register_post_status('wc-tbc-merch-cancel', array(
    'label'                     => 'Canceled By Merchant (TBC Installment)',
    'public'                    => false,
    'show_in_admin_status_list' => true,
    'show_in_admin_all_list'    => true,
    'exclude_from_search'       => true,
    'label_count'               => _n_noop('Canceled By Merchant (TBC Installment) <span class="count">(%s)</span>', 'Canceled By Merchant (TBC Installment) <span class="count">(%s)</span>')
  ));

  register_post_status('wc-tbc-disbursed', array(
    'label'                     => 'Disbursed (TBC Installment)',
    'public'                    => false,
    'show_in_admin_status_list' => true,
    'show_in_admin_all_list'    => true,
    'exclude_from_search'       => true,
    'label_count'               => _n_noop('Disbursed (TBC Installment) <span class="count">(%s)</span>', 'Disbursed (TBC Installment) <span class="count">(%s)</span>')
  ));

  register_post_status('wc-tbc-pending-disbursed', array(
    'label'                     => 'Pending Disbursed (TBC Installment)',
    'public'                    => false,
    'show_in_admin_status_list' => true,
    'show_in_admin_all_list'    => true,
    'exclude_from_search'       => true,
    'label_count'               => _n_noop('Pending Disbursed (TBC Installment) <span class="count">(%s)</span>', 'Pending Disbursed (TBC Installment) <span class="count">(%s)</span>')
  ));

  register_post_status('wc-tbc-renew', array(
    'label'                     => 'Need renew (TBC Installment)',
    'public'                    => false,
    'show_in_admin_status_list' => true,
    'show_in_admin_all_list'    => true,
    'exclude_from_search'       => true,
    'label_count'               => _n_noop('Need renew (TBC Installment) <span class="count">(%s)</span>', 'Need renew (TBC Installment) <span class="count">(%s)</span>')
  ));

  register_post_status('wc-tbc-doc-upload', array(
    'label'                     => 'Waiting Documents Upload (TBC Installment)',
    'public'                    => false,
    'show_in_admin_status_list' => true,
    'show_in_admin_all_list'    => true,
    'exclude_from_search'       => true,
    'label_count'               => _n_noop('Waiting Documents Upload (TBC Installment) <span class="count">(%s)</span>', 'Waiting Documents Upload (TBC Installment) <span class="count">(%s)</span>')
  ));

  register_post_status('wc-tbc-doc-verify', array(
    'label'                     => 'Waiting Documents Verification (TBC Installment)',
    'public'                    => false,
    'show_in_admin_status_list' => true,
    'show_in_admin_all_list'    => true,
    'exclude_from_search'       => true,
    'label_count'               => _n_noop('Waiting Documents Verification (TBC Installment) <span class="count">(%s)</span>', 'Waiting Documents Verification (TBC Installment) <span class="count">(%s)</span>')
  ));

  register_post_status('wc-tbc-dec-docs', array(
    'label'                     => 'Documents declined (TBC Installment)',
    'public'                    => false,
    'show_in_admin_status_list' => true,
    'show_in_admin_all_list'    => true,
    'exclude_from_search'       => true,
    'label_count'               => _n_noop('Documents declined (TBC Installment) <span class="count">(%s)</span>', 'Documents declined (TBC Installment) <span class="count">(%s)</span>')
  ));

}
add_action('init', 'register_tbc_installments_order_status');

function add_tbc_installment_order_statuses($order_statuses)
{
    $new_order_statuses = array();
    foreach ($order_statuses as $key => $status) {
        $new_order_statuses[$key] = $status;
        if ('wc-processing' === $key) {
            $new_order_statuses['wc-tbc-pen-auth'] = 'Pending for client authentication (TBC განვადება)';
            $new_order_statuses['wc-tbc-in-progress'] = 'In Progress (TBC განვადება)';
            $new_order_statuses['wc-tbc-approved'] = 'Approved by TBC Bank (TBC განვადება)';
            $new_order_statuses['wc-tbc-expired'] = 'Expired (TBC განვადება)';
            $new_order_statuses['wc-tbc-canceled'] = 'Canceled (TBC განვადება)';
            $new_order_statuses['wc-tbc-w-merchant'] = 'Waiting For Merchant (TBC განვადება)';
            $new_order_statuses['wc-tbc-declined'] = 'Declined by TBC Bank (TBC განვადება)';
            $new_order_statuses['wc-tbc-merch-cancel'] = 'Canceled By Merchant (TBC განვადება)';
            $new_order_statuses['wc-tbc-disbursed'] = 'Disbursed (Confirmed from both side) (TBC განვადება)';
            $new_order_statuses['wc-tbc-pending-disbursed'] = 'Pending Disbursed (Confirmed from both side) (TBC განვადება)';
            $new_order_statuses['wc-tbc-renew'] = 'Need Confirmation of Renewed (TBC განვადება)';
            $new_order_statuses['wc-tbc-doc-upload'] = 'Waiting For Income Documents (TBC განვადება)';
            $new_order_statuses['wc-tbc-doc-verify'] = 'Waiting For Income Documents Verification (TBC განვადება)';
            $new_order_statuses['wc-tbc-dec-docs'] = 'Income Document(s) Declined (TBC განვადება)';
        }
    }
    return $new_order_statuses;
}
add_filter('wc_order_statuses', 'add_tbc_installment_order_statuses');
