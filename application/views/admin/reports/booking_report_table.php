<div class="example-wrap">
    <div class="example">
        <table class="table table-hover border booking_table" id="daily_booking_report">
            <thead>
                <tr>
                    <th>User Name</th>
                    <?php foreach ($logistic_name12 as $key => $value) { ?>
                        <th><?php echo $value; ?></th>
                    <?php }  ?>
                </tr>
            </thead>
            <tbody id="daily_booking_report">
                <?php foreach ($get_booking_data as $get_booking_data_value) { ?>
                    <tr>
                        <td><?= $get_booking_data_value['sender_name'] ?></td>
                        <?php foreach ($logistic_name12 as $value) { ?>
                            <td>
                                <?php //foreach ($get_booking_data_value['logistic_name'] as $key => $value1) { 
                                ?>
                                <?php if (in_array($value, $get_booking_data_value['logistic_name'])) { ?>
                                    <?= $get_booking_data_value[$value]['count'] ?>
                                <?php  } else {
                                    echo "0";
                                }  ?>

                            </td>
                        <?php  } //}  
                        ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>