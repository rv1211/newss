<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|    https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|    $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|    $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|    $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:    my-controller/index    -> my_controller/index
|        my-controller/my-method    -> my_controller/my_method
 */

// default controller of web
// $route['default_controller'] = 'Front_home/index';
$route['default_controller'] = 'home';

//Front End Static page
//Front End Static page

$route['contact'] = 'home/contact_page';
$route['about'] = 'home/about_us';
$route['login'] = 'home/login_user';
$route['login/user'] = 'Front_login/index';
$route['save/contact'] = 'home/save_contact';
$route['register'] = 'home/register';
$route['register/user'] = 'home/register_user';
$route['privacy-policy'] = 'home/privacy_policy';
$route['terms-conditions'] = 'home/terms_conditions';
$route['disclaimer'] = 'home/disclaimer';
$route['get-quote'] = 'home/get_quate';
$route['logout'] = 'home/logout';
$route['track-order'] = 'home/track_order';
$route['track-order-number/(:any)'] = 'home/track_order_number/$1';
$route['shipping-label-for-udaan-express/(:any)'] = 'home/package_slip_udaan_express/$1';



//add Link by unnati start
// $route['about-us'] = 'Front_home/about_us';
// $route['contact-us'] = 'Front_home/contact_us';
// $route['features'] = 'Front_home/features';
// $route['faq'] = 'Front_home/faq';
// $route['disclaimer'] = 'Front_home/disclaimer';
// $route['term-conditions'] = 'Front_home/term_conditions';
// $route['privacy-policy'] = 'Front_home/privacy_policy';
// $route['support-policy'] = 'Front_home/support_policy';
// $route['refund-cancellation-policy'] = 'Front_home/refund_cancellation_policy';
// $route['who-are-we'] = 'Front_home/who_are_we';
// $route['benifits'] = 'Front_home/benifits';
//add Link by unnati end

// Login
// $route['login'] = 'Front_login/index';
$route['check-login'] = 'Front_login/check_login';
$route['sign-up'] = 'Front_login/sign_up';
// $route['front-logout'] = 'Front_login/logout';
$route['logout'] = 'Front_login/logout';

//reset password
$route['reset/(:any)'] = 'Front_login/sent_mail/$1';
// update pwd
$route['new-password'] = 'Front_login/update_pwd';

//forgot-password
$route['forgot-password'] = 'Forgot_password/index';
$route['forgot-password-email'] = 'Forgot_password/forgot_pwd_post';

// admin route

// if ($route['dashboard']) {
// 	redirect('dashboard-new');
// }

$route['dashboard'] = 'Dashboard';
$route['dashboard-new'] = 'Dashboard_new/index';
$route['get_chart_get'] = 'Dashboard_new/chart_counts';
$route['get_chart_all_order'] = 'Dashboard_new/all_order_chart';
$route['get_cod_chart'] = 'Dashboard_new/cod_chart';
// $route['daily-shiplment-list'] = 'Dashboard/daily_shipments_count_table';
// $route['logout'] = 'Dashboard/logout';

// Profile
$route['profile'] = 'Profile/index';
$route['manage-my-profile'] = 'Profile/manage_my_profile';
// Wallet
$route['wallet-transaction'] = 'Wallet/index';
$route['loadwallat'] = 'Wallet/loadwallat_transaction';
$route['wallet-reinsertcharge'] = 'Wallet/insert_wallet_recharge';
$route['customer-allow-credit'] = 'Customercredit_controller/index';
$route['customer-update-allow-credit'] = 'Customercredit_controller/customer_update_allow_credit';
$route['user-wallet-balance'] = 'Customercredit_controller/user_wallet_balance';
$route['update-wallet-balance'] = 'Customercredit_controller/update_wallet_transaction_for_user';
$route['customer-credit-table'] = 'Customercredit_controller/get_customer_credit';

//price module routes

//load add logistic page
$route['manage-logistic'] = "Logistic/index";
//Insert Logistic
$route['manage-logistic/add-logistic'] = "Logistic/addlogistic";
//logistics list
$route['loadlogistic'] = 'Logistic/loadlogistics';
//Rule form route
$route['manage-logistic/add-rule'] = "Logistic/rules";
//rule insert
$route['manage-logistic/insert-rule'] = "Logistic/addrule";
$route['manage-logistic/change_status/(:num)'] = "Logistic/change_status";
$route['manage-rule/change_status/(:num)'] = "Logistic/change_rule_status";
//rule list table
$route['loadrule'] = "Logistic/rulelist";

$route['import-logistic'] = 'Logistic/import_logistic';

//manage single shipping price
$route['shipping-price'] = "Price/index";
$route['manage-price'] = 'Price/manage_price';
$route['manage-price/add-single-shipping-price'] = "Price/add_single_price";
$route['loadshipprice'] = 'Price/loadshipprice';
$route['delete-shipping-price/(:num)'] = 'Price/delete_shipping_price/$1';
$route['edit-shipping-price'] = 'Price/edit_shipping_price';
$route['add-price'] = 'Price/insert_price_data';

//assign lable to user
$route['assign-lable'] = "Manage_customer/lable";
$route['assign_label_user'] = "Manage_customer/label_assign";
$route['assign_awb_list/(:num)'] = 'Assign_awb/get_awb_data/$1';

$route['invoice/(:any)'] = "Invoice/genrate_pdf/$1";


//webhook
$route['airwaybill-update'] = 'Webhook/index';

// manage pickup-address
$route['pickup-address'] = "Pickup_address/index";

//rule list table
$route['pickup_address_load'] = "Pickup_address/pickup_add_load";
$route['create-pickup-address'] = "Pickup_address/create_pickup_address";
$route['add-pickup-address'] = "Pickup_address/add_pickup_address";
$route['delete-pickup-address/(:any)'] = "Pickup_address/delete_pickup_address/$1";

// Logistic priority form
$route['logistic-priority'] = "Logistic_priority/index";
$route['loadlogistics_priority'] = 'Logistic_priority/loadlogistics_priority';
$route['add-logistic-priority'] = "Logistic_priority/addlogistic_priority";
$route['logistic-priority/delete/(:num)'] = "Logistic_priority/deletepriority/$1";

//create single order
$route['create-single-order'] = 'Order/index';
// $route['create-single-order'] = 'Order/Create_single_order';
$route['create-single-order/add-order'] = 'Order/add_order';

//create single order for pre airwaybill number
$route['create-single-order-awbno'] = "Orderawb/index";
$route['insert_single_order_awbno'] = "Orderawb/insert_single_order_awb";

$route['manage-metrocity'] = 'Metrocity/index';
$route['manage-metrocity/add-metrocity'] = 'Metrocity/add_metrocity';
$route['metrocity_list'] = 'Metrocity/metrocity_list';
$route['manage-metrocity/delete/(:num)'] = "Metrocity/deletemetrocity/$1";
$route['manage-metrocity/status/(:num)'] = "Metrocity/change_user_status/$1";

// Kyc verification
$route['kyc-verification'] = "Kyc_verification/kyc_verification_index";
$route['add-kyc-verification'] = "Kyc_verification/insert_kyc";
$route['approve-pending'] = 'Kyc_verification/approve_pending';

// manage customer
$route['kyc-pending-customer'] = "Manage_customer/manage_customer_index";
$route['customer-list'] = 'Manage_customer/view_customer_list';
$route['list-customer'] = 'Manage_customer/view_customer_table';

// pending customer table
$route['manage-customer/change_status/(:num)'] = "Manage_customer/change_status";
$route['kyc_pending_customer_table'] = 'Manage_customer/kyc_pending_customer_list';
// $route['kyc_pending_cust_table'] = "Manage_customer/kyc_pending_customer_list";
$route['view-customer/(:any)'] = "Manage_customer/view_pending_customer/$1";
$route['approve-customer'] = 'Manage_customer/manage_approved_customer';
$route['approve_customer_table'] = 'Manage_customer/approved_customer_list';
$route['rejected-customer'] = 'Manage_customer/manage_rejected_customer';
$route['rejected_customer_table'] = 'Manage_customer/approved_rejected_list';
$route['update-kyc'] = "Manage_customer/update_kyc";
$route['customer-pre-awb'] = "Manage_customer/pre_awb_dashboard_list";
// customer api settings
$route['customer-api-setting'] = 'Customer_api_setting/index';
$route['customer-pre-awb-list'] = 'Manage_customer/pre_awb_dashboard_data';
//manage users
$route['manage-user'] = "Manage_user/index";
$route['add-user'] = "Manage_user/add_user";
$route['user-list'] = "Manage_user/user_list";
$route['manage-user/change_status/(:num)'] = "Manage_user/change_user_status/$1";
$route['manage-user/edit/(:num)'] = "Manage_user/user_profile/$1";
$route['manage-customer-dashboard/change_status/(:num)'] = "Manage_customer/chage_status/$1";

//import pincode
$route['import-pincode'] = "Pincode_import/index";
$route['insert-pincode'] = "Pincode_import/insert_pincode";

//Import Airway Bill
$route['airway-bill'] = "Import_airway_bill/import_airway_index";
$route['insert_airway_bill'] = "Import_airway_bill/import_airway_bill";

//Bulk order Create
$route['bulk-order'] = "Create_bulk_order/index";
$route['bulk-order-sample-download'] = "Create_bulk_order/bulk_order_sample_excel_download";
$route['create-bulk-order'] = "Create_bulk_order/excel_import_bulk_order";
// $route['data-display'] = "Create_bulk_order/bulk_order_display";

//Delete Orders
$route['delete-order'] = "Delete_order/index";
$route['delete-all-error-order'] = "Create_bulk_order/delete_all_error_order";
$route['delete-pre-order'] = "Delete_pre_order/index";
$route['refund-created-order/(:num)'] = "Delete_order/refund_order/$1";
//extra
$route['get-city-state-from-pincode'] = 'kyc_verification/get_city_state';
$route['flood'] = 'flood/flood_table';
$route['flood/(:any)/(:any)'] = 'flood/flood_table/$1/$2';

//cod Remitals route
$route['cod-available-list'] = 'Codremittance/cod_available_list';
$route['cod-available-ajax-get-list'] = 'Codremittance/cod_available_ajax_get_list';
$route['update-cod-available-order-list'] = 'Codremittance/update_cod_available_order_list';
$route['cod-remittance-list'] = 'Codremittance/cod_remittance_list';
$route['cod-remittance-ajax-get-list'] = 'Codremittance/cod_remittance_ajax_get_list';
$route['add-cod-remittance'] = 'Codremittance/add_cod_remittance';
$route['export-cod-remmitance-data'] = 'Codremittance/export_cod_remmitance_data';
$route['all-cod-remittance-list'] = 'Codremittance/all_cod_remittance_list';
$route['all-cod-remittance-ajax-get-list'] = 'Codremittance/all_cod_remittance_ajax_get_list';
$route['cod-remittance-order-detail-info'] = 'Codremittance/cod_remittance_order_detail_info';
$route['next-cod-remittance-list'] = 'Codremittance/next_cod_remittance_list';
$route['insert-cod-remmitance-data'] = 'Codremittance/insert_cod_remittance_list';
$route['next-cod-remittance-all-data'] = 'Codremittance/next_cod_remittance_all_list';
$route['delete-cod-remmitance-data'] = 'Codremittance/delete_cod_remittance_list';

//new cod remitance 
$route['view-remittance'] = 'Codremittance/view_remittance';
$route['cod-remittance'] = 'Codremittance_new/index';

$route['cod-remittance-cron'] = 'Codremittance_cron/calculate_cod_remittance';
//pre airway bill
$route['pre-bulk-order-awb'] = 'Orderawb/bulk_order_awb';
$route['insert-pre-bulk-order'] = 'Orderawb/create_pre_airway_bill';
$route['delete-pre-bulk-order/(:any)'] = 'Orderawb/delete_bulk_order/$1';

//data table of bulk order Awb
$route['pre_awb_data'] = "Orderawb/bulk_order_awb_data";

$route['chnage_flag_by_cronjob_data'] = 'Orderawb/chnage_flag_by_cronjob';

//data table of bulk order
$route['bulk_order_data'] = 'Create_bulk_order/bulk_order_data';
//sample of excel
$route['awb_pre_order_sample'] = 'Orderawb/awb_pre_order_sample_downlaod';
$route['order_number_pre_bulk_order'] = 'Orderawb/order_number_get_pre_bulk_order';

$route['simple_order_number_bulk_order'] = 'Create_bulk_order/simple_bulk_order_create';
$route['delete-simple-bulk-order/(:any)'] = 'Create_bulk_order/delete_simple_bulk_order/$1';
$route['get-shipping-charge'] = 'Orderawb/get_shipping_charge';

// Order List
$route['onprocess-order-list-new'] = 'Order_list/test_table';
// $route['onprocessOrderList'] = 'Order_list/onprocess_order_list_view';
$route['onprocess-order-list'] = 'Order_list/onprocess_order_list_table';
$route['onprocessOrderList'] = 'Order_list/onprocess_order_list_view';
$route['view-order'] = 'Order_list/index';
$route['order-list'] = 'Order_list/order_list_table';
$route['created-order-list'] = 'Order_list/created_order_table';
$route['createdOrderList'] = 'Order_list/createdorder_list_view';
$route['ofp-Order-List'] = 'Order_list/ofp_order_list';
$route['ofpOrderList'] = 'Order_list/ofp_order_table';
$route['notpicked-Order-List'] = 'Order_list/notpicked_order_list';
$route['notpickedOrderList'] = 'Order_list/notpicked_order_table';
$route['IntransitOrderList'] = 'Order_list/intransit_order_table';
$route['Intransit-Order-List'] = 'Order_list/intransit_order_list';
$route['ofd-Order-List'] = 'Order_list/ofd_order_list';
$route['ofdOrderList'] = 'Order_list/ofd_order_table';
$route['ndr-Order-List'] = 'Order_list/ndr_order_list';
$route['ndrOrderList'] = 'Order_list/ndr_order_table';
$route['delivered-Order-List'] = 'Order_list/delivered_order_list';
$route['deliveredOrderList'] = 'Order_list/delivered_order_table';
$route['rto-intransit-Order-List'] = 'Order_list/rtoIntransit_order_list';
$route['rtoIntransitOrderList'] = 'Order_list/rtoIntransit_order_table';
$route['rto-delivered-Order-List'] = 'Order_list/rtodelivered_order_list';
$route['rtoDeliveredOrderList'] = 'Order_list/rtodelivered_order_table';
$route['insert-ndr-comments'] = 'Order_list/insert_ndr_comment';
$route['error-order-list'] = 'Order_list/errororder_list_view';
$route['errorOrderList'] = 'Order_list/error_order_table';
$route['waiting-order-list'] = 'Order_list/waitingorder_list_view';
$route['waitingOrderList'] = 'Order_list/waiting_order_table';
$route['lost-Order-List'] = 'Order_list/lostorder_list_view';
$route['lostOrderList'] = 'Order_list/lost_order_table';

$route['packing-slip-first/(:num)'] = 'Order_list/packing_slip/$1';
$route['packing-slip-second/(:num)'] = 'Order_list/new_single_packing_slip/$1';
$route['packing-slip-third/(:num)'] = 'Order_list/third_single_packing_slip/$1';
$route['packing-slip-forth/(:num)'] = 'Order_list/forth_single_packing_slip/$1';
$route['packing-slip-fifth/(:num)'] = 'Order_list/fifth_single_packing_slip/$1';
$route['packing-slip-sixth/(:num)'] = 'Order_list/packing_slip_logo/$1';
$route['packing-slip-seventh/(:num)'] = 'Order_list/new_single_packing_slip_logo/$1';
$route['packing-slip-eighth/(:num)'] = 'Order_list/third_single_packing_slip_logo/$1';
$route['packing-slip-nineth/(:num)'] = 'Order_list/forth_single_packing_slip_logo/$1';
$route['packing-slip-tenth/(:num)'] = 'Order_list/fifth_single_packing_slip_logo/$1';

//delete error order
$route['delete-error-order/(:num)'] = "Order_list/delete_error_order/$1";


//delete created Order
$route['delete-created-order/(:num)'] = "Order_list/delete_created_order/$1";
$route['refund_all_orders'] = "Delete_order/refund_all_orders";

//manifest
$route['multiple-menifest-slip'] = 'Order_list/multiple_manifest';
$route['multiple_print'] = 'Order_list/multiple_packing_slip';

//preawb order list
$route['Pre-awb-onprocess-order-list'] = 'Pre_awb_Order_list/pre_awb_onprocess_order_list_view';
$route['Pre-awb-onprocessOrderList'] = 'Pre_awb_Order_list/pre_awb_onprocess_order_list_table';
$route['Pre-awb-view-order'] = 'Pre_awb_Order_list/index';
$route['Pre-awb-order-list'] = 'Pre_awb_Order_list/pre_awb_order_list_table';
$route['Pre-awb-created-order-list'] = 'Pre_awb_Order_list/pre_awb_createdorder_list_view';
$route['Pre-awb-createdOrderList'] = 'Pre_awb_Order_list/pre_awb_created_order_table';
$route['Pre-awb-Intransit-Order-List'] = 'Pre_awb_Order_list/pre_awb_intransit_order_list';
$route['Pre-awb-IntransitOrderList'] = 'Pre_awb_Order_list/pre_awb_intransit_order_table';
$route['Pre-awb-ofd-Order-List'] = 'Pre_awb_Order_list/pre_awb_ofd_order_list';
$route['Pre-awb-ofdOrderList'] = 'Pre_awb_Order_list/pre_awb_ofd_order_table';
$route['Pre-awb-ndr-Order-List'] = 'Pre_awb_Order_list/pre_awb_ndr_order_list';
$route['Pre-awb-ndrOrderList'] = 'Pre_awb_Order_list/pre_awb_ndr_order_table';
$route['Pre-awb-delivered-Order-List'] = 'Pre_awb_Order_list/pre_awb_delivered_order_list';
$route['Pre-awb-deliveredOrderList'] = 'Pre_awb_Order_list/pre_awb_delivered_order_table';
$route['Pre-awb-rto-intransit-Order-List'] = 'Pre_awb_Order_list/pre_awb_rtoIntransit_order_list';
$route['Pre-awb-rtoIntransitOrderList'] = 'Pre_awb_Order_list/pre_awb_rtoIntransit_order_table';
$route['Pre-awb-rto-delivered-Order-List'] = 'Pre_awb_Order_list/pre_awb_rtodelivered_order_list';
$route['Pre-awb-rtoDeliveredOrderList'] = 'Pre_awb_Order_list/pre_awb_rtodelivered_order_table';
$route['Pre-awb-error-order-list'] = 'Pre_awb_Order_list/pre_awb_error_order_list_view';
$route['Pre-awb-errorOrderList'] = 'Pre_awb_Order_list/pre_awb_error_order_list_table';

$route['Pre-awb-waiting-order-list'] = 'Pre_awb_Order_list/pre_awb_waiting_order_list_view';
$route['Pre-awb-waitingOrderList'] = 'Pre_awb_Order_list/pre_awb_waiting_order_list_table';

//assing awb to customer
$route['assign_airwaybill'] = "Assign_awb/index";
$route['get_airwaybill'] = "Assign_awb/get_awb_table";
$route['assign_awb_list/(:num)'] = 'Assign_awb/get_awb_data/$1';


$route['generate-awb'] = 'Zship_awb/index';
$route['refrash-token'] = 'Zship_refrash_token/refrash_token';


//pincode-serviceability 
$route['pincode-serviceability'] = 'Pincode_serviceability/index';
//xpressbess awb
$route['genrate-awb-xpress'] = 'Xpress_awb/index';
$route['genrate-awb-xpressair'] = 'Xpress_awb/index_air';

$route['airwaybill-update'] = 'Webhook/index';
$route['order-tracking'] = 'Zedship_cron/tracking_cron';
$route['assign_awb_list/(:num)'] = 'Assign_awb/get_awb_data/$1';



//import ndr report
$route['import-ndr-report'] = 'Ndr_report/import_ndr_report';
$route['import-ndr-excel-download'] = 'Ndr_report/import_ndr_excel_download';
$route['import-ndr-report-airwaybill-number'] = 'Ndr_report/import_ndr_report_airwaybill_number';

//reports
$route['daily-booking-report'] = 'Daily_booking_reports/booking_report_view';
$route['daily-booking-data'] = 'Daily_booking_reports/daily_booking_data';
$route['intransit-booking-report'] = 'Daily_booking_reports/intrasit_report';
$route['delivery-booking-report'] = 'Daily_booking_reports/delivery_report';
$route['rto-booking-report'] = 'Daily_booking_reports/rto_report';
$route['cod-booking-report'] = 'Daily_booking_reports/cod_report';
$route['ndr-booking-report'] = 'Daily_booking_reports/ndr_report';
$route['all-booking-report'] = 'Daily_booking_reports/all_report';



//Udaan Express AWB generate
$route['udaan-generate-awb'] = 'Udaan_awb/index';
$route['generate-new-udaan-awb'] = 'Udaan_awb/generate_new_udaan_awb';

//Custom api or webhook
$route['shopify-webhook-data'] = 'Custom_webhook_or_api/shopify_webhook_data';



// Ecom AWB generate
$route['ecom-generate-awb'] = 'Ecom_awb/index';

//tracking webhook 
$route['get-xpressbees-tracking-detail'] = 'Tracking_webhook/get_xpressbees_tracking_detail';
$route['get-delhivery-tracking-detail'] = "Tracking_webhook/get_delhivery_tracking_detail";
$route['get-delhivery-express-tracking-detail'] = "Trackingwebhook_controller/get_delhivery_tracking_detail";
$route['ecom-tracking'] = 'Tracking_webhook/ecom_tracking_webhook';
$route['get-udaan-tracking-detail'] = 'Tracking_webhook/udaan_tracking_webhook';
$route['ekart-tracking'] = 'Tracking_webhook/ekart_tracking_webhook';
$route['ssl-tracking'] = 'Tracking_webhook/ship_rocket_webhook';

//new cod remitance
$route['cod-remittance'] = 'Codremittance_new/index';
$route['cod-shipping-charges'] = 'Codremittance_new/cod_shipping_charges';
$route['cod-wallet-transactions'] = 'Codremittance_new/cod_wallet_transactions';
$route['cod-bill-summary'] = 'Codremittance_new/cod_bill_summary';
$route['cod-credit-receipt'] = 'Codremittance_new/cod_credit_receipt';
//$route['view-remittance'] = 'Codremittance/view_remittance';
//customer used credit
$route['customer-used-credit'] = 'Customercredit_controller/used_credit_list';
$route['customer-used-credit-table'] = 'Customercredit_controller/customer_used_credit_table';

$route['generate-pincode-ecom'] = "pincode_import/genrate_pincode";

$route['pre-airwaybill-create-order'] = 'Custom_webhook_or_api/custom_pre_airwaybill_create_order_api';
$route['api-pickup-address-creation'] = 'Custom_webhook_or_api/custom_api_add_pickup_address';
$route['api-order-creation'] = 'Custom_webhook_or_api/custom_api_create_order';
$route['get-api-order-trackdetail'] = 'Custom_webhook_or_api/get_api_order_trackdetail';
$route['plan'] = 'Plan/index';
$route['rate-calculator'] = 'Rate/index';

//weight missmatch
$route['weight-missmatch'] = 'Weight_missmatch/index';
$route['import-weightmissmatch'] = 'Weight_missmatch/import_weight_exel';
$route['weight-missmatch-list'] = "Weight_missmatch/weightmissmatch";
$route['get_missmatch_data'] = "Weight_missmatch/get_missmatch_data";


$route['clear-stuck'] = "Bug_fixer/clear_bulk";
$route['bulk-cleared'] = "Bug_fixer/clear_bulk_stuck";

//reorder_route
$route['reorder-error-order/(:num)'] = 'Reorder/index/$1';

$route['404_override'] = "";
$route['translate_uri_dashes'] = false;
