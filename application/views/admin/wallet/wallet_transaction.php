<div class="page">

    <input type="hidden" name="razorpay_key" id="razorpay_key" value="<?= $this->config->item('RAZORPAY_KEY');  ?>">

    <div class="page-content ">

        <div class="panel">

            <header class="panel-heading">

                <h2 class="panel-title">

                    Your Wallet Amount: Rs.

                    <?= (@$wallet_balance['wallet_balance'] != '') ? (@$wallet_balance['wallet_balance']) : $this->session->userdata('wallet_balance'); ?>

                </h2>

            </header>

            <div class="panel-body">

                <!-- <form action="<?= base_url('wallet-transaction'); ?>" name="wallet_transaction" method="post" class="wallet-transaction"> -->

                <div class="row row-lg">

                    <div class="col-md-12 col-lg-5">

                        <!-- Example Horizontal Form -->

                        <div class="">

                            <h4 class="example-title">Wallet Transaction</h4>

                            <div class="example">

                                <div class="form-group form-material row">

                                    <label class="col-md-2 col-form-label">Amount (Rs.): </label>

                                    <div class="col-md-10">

                                        <input type="text" class="form-control" id="wallet_amount" name="wallet_amount" placeholder="Wallet Amount" autocomplete="off" />

                                        <?php if (!empty($errors)) :  ?>

                                            <label class="error"><?php echo $errors['wallet_amount']; ?> </label>

                                        <?php endif; ?>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- End Example Horizontal Form -->

                    </div>

                    <div class="col-md-12 col-lg-3">

                        <!-- Example Horizontal Form -->

                        <div class="">

                            <div class="example">

                                <div class="form-group form-material row">

                                    <div class="col-md-9">

                                        <button type="submit" class="btn btn-primary" id="wallet_transaction_recharge_wallet_button">Submit </button>

                                        <button type="reset" class="btn btn-default btn-outline">Reset</button>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- End Example Horizontal Form -->

                    </div>

                </div>

                <div class="row row-lg">

                    <!-- <button type="button" class="wallet_transaction_select_amount wallet_btn btn" value="1000">Rs. 1000</button>

                     <button type="button" class="wallet_transaction_select_amount wallet_btn btn" value="1500">Rs. 1500</button> -->

                    <button type="button" class="wallet_transaction_select_amount wallet_btn btn" value="100">Rs.

                        100</button>

                    <button type="button" class="wallet_transaction_select_amount wallet_btn btn" value="500">Rs.

                        500</button>

                    <button type="button" class="wallet_transaction_select_amount wallet_btn btn" value="2000">Rs.

                        2000</button>

                    <button type="button" class="wallet_transaction_select_amount wallet_btn btn" value="5000">Rs.

                        5000</button>
                    <button type="button" class="wallet_transaction_select_amount wallet_btn btn" value="10000">Rs.

                        10000</button>

                </div>

                </form>

            </div>

        </div>

        <!-- Panel Basic -->

        <div class="panel">

            <header class="panel-heading">

                <div class="panel-actions"></div>

                <h3 class="panel-title">Basic</h3>

            </header>

            <div class="panel-body">

                <table class="table table-striped table-borderd" id="wallet_transaction_tbl">

                    <thead>

                        <tr>

                            <th>Date</th>

                            <th>Debit</th>

                            <th>Credit</th>

                            <th>Balance</th>

                            <th>Remarks</th>

                        </tr>

                    </thead>

                    <tbody></tbody>

                </table>

            </div>

        </div>

        <!-- End Panel Basic -->

    </div>

</div>

<!-- End Page -->