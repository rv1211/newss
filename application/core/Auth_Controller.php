<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth_Controller extends CI_Controller
{

    function __construct()

    {
        parent::__construct();
        if (!$this->session->userdata('userId')) {
            redirect('');
        } 
        else{
            $currentUrl = $_SERVER['REQUEST_URI'];
            $page = basename($currentUrl);
            $userType = $this->session->userdata('userType');
            $custArr = array('delete-order', 'customer-list', 'customer-api-setting', 'kyc-pending-customer', 'approve-customer', 'rejected-customer', 'manage-user', 'customer-allow-credit', 'user-wallet-balance', 'customer-used-credit', 'import-pincode', 'airway-bill', 'import-ndr-report', 'generate-pincode-ecom', 'manage-logistic', 'shipping-price', 'manage-price', 'manage-metrocity', 'add-rule', 'generate-awb', 'genrate-awb-xpress', 'assign_airwaybill', 'udaan-generate-awb', 'ecom-generate-awb', 'assign-lable', 'cod-remittance-list', 'all-cod-remittance-list');
            $allArr = array('dashboard', 'create-single-order', 'view-order', 'bulk-order', 'onprocessOrderList', 'createdOrderList', 'Intransit-Order-List', 'ofd-Order-List', 'ndr-Order-List', 'rto-intransit-Order-List', 'delivered-Order-List', 'rto-delivered-Order-List', 'error-order-list', 'waiting-order-list', 'pickup-address', 'logistic-priority', 'daily-booking-report', 'intransit-booking-report', 'delivery-booking-report', 'rto-booking-report', 'cod-booking-report', 'all-booking-report', 'ndr-booking-report', 'pincode-serviceability', 'kyc-verification', 'approve-pending');
            // $adminArr = array('dashboard', 'view-order', 'delete-order', 'onprocessOrderList', 'createdOrderList', 'Intransit-Order-List', 'ofd-Order-List', 'ndr-Order-List', 'rto-intransit-Order-List', 'delivered-Order-List', 'rto-delivered-Order-List', 'error-order-list', 'waiting-order-list', 'customer-list', 'customer-api-setting', 'kyc-pending-customer', 'approve-customer', 'rejected-customer', 'manage-user', 'customer-allow-credit', 'user-wallet-balance', 'customer-used-credit', 'import-pincode', 'airway-bill', 'import-ndr-report', 'generate-pincode-ecom', 'manage-logistic', 'shipping-price', 'manage-price', 'manage-metrocity', 'pickup-address', 'add-rule', 'generate-awb', 'genrate-awb-xpress', 'assign_airwaybill', 'udaan-generate-awb', 'ecom-generate-awb', 'assign-lable', 'daily-booking-report', 'intransit-booking-report', 'delivery-booking-report', 'rto-booking-report', 'cod-booking-report', 'all-booking-report', 'ndr-booking-report', 'cod-remittance-list', 'all-cod-remittance-list', 'pincode-serviceability');
            $adminArr = array('create-single-order', 'bulk-order', 'kyc-verification', 'approve-pending');
            
            // if($userType == '1' && in_array($page, $adminArr)){
            //     echo "allow";
            // } else{
            //     echo "not Allow";
            // }
            // echo $page. "  ".$userType; exit;
            if($userType == '4' && in_array($page, $custArr)){
                redirect('dashboard','refresh');
            }
            if($userType == '1' && in_array($page, $adminArr)){
                redirect('dashboard','refresh');
            }
        }
    }
}
