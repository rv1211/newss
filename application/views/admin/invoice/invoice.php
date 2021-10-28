<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>A simple, clean, and responsive HTML invoice template</title>

    <style>
        .table {
            /* font-family: arial, sans-serif; */
            border-collapse: collapse;
            width: 100%;
        }

        .td,
        .th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        .tr:nth-child(even) {
            background-color: #dddddd;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            /* padding: 30px; */
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }

        .new {
            text-align: left;
            float: left;
            margin-left: 250px
        }

        b {
            padding: 0%;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title" width="35%">
                                <?php $path = 'uploads/logo.png';
                                $type = pathinfo($path, PATHINFO_EXTENSION);
                                $file_data = file_get_contents($path);
                                $base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
                                ?>
                                <img src=<?= $base64_img; ?> style="width: 100%; max-width: 200px" />
                            </td>
                            <td style="text-align:left;" width="15%">
                                <h1>INVOICE</h1>
                            </td>
                            <td style="font-size:18px; text-align:right; padding-top:20px;" width="35%">
                                Created: <?= date('d-M-Y', strtotime($invoice_date)); ?> <br />
                                <!-- Due: February 1, 2015 -->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td width="50%">
                                <b>Pack And Drop Logistic </b> <br>
                                1 Clement Residency, <br>
                                Opp Stell Petrol Pump, <br>
                                Vasai West Mumbai -401202
                            </td>
                            <td class="new">
                                <b> <?= $sender_data['warehouse_name']; ?> </b> <br>
                                <?= $sender_data['name']; ?><br />
                                <?= $sender_data['email']; ?><br />
                                <?= word_wrap($sender_data['address_line_1'], 15, "<br>\n"); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Item</td>
                <td>Price</td>
            </tr>

            <tr class="item">
                <td> <?= $order_count; ?> Shipments</td>
                <td>Total Cost : &#8377; <?= round($nontaxamount, 2); ?></td>
            </tr>

            <?php if ($sender_data['state'] == 'MH') : ?>
                <tr class="total">
                    <td></td>
                    <td> CGST (9%) : &#8377; <?= round($cgst, 2); ?> </td>
                </tr>
                <tr class="total">
                    <td></td>
                    <td> SGST (9%) : &#8377; <?= round($sgst, 2); ?> </td>
                </tr>
            <?php else : ?>
                <tr class="total">
                    <td></td>
                    <td> IGST (18%) : &#8377; <?= round($sgst, 2) + round($cgst, 2); ?> </td>
                </tr>
            <?php endif; ?>
            <tr class="total">
                <td></td>
                <td> Total : &#8377; <?= round($Total, 2); ?> </td>
            </tr>
            <tr class="heading" style="text-align:center;">
                <td colspan="2"> Wallet Transaction</td>
            </tr>
            <tr class=" heading">
                <table class="table">
                    <tr class=" heading tr">
                        <th class="th" style="text-align:center;" width="25%"> Remarks</th>
                        <th class="th" style="text-align:center;" width="5%">Debit</th>
                        <th class="th" style="text-align:center;" width="5%">Credit</th>
                        <th class="th" style="text-align:center;" width="15%"> Balance</th>
                        <th class="th" style="text-align:center;" width="20%">Date </th>
                    </tr>
                    <?php
                    $count = 0;
                    foreach ($wallet_data as $transaction) :
                        if ($count == 10) {
                            break;
                        } ?>
                        <tr class="details tr" style="">
                            <td class="td"><?= $transaction['remarks']; ?></td>
                            <td class="td" style="text-align:center;"><?= $transaction['debit']; ?></td>
                            <td class="td" style="text-align:center;"><?= $transaction['credit']; ?></td>
                            <td class="td" style="text-align:center;"> <?= $transaction['runningbalance']; ?></td>
                            <td class="td"> <?= $transaction['created_date']; ?> </td>
                        </tr>
                    <?php $count++;
                    endforeach;
                    ?>
                </table>
            </tr>
        </table>
    </div>
</body>

</html>