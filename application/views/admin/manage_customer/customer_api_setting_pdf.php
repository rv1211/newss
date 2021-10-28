<!DOCTYPE html>
<html>

<head>
    <style type="text/css">
    .border-div {
        font-size: 16px;
        color: #000000 !important;
        margin-top: 0px;
        padding-top: 0px;
    }

    body {
        font-family: Calibri !important;
    }

    .border-bottom {
        border-bottom: 2px solid;
    }

    .border-right {
        border-right: 2px solid;
    }

    .barcode-img {
        width: 100%;
    }

    .text-center {
        text-align: center;
    }

    .text-left {
        text-align: left;
    }

    .text-right {
        text-align: right;
    }

    .border-div table td {
        padding: 10px 25px;
        margin-top: 0px;
    }

    .border-div table {
        width: 100%;
        margin: 0 auto;
        border: 1px solid;
    }

    .border-div strong {
        font-weight: bolder;
    }

    .small-text {
        font-size: 12px
    }

    .border-red-bottom {
        border-bottom: 2px solid #c82727;
    }

    table {
        page-break-after: auto;
    }

    span {
        color: #f10c0c !important;
        font-size: 14px;
        text-align: center;
    }
    </style>
    <title></title>
</head>

<body>
    <div class="page-container">
        <div class="border-div wrapper-page">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td width="25%"><strong>Customer :</strong></td>
                    <td><?php echo $customer_name; ?></td>
                </tr>
                <tr>
                    <td><strong>Pickup Address :</strong></td>
                    <td><?php echo $pickup_address; ?></td>
                </tr>
                <tr>
                    <td><strong>Web Access :</strong></td>
                    <td><?php if ($api_is_web_access == 1) {echo "True";} else {echo "False";}?></td>
                </tr>
                <tr>
                    <td><strong>Api Key :</strong></td>
                    <td><?php echo $api_key; ?></td>
                </tr>
                <tr>
                    <td><strong>User Id :</strong></td>
                    <td><?php echo $api_user_id; ?></td>
                </tr>
            </table>
            <span>Note: Request - Need to pass base64encode() & Response - Need to pass base64decode()</span>
        </div>
    </div>
</body>

</html>