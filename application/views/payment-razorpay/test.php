<?php
namespace Razorpay\Api;
include "Razorpay.php";
$api = new Api("rzp_test_Vjrz6ytqXBX2Up", "FhCajeMFa3hZHNm14ENtpd7g");
/*$order  = $api->order->create(array('receipt' => '123', 'amount' => 100, 'currency' => 'INR')); // Creates order
echo '<pre>';
print_r($order);*/
//$orderid = $order['id'];
$orderid = "order_DlhOjhXtNFCCqF";
?>
<style type="text/css">
    .razorpay-payment-button{

    }
</style>
<form action="payment-razorpay/purchase.php" method="POST">
<script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="rzp_test_Vjrz6ytqXBX2Up" // Enter the Key ID generated from the Dashboard
    data-amount="5" // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise or INR 500.
    data-currency="INR"
    data-order_id="<?php echo $orderid; ?>"//This is a sample Order ID. Create an Order using Orders API. (https://razorpay.com/docs/payment-gateway/orders/integration/#step-1-create-an-order)
    data-buttontext="Pay with Razorpay"
    data-name="Acme Corp"
    data-description="A Wild Sheep Chase is the third novel by Japanese author Haruki Murakami"
    data-image="http://sphilic.com/uploads/favicon.png"
    data-prefill.name="Mital Patel"
    data-prefill.email="mital.patel58@gmail.com"
    data-prefill.contact="7878050118"
    data-theme.color="#00b16a"
></script>
<input type="hidden" custom="Hidden Element" name="hidden">
</form>