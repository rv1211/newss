<!DOCTYPE html>
<html>
<head>
    <title>Cefiro Invoice</title>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="content-type" content="text-html; charset=utf-8">
    <style type="text/css">
        @page {margin-left: 2mm;margin-top: 8mm;margin-right: 2mm;margin-bottom: 0mm;}
        html, body, div, span, applet, object, iframe,h1, h2, h3, h4, h5, h6, p, blockquote, pre,a, abbr, acronym, address, big, cite, code,del, dfn, em, img, ins, kbd, q, s, samp,small, strike, strong, sub, sup, tt, var,b, u, i, center,dl, dt, dd, ol, ul, li,fieldset, form, label, legend,table, caption, tbody, tfoot, thead, tr, th, td,article, aside, canvas, details, embed,figure, figcaption, footer, header, hgroup,menu, nav, output, ruby, section, summary,time, mark, audio, video {margin: 0;padding: 0;font: inherit;font-size: 100%;vertical-align: baseline;}
        table {border-collapse: collapse;border-spacing: 0;}
        caption, th, td {text-align: left;font-weight: normal;vertical-align: middle;}
        body {font-family: 'Source Sans Pro', sans-serif;font-weight: 300;font-size: 14px;margin: 0;padding: 0;color: #000;}
        body a {text-decoration: none;color: inherit;}
        body a:hover {color: inherit;opacity: 0.7;}
        body .container {min-width: 460px;margin: 0 auto;padding: 0 20px;}
        body .clearfix:after {content: "";display: table;clear: both;}
        body .left {float: left;}
        body .right {float: right;}
        body .helper {display: inline-block;height: 100%;vertical-align: middle;}
        body .no-break {page-break-inside: avoid;}
        header {margin-top: 15px;margin-bottom: 10px;}
        header figure {width: 56%;float: left;margin-right: 10px;}
        header .company-info {width: 44%;float: right;color: #000;line-height: 14px;margin-right: -50px;}
        header .company-info .address {margin-top: 20px;margin-left: 90px;}
        header .company-info .address table {border: 1px solid #000;}
        header .company-info .address table tr td {border: 2px solid #000;padding: 10px 25px;text-align: center;font-size: 24px;}
        header .company-info .address .ad_dt,header .company-info .address .ad_tr {margin-bottom: 10px;}
        header .company-info .address, header .company-info .phone, header .company-info .email {position: relative;}
        header .company-info .address img, header .company-info .phone img {margin-top: 2px;}
        header .company-info .title {text-align: right;color: #198BFF;font-weight: bold;font-size: 2.4em;}
        section .details {min-width: 440px;margin-bottom: 5px;padding: 5px 10px;color: #000;}
        section .details .client {float: left;width: 40%;}
        section .details .data {float: right;width: 40%;}
        section .details .client table,section .details .data table {border: 1px solid #000;font-size: 14px;}
        section .details .client table tr td,section .details .data table tr td {border: 1px solid #000;padding: 5px 5px;}
        section .details .client .name, section .details .data .name {font-size: 1.16666666666667em;font-weight: 600;}
        section .details .title {margin-bottom: 5px;font-size: 1.33333333333333em;text-transform: uppercase;}
        section table {width: 100%;margin-bottom: 5px;table-layout: fixed;border-collapse: collapse;/*border-spacing: 0;*/}
        section table .unit, section table .total {width: 18%;}
        section table .qty {width: 12%;}
        .capital {font-size: 17px;font-weight: 600;color: #000;}
        section table .itm {width: 12%;}
        section table .desc {width: 64%;}
        section table thead {display: table-header-group;vertical-align: middle;border-color: inherit;}
        section table thead th {padding: 7px 10px;border-right: 1px solid #000;color: #000;text-align: center;font-weight: 400;text-transform: uppercase;border-top: 1px solid #000;border-bottom: 1px solid #000;}
        section table.invData thead th:nth-child(4) {border-right: 1px solid #000;}
        section table.invData thead th:nth-child(1) {border-left: 1px solid #000;}
        section table.invData tbody td:nth-child(1) {border-left: 1px solid #000;}
        section table.invData tbody tr:nth-child(n) td {border-bottom: 1px solid #000;}
        section table.items tbody {background: yellow;height: 500%;}
        section table.items thead th:nth-child(1) {border-left: 1px solid #000;}
        section table.items tbody td:nth-child(1) {border-left: 1px solid #000;}
        section table.items tbody tr:nth-child(<?php echo count(@$dataItemList) + 2; ?>) td {border-bottom: 1px solid #000;}
        section table.items tbody tr:nth-child(<?php echo count(@$dataItemList); ?>) td {<?php
if (count(@$dataItemList) == 1) {echo "padding-bottom: 320px;";} elseif (count(@$dataItemList) == 2) {echo "padding-bottom: 309px;";} elseif (count(@$dataItemList) == 3) {echo "padding-bottom: 300px;";} elseif (count(@$dataItemList) == 4) {echo "padding-bottom: 260px;";} elseif (count(@$dataItemList) == 5) {echo "padding-bottom: 240px;";} elseif (count(@$dataItemList) == 6) {echo "padding-bottom: 220x;";} elseif (count(@$dataItemList) == 7) {echo "padding-bottom: 180px;";} elseif (count(@$dataItemList) == 8) {echo "padding-bottom:140px;";} elseif (count(@$dataItemList) == 9) {echo "padding-bottom: 120px;";} elseif (count(@$dataItemList) == 10) {echo "padding-bottom: 100px;";} elseif (count(@$dataItemList) == 11) {echo "padding-bottom: 80px;";} elseif (count(@$dataItemList) == 12) {echo "padding-bottom: 60px;";} elseif (count(@$dataItemList) == 13) {echo "padding-bottom: 40px;";} elseif (count(@$dataItemList) == 14) {echo "padding-bottom: 20px;";} elseif (count(@$dataItemList) == 15) {echo "padding-bottom: 10px;";} elseif (count(@$dataItemList) == 16) {echo "padding-bottom: 10px;";} elseif (count(@$dataItemList) == 17) {echo "padding-bottom: 10px;";} elseif (count(@$dataItemList) == 18) {echo "padding-bottom: 0px;";}
?>}
        section table tbody td {padding: 2px 10px;text-align: center;border-right: 1px solid #000;}
        section table tbody td.desc {text-align: left;}
        section table tbody td.total {color: #000;font-weight: 600;text-align: right;}
        .owner-info {page-break-inside: avoid;}
        .owner-info table {width: 60%;margin-top: -130px;margin-left: 10px;}
        .owner-info table td {padding: 8px 10px;border: 1px solid;font-size: 14px;text-align: center;}
        footer {margin-bottom: 0;padding: 0;}
        footer table {width: 100%;margin-top: -5px;table-layout: fixed;border-collapse: collapse;}
        footer table tbody td {padding: 10px 10px;font-size: 14px;}
        footer table tbody td.text-right {text-align: right;}
        footer table tbody td:nth-child(1) {border-left: 1px solid #000;}
        footer table tbody td:nth-child(5) {border-right: 1px solid #000;}
        footer table tbody tr td.gstax {border-bottom: 1px solid #000;}
        footer table tbody tr.tottax td {border-bottom: 1px solid #000;}
        footer table tbody tr.owner-acc td {border-bottom: 1px solid #000;}
        footer table tbody tr.owner-acc td.gsatax,footer table tbody tr.owner-acc td.qstax {font-size: 18px;text-align: center;}
        footer table tbody tr td.grand-total {border-left: 1px solid #000;color: #198BFF;font-size: 22px;font-weight: bold;text-align: left;}
        footer table tbody td.staxsumr {border-right: 1px solid #000;font-size: 18px;font-weight: bold;text-align: right;color: #198BFF;}
    </style>
</head>
  <body>
    <section>
        <div class="container">
            <div class="details clearfix">
            <div class="client left">
               <p class="name"><?php echo @$CompanyDataList->address1; ?></p>
                <?php if ($CompanyDataList->address2 != ''): ?>
                    <p class="name"><?php echo @$CompanyDataList->address2; ?></p>
                <?php endif;?>
                <p class="name"><?php echo @$CompanyDataList->city; ?> <?php echo @$CompanyDataList->state; ?>, <?php echo @$CompanyDataList->country; ?>
            </div>
        </div>
        <div class="details clearfix">
            <div class="client">
                <table>
                    <tr>
                        <td>Statement To:</td>
                    </tr>
                    <tr>
                        <td>
                            <p><?php echo @$dataBilling[0]['address1']; ?></p>
                            <p><?php echo @$dataBilling[0]['address2']; ?></p>
                            <p><?php echo @$dataBilling[0]['city'] . ' ' . @$dataBilling[0]['state_name'] . ' ' . @$dataBilling[0]['postal_code']; ?></p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="data">
                <table>
                    <tr>
                        <td>Ship To:</td>
                    </tr>
                    <tr>
                        <td>
                            <?php
//if ($dataList['CompanyName'] != "") { ?>
                            <?php //} ?>
                            <p><?php echo @$dataShiping[0]['address1']; ?></p>
                            <p><?php echo @$dataShiping[0]['address2']; ?></p>
                            <p><?php echo @$dataShiping[0]['city'] . ' ' . @$dataShiping[0]['state_name'] . ' ' . @$dataShiping[0]['postal_code']; ?></p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="details clearfix">
            <div class="print_title" style="text-align: center;margin-bottom:10px;">
                <span class="title_printhere">
                    <?php if (!empty($invoice_data)): ?>
                        <?php echo $invoice_data[0]['name']; ?>
                    <?php endif;?>
                </span>
            </div>
            <div class="print_title" style="text-align: center;margin-bottom:10px;">
                <span class="title_printhere"><b><?php echo $company[0]['name']; ?></b></span>
            </div>
            <div class="print_title" style="text-align: center;margin-bottom:10px;">
                <span class="title_printhere">Statement Report</span>
            </div>
            <table border="1" cellspacing="0" cellpadding="0" class="items" style="width:100%;">
                <thead>
                  <tr>
                    <!-- <th>Name</th>
                    <th>Type</th> -->
                    <th>Invoice Date</th>
                    <th>Invoice Num</th>
                    <th>P.O #</th>
                    <th>Due Date</th>
                    <th>Aging Per Day</th>
                    <th>Open Balance</th>
                  </tr>
                </thead>
                <tbody>
                    <?php if (!empty($invoice_data)): ?>
                        <?php $customer_data = array();?>
                        <?php $finalTotal = 0;?>
                        <?php foreach ($invoice_data as $single_invoice_data_data): ?>
                                <tr>
                                    <!-- <td style="padding-top:4px; font-size: 22px; font-weight: 600; color: #000;">
                                        <?php if (in_array($single_invoice_data_data['name'], $customer_data)): ?>
                                            <?php echo ''; ?>
                                        <?php else: ?>
                                            <?php $customer_data[] = $single_invoice_data_data['name'];?>
                                            <?php echo $single_invoice_data_data['name']; ?>
                                        <?php endif;?>
                                    </td>
                                    <td style="padding-top:4px; font-size: 22px; font-weight: 600; color: #000;"> <?php echo $single_invoice_data_data['type']; ?> </td> -->
                                    <td style="padding-top:4px; font-size: 22px; font-weight: 600; color: #000;"><?php echo $single_invoice_data_data['date']; ?>
                                    </td>
                                    <td style="padding-top:4px; font-size: 22px; font-weight: 600; color: #000;"><?php echo $single_invoice_data_data['invoice_num']; ?>

                                    </td>
                                    <td style="padding-top:4px; font-size: 22px; font-weight: 600; color: #000;"><?php echo $single_invoice_data_data['po']; ?>

                                    </td>
                                    <td style="padding-top:4px; font-size: 22px; font-weight: 600; color: #000;"><?php echo $single_invoice_data_data['due_date']; ?>

                                    </td>
                                    <td style="padding-top:4px; font-size: 22px; font-weight: 600; color: #000;"><?php echo $single_invoice_data_data['aging']; ?>

                                    </td>
                                     <td style="padding-top:4px; font-size: 22px; font-weight: 600; color: #000;">
                                    <?php if (@$single_invoice_data_data['balance_remain'] != ''): ?>
                                        <?php if (@$single_invoice_data_data['incoice_type'] == 0): ?>
                                            <?php echo '$' . @$single_invoice_data_data['balance_remain']; ?>
                                            <?php $finalTotal += @$single_invoice_data_data['balance_remain'];?>
                                        <?php else: ?>
                                            <span class="red-label" style="color:#ff0000;">(-<?php echo "$ " . @$single_invoice_data_data['balance_remain']; ?>)</span>
                                            <?php $finalTotal -= @$single_invoice_data_data['balance_remain'];?>
                                        <?php endif;?>
                                    <?php endif?>
                                    </td>
                                </tr>
                        <?php endforeach;?>
                        <tr>
                           <!--  <td style="padding-top:4px; font-size: 22px; font-weight: 600; color: #000;"></td>
                            <td style="padding-top:4px; font-size: 22px; font-weight: 600; color: #000;"></td> -->
                            <td style="padding-top:4px; font-size: 22px; font-weight: 600; color: #000;"></td>
                            <td style="padding-top:4px; font-size: 22px; font-weight: 600; color: #000;"></td>
                            <td style="padding-top:4px; font-size: 22px; font-weight: 600; color: #000;"></td>
                            <td style="padding-top:4px; font-size: 22px; font-weight: 600; color: #000;"></td>
                            <td style="padding-top:4px; font-size: 22px; font-weight: 600; color: #000;">Total</td>
                            <td style="padding-top:4px; font-size: 22px; font-weight: 600; color: #000;"><?php echo '$' . $finalTotal; ?></td>
                        </tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </section>
    <footer> </footer>
  </body>
</html>